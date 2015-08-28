package com.lt.backend.system.service.impl;

import java.io.File;
import java.util.Iterator;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.ebay.marketplace.services.CreateUploadJobResponse;
import com.ebay.marketplace.services.GetJobStatusResponse;
import com.ebay.marketplace.services.JobProfile;
import com.ebay.marketplace.services.JobStatus;
import com.lt.backend.system.service.IBulkDataExchangeService;
import com.lt.backend.system.service.IEbayLmsClientService;
import com.lt.backend.system.service.IFileTransferService;
import com.lt.thirdpartylibrary.ebay.client.CreateLMSParser;
import com.lt.thirdpartylibrary.ebay.client.LMSResource;
@Service
public class EbayLmsClientServiceImpl implements IEbayLmsClientService
{
	private Logger logger = LoggerFactory.getLogger(this.getClass());
	
	@Autowired
	private IFileTransferService fileTransferService;
	@Autowired
	private IBulkDataExchangeService bulkDataExchangeService;
	
	@Override
	public boolean end2EndUploadJob(String uploadFileName,
			String downloadFileName, String userToken, Integer ltJobId)
	{
		logger.info("LMS Job start: uploadFileName=" + uploadFileName + " ;;; downloadFileName" + downloadFileName);
       
        String jobType = null;
        // verify file to upload
        if (verifyFileForUploadJob(uploadFileName)) {
            jobType = getJobTypeFromXML(uploadFileName);
            if (jobType == null) {
                return false;
            }
        }
        
        fileTransferService.initThreadLocalPara(userToken, LMSResource.getInstance().getBulkDataExchangeURL(), ltJobId);
        bulkDataExchangeService.initThreadLocalPara(userToken, LMSResource.getInstance().getBulkDataExchangeURL(), ltJobId);
        CreateUploadJobResponse response = bulkDataExchangeService.createUploadJob(jobType);
        if (response == null) {
            return Boolean.FALSE;
        }
        
        String fileReferenceId = response.getFileReferenceId();
        String jobId = response.getJobId();
        
        if (!fileTransferService.uploadFile(uploadFileName, jobId, fileReferenceId)) {
            return Boolean.FALSE;
        }
        
        if(!bulkDataExchangeService.startUploadJob(jobId)) {
        	return Boolean.FALSE;
        }
        
        return download(downloadFileName, jobId,userToken);
	}

	private boolean download(String downloadFileName, String jobId, String userToken) {
        Boolean fileProcessIsDone = false;
        boolean downloadIsDone = false;
        String JobStatusQueryInterval = LMSResource.getInstance().getJobStatusQueryInterval();
        if (JobStatusQueryInterval.length()==0){
            JobStatusQueryInterval="10000";
        }
        
        int getJobCount = 0;//呼叫次数
        do {
        	GetJobStatusResponse getJobStatusResponse = bulkDataExchangeService.getJobStatus(jobId);
            if(fileProcessIsDone == null)
            {
            	return downloadIsDone;
            } else if(fileProcessIsDone)
            {
            	 List<JobProfile> jobs = getJobStatusResponse.getJobProfile();
                 Iterator<JobProfile> itr = jobs.iterator();
                 while (itr.hasNext()) {
                     JobProfile job = (JobProfile) itr.next();
                     if (job.getJobStatus().equals(JobStatus.COMPLETED) && job.getPercentComplete() == 100.0) {
                     	fileProcessIsDone = true;
                     	
                         if (fileTransferService.downloadFile(downloadFileName, job.getJobId(), job.getFileReferenceId())) {
                             downloadIsDone = true;
                         }
                     } else {
                         logger.info("call getJobStatus count: " + ++getJobCount + ", jobId: " + job.getJobId() + ", jobType: " + job.getJobType() + ", jobStatus: " + job.getJobStatus());
                         try {
                             logger.info( " SLEEP FOR " + JobStatusQueryInterval);
                             Thread.sleep(Integer.parseInt(JobStatusQueryInterval));
                         } catch (InterruptedException x) {
                             fileProcessIsDone = false;
                             downloadIsDone = false;
                         }
                     }
                 }
            }
        } while (!fileProcessIsDone);
        return downloadIsDone;
    }
	
	private boolean verifyFileForUploadJob(String uploadFileName) {
        // verify file to upload
        boolean found = false;
     
    	File file = new File(uploadFileName);
    	if(file.exists()) {
            logger.info("File existence check passed.");
            found = true;
    	}
        return found;
    }

    private String getJobTypeFromXML(String inFilename) {
        // get the JobType from the input xml file
        File inputXml = null;
        inputXml = new File(inFilename);
        CreateLMSParser parser = new CreateLMSParser();
        boolean parseOk = parser.parse(inputXml);
        if (!parseOk) {
            logger.warn("Failed to extract the JobType from the file [" + inFilename + "]");
            return null;
        }

        // extract the JObType String successfully
        String jobType = parser.getJobType();
        if (jobType == null) {
            logger.warn("Invalid job type in the XML file.");
        } else {
            logger.info("Found the job type from the XML file, it is " + jobType);
        }
        return jobType;
    }

	@Override
	public boolean abortJob(String userToken, String jobId)
	{
		bulkDataExchangeService.initThreadLocalPara(userToken, LMSResource.getInstance().getBulkDataExchangeURL(), null);
		return bulkDataExchangeService.abortJobs(jobId);
	}
}
