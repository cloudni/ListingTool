/**
 * This program is licensed under the terms of the eBay Common Development and
 * Distribution License (CDDL) Version 1.0 (the "License") and any subsequent
 * version thereof released by eBay.  The then-current version of the License
 * can be found at http://www.opensource.org/licenses/cddl1.php
 */

package com.lt.thirdpartylibrary.ebay.client;

import java.io.File;
import java.util.Iterator;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.ebay.marketplace.services.AbortJobResponse;
import com.ebay.marketplace.services.AckValue;
import com.ebay.marketplace.services.CreateUploadJobResponse;
import com.ebay.marketplace.services.GetJobStatusResponse;
import com.ebay.marketplace.services.JobProfile;
import com.ebay.marketplace.services.JobStatus;
import com.ebay.marketplace.services.StartDownloadJobResponse;
import com.ebay.marketplace.services.StartUploadJobResponse;

/**
 *
 * @author zhuyang
 */
public class LMSClientJobs {

	private static Logger logger = LoggerFactory.getLogger("LMSClientJobs.logger");

    public static boolean end2EndUploadJob(String uploadFileName,
            String downloadFileName, String userToken) {
        logger.info("LMS Job start: uploadFileName=" + uploadFileName + " ;;; downloadFileName" + downloadFileName);
        boolean done = false;
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        FileTransferActions ftActions = new FileTransferActions(userToken);
        String jobType = null;
        // verify file to upload
        if (verifyFileForUploadJob(uploadFileName)) {
            jobType = getJobTypeFromXML(uploadFileName);
            if (jobType == null) {
                return false;
            }
        }
        
        logger.info("LMS Job 1 CreateUpload request, jobType:" + jobType);
        CreateUploadJobResponse response = bdeActions.createUploadJob(jobType);
        if (response.getAck().equals(AckValue.FAILURE) || response.getAck().equals(AckValue.PARTIAL_FAILURE)) {
            logger.error("MS Job 1 CreateUpload response, ack: " + response.getAck() + ", errorMessage: " + response.getErrorMessage().getError().get(0).getMessage());
            return (done = false);
        } else {
        	logger.info("LMS Job 1 CreateUpload response, ack:success, jobId: " + response.getJobId() + ", fileReferenceId: " + response.getFileReferenceId());
        }
        String fileReferenceId = response.getFileReferenceId();
        String jobId = response.getJobId();
        
        logger.info("LMS Job 2 uploadFile request, uploadFileName: " + uploadFileName + ", jobId: " + jobId + ", fileReferenceId: " + fileReferenceId);
        if (!ftActions.uploadFile(uploadFileName,
                jobId, fileReferenceId)) {
            return (done = false);
        } else {
        	logger.info("LMS Job 2 uploadFile response, ack: success");
        }
        
        logger.info("LMS Job 3 startUploadJob request, jobId:" + jobId);
        StartUploadJobResponse sujResponse = bdeActions.startUploadJob(jobId);
        if(AckValue.SUCCESS.equals(sujResponse.getAck())) {
        	logger.info("LMS Job 3 startUploadJob response, ack: success, jobId:" + jobId);
        } else {
        	logger.error("LMS Job 3 startUploadJob response, ack: " + sujResponse.getAck() + ", jobId:" + jobId);
        	return false;
        }
        
        done = download(downloadFileName, jobId,userToken);
        return done;
    }

    public static boolean end2EndDownloadJob(String downloadJobType,
            String downloadFileName, String userToken) throws Exception {
        logger.info("\n******\n DownloadJobEnd2End : downloadJobType=" + downloadJobType + " ;;; downloadFileName" + downloadFileName);
        boolean done = false;
        StartDownloadJobResponse sdljResp = startDownloadJob(downloadJobType, null, userToken);
        String jobid = sdljResp.getJobId();
        if (jobid == null || jobid.length() == 0) {
            sdljResp.getErrorMessage().getError().get(0);
            return (done);
        }
        return download(downloadFileName, jobid, userToken);
    }


    private static boolean download(String downloadFileName, String jobId, String userToken) {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        FileTransferActions ftActions = new FileTransferActions(userToken);
        boolean fileProcessIsDone = false;
        boolean downloadIsDone = false;
        String JobStatusQueryInterval = LMSResource.getInstance().getJobStatusQueryInterval();
        logger.info("JobStatusQueryInterval =========" +JobStatusQueryInterval );
        if (JobStatusQueryInterval.length()==0){

            JobStatusQueryInterval="10000";
        }
        
        logger.info("LMS Job 4 getJobStatus request, jobId: " + jobId);
        int getJobCount = 0;//呼叫次数
        do {
            GetJobStatusResponse getJobStatusResp = bdeActions.getJobStatus(jobId);
            if (getJobStatusResp.getAck().equals(AckValue.FAILURE)) {
            	logger.error("LMS Job 4 getJobStatus response, ack: Failure");
                return false;
            }
            List<JobProfile> jobs = getJobStatusResp.getJobProfile();
            Iterator<JobProfile> itr = jobs.iterator();
            while (itr.hasNext()) {
                JobProfile job = (JobProfile) itr.next();
                if (job.getJobStatus().equals(JobStatus.COMPLETED) && job.getPercentComplete() == 100.0) {
                	logger.info("call getJobStatus count: " + ++getJobCount + ", jobId: " + job.getJobId() + ", jobType: " + job.getJobType() + ", jobStatus: " + job.getJobStatus());
                	logger.info("LMS Job 4 getJobStatus response, ack: success");
                	fileProcessIsDone = true;
                	
                	logger.info("LMS Job 5 downloadFile request");
                    if (ftActions.downloadFile(downloadFileName, job.getJobId(), job.getFileReferenceId())) {
                        downloadIsDone = true;
                        logger.info("LMS Job 5 downloadFile response, ack: success, downloadFileName: " + downloadFileName);
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
        } while (!fileProcessIsDone);
        return downloadIsDone;
    }

    public static boolean uploadJob(String jobId, String fileReferenceId, String uploadFileName, String userToken) throws Exception {
        boolean done = false;
        // verify file to upload
        if (verifyFileForUploadJob(uploadFileName)) {
            // get JobType from the XML file
            if (getJobTypeFromXML(uploadFileName) == null) {
                return false;
            }
        }
        FileTransferActions ftActions = new FileTransferActions(userToken);
        if (ftActions.uploadFile(uploadFileName, jobId, fileReferenceId)) {
            done = true;
        }
        return done;
    }

    public static boolean downloadJob(String jobId, String fileReferenceId, String downloadFileName, String userToken) throws Exception {
        boolean done = false;
        FileTransferActions ftActions = new FileTransferActions(userToken);
        if (ftActions.downloadFile(downloadFileName, jobId, fileReferenceId)) {
            done = true;
        }
        return done;
    }

    public static boolean abortJob(String jobId, String userToken) throws Exception {
        boolean done = false;
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        AbortJobResponse response = bdeActions.abortJobs(jobId);
        if (response.getAck().equals(AckValue.FAILURE) || response.getAck().equals(AckValue.PARTIAL_FAILURE)) {
            logger.error("AbortJobResponse ack: " + response.getAck() + ", errorMessage: " + response.getErrorMessage().getError().get(0).getMessage());
            return (done = false);
        } else {
        	logger.info("AbortJobResponse ack: success, jobid:" + jobId);
        }
        return done;
    }

    public static boolean createUploadJob(String jobType, String userToken) throws Exception {
        boolean done = false;
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        bdeActions.createUploadJob(jobType);
        return done;
    }

    public static void startUploadJob(String jobId, String userToken) throws Exception {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        bdeActions.startUploadJob(jobId);
    }

    public static void getJobStatus(String jobId, String userToken) throws Exception {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        bdeActions.getJobStatus(jobId);
    }

    public static void getJobs(String conditionsStr, String userToken) throws Exception {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        bdeActions.getJobs(conditionsStr);
    }
    
    public static void createRecurringJob(String downloadJobType, int frequencyInMinutes, String userToken) throws Exception {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        bdeActions.createRecurringJob(downloadJobType, frequencyInMinutes);
    }
    
    public static void deleteRecurringJob(String recurringJobId, String userToken) {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        bdeActions.deleteRecurringJob(recurringJobId);
    }
    
    public static void getRecurringJobs(String userToken) throws Exception {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        bdeActions.getRecurringJobs();
    }

    public static StartDownloadJobResponse startDownloadJob(String downloadJobType, String startTimeString, String userToken) throws Exception {
        BulkDataExchangeActions bdeActions = new BulkDataExchangeActions(userToken);
        return (bdeActions.startDownloadJob(downloadJobType, startTimeString));
    }

    private static boolean verifyFileForUploadJob(String uploadFileName) {
        // verify file to upload
        boolean found = false;
     
    	File file = new File(uploadFileName);
    	if(file.exists()) {
            logger.info("File existence check passed.");
            found = true;
    	}
        return found;
    }

    private static String getJobTypeFromXML(String inFilename) {
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
}
