package com.lt.backend.system.service.impl;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Collections;
import java.util.GregorianCalendar;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import javax.xml.datatype.DatatypeConfigurationException;
import javax.xml.datatype.DatatypeFactory;
import javax.xml.datatype.XMLGregorianCalendar;
import javax.xml.ws.BindingProvider;
import javax.xml.ws.handler.MessageContext;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.ebay.marketplace.services.AbortJobRequest;
import com.ebay.marketplace.services.AbortJobResponse;
import com.ebay.marketplace.services.AckValue;
import com.ebay.marketplace.services.BulkDataExchangeService;
import com.ebay.marketplace.services.BulkDataExchangeServicePort;
import com.ebay.marketplace.services.CreateUploadJobRequest;
import com.ebay.marketplace.services.CreateUploadJobResponse;
import com.ebay.marketplace.services.GetJobStatusRequest;
import com.ebay.marketplace.services.GetJobStatusResponse;
import com.ebay.marketplace.services.GetJobsRequest;
import com.ebay.marketplace.services.GetJobsResponse;
import com.ebay.marketplace.services.JobProfile;
import com.ebay.marketplace.services.JobStatus;
import com.ebay.marketplace.services.StartUploadJobRequest;
import com.ebay.marketplace.services.StartUploadJobResponse;
import com.lt.backend.system.service.IBulkDataExchangeService;
import com.lt.backend.system.util.FileTransferException;
import com.lt.dao.mapper.TrackingTagJobErrorDetailMapper;
import com.lt.dao.model.TrackingTagJobErrorDetail;
import com.lt.thirdpartylibrary.ebay.client.LoggingHandler;

@Service
public class BulkDataExchangeServiceImpl implements IBulkDataExchangeService
{
	private Logger logger = LoggerFactory.getLogger(this.getClass());
	@Autowired
	private TrackingTagJobErrorDetailMapper trackingTagJobErrorDetailMapper;
	
	private static final ThreadLocal<String> userTokenLocal = new ThreadLocal<String>();
	private static final ThreadLocal<String> serverUrlLocal = new ThreadLocal<String>();
	private static final ThreadLocal<Integer> ltJobIdLocal = new ThreadLocal<Integer>();
	
	private static final Integer STEP_1 = 1;
	private static final Integer STEP_3 = 3;
	private static final Integer STEP_4 = 4;
	
	private static final String ERROR_LOG_FORMAT = "LMS CALL ERROR. [jobId : %s; step: %s; ack : %s; errorMessage : %s";
	
	@Override
	public void initThreadLocalPara(String userToken, String serverUrl, Integer ltJobId) {
		userTokenLocal.set(userToken);
		serverUrlLocal.set(serverUrl);
		ltJobIdLocal.set(ltJobId);
	}
	
	public CreateUploadJobResponse createUploadJob(String uploadJobType) {
        String callName = "createUploadJob";
        try {
        	 BulkDataExchangeServicePort port = setRequestContext(callName);
             CreateUploadJobRequest createUploadJobReq = new CreateUploadJobRequest();
             createUploadJobReq.setUploadJobType(uploadJobType);// ("AddFixedPriceItem");
             String uuid = java.util.UUID.randomUUID().toString();
             createUploadJobReq.setUUID(uuid);
             // process result here
             CreateUploadJobResponse response = port.createUploadJob(createUploadJobReq);
             if (response.getAck().equals(AckValue.FAILURE) || response.getAck().equals(AckValue.PARTIAL_FAILURE)) {
                 logger.error(ERROR_LOG_FORMAT, response.getJobId(), STEP_1, response.getAck(), response.getErrorMessage().getError().get(0).getMessage());
                 TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
                 detail.setEbayJobId(response.getJobId());
                 detail.setErrorMessage(response.getErrorMessage().getError().get(0).getMessage());
                 detail.setTrackingTagJobId(ltJobIdLocal.get());
                 detail.setStep(STEP_1);
                 trackingTagJobErrorDetailMapper.insertSelective(detail);
                 return null;
             } else {
             	logger.debug("LMS Job 1 CreateUpload response, ack:success, jobId: " + response.getJobId() + ", fileReferenceId: " + response.getFileReferenceId());
             }
             return response;
        } catch (Exception e) {
        	logger.error(ERROR_LOG_FORMAT, "", STEP_1, "error", e.getMessage());
        	TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
            detail.setErrorMessage(e.getMessage());
            detail.setTrackingTagJobId(ltJobIdLocal.get());
            detail.setStep(STEP_1);
            trackingTagJobErrorDetailMapper.insertSelective(detail);
        }
        return null;
    }// ENDOF createUploadJob()
	
	 public boolean startUploadJob(String jobid) {
        String callName = "startUploadJob";
        try {
        	 BulkDataExchangeServicePort port = setRequestContext(callName);
             StartUploadJobRequest request = new StartUploadJobRequest();
             request.setJobId(jobid);
             StartUploadJobResponse response = port.startUploadJob(request);
             
             if(AckValue.SUCCESS.equals(response.getAck())) {
             	logger.debug("LMS Job 3 startUploadJob response, ack: success, jobId:" + jobid);
             	return Boolean.TRUE;
             } else {
            	logger.error(ERROR_LOG_FORMAT, request.getJobId(), STEP_3, response.getAck(), response.getErrorMessage().getError().get(0).getMessage());
            	TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
                detail.setErrorMessage(response.getErrorMessage().getError().get(0).getMessage());
                detail.setTrackingTagJobId(ltJobIdLocal.get());
                detail.setStep(STEP_3);
                trackingTagJobErrorDetailMapper.insertSelective(detail);
                return Boolean.FALSE;
             }
            
        } catch (Exception e) {
        	logger.error(ERROR_LOG_FORMAT, "", STEP_3, "error", e.getMessage());
        	TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
            detail.setErrorMessage(e.getMessage());
            detail.setTrackingTagJobId(ltJobIdLocal.get());
            detail.setStep(STEP_3);
            trackingTagJobErrorDetailMapper.insertSelective(detail);
        }
       return Boolean.FALSE;
    } // ENDOF startUploadJob();
	 
	 public GetJobStatusResponse getJobStatus(String jobId) {
		String callName = "getJobStatus";
		GetJobStatusResponse response = null;
		try {
			BulkDataExchangeServicePort port = setRequestContext(callName);
	        GetJobStatusRequest request = new GetJobStatusRequest();
	        request.setJobId(jobId);
	        response = port.getJobStatus(request);
	        
	        if (response.getAck().equals(AckValue.FAILURE)) {
            	logger.error(ERROR_LOG_FORMAT);
                return null;
            }
            List<JobProfile> jobs = response.getJobProfile();
            Iterator<JobProfile> itr = jobs.iterator();
            while (itr.hasNext()) {
                JobProfile job = (JobProfile) itr.next();
                return response;
            }
		} catch (Exception e) {
			logger.error(ERROR_LOG_FORMAT, "", STEP_4, "error", e.getMessage());
			TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
            detail.setErrorMessage(e.getMessage());
            detail.setTrackingTagJobId(ltJobIdLocal.get());
            detail.setStep(STEP_4);
            trackingTagJobErrorDetailMapper.insertSelective(detail);
		}
       
       return response;
    }//ENDOF getJobStatus()
	
	public GetJobsResponse getJobs(String conditionsStr) {
        String callName = "getJobs";
        try {
        	BulkDataExchangeServicePort port = setRequestContext(callName);
            GetJobsRequest getJobsReq = new GetJobsRequest();

            if (conditionsStr != null && conditionsStr.length() > 0) {
                XMLGregorianCalendar fromCal = null;
                // validating the input conditions
                XMLGregorianCalendar toCal = null;
                // java.util.Map<String, String> conditions = getPairs(conditionsStr, "&");
                java.util.Map<String, String> conditions = getPairs(conditionsStr, "&");
                if (conditions.get("creationTimeFrom") != null && !conditions.get("creationTimeFrom").equals("")) {
                    fromCal = parseDate(conditions.get("creationTimeFrom"));
                    if (fromCal == null) {
                        logger.info("Criteria creationTimeFrom has been ignored.");
                    }
                    getJobsReq.setCreationTimeFrom(fromCal);
                }
                if (conditions.get("creationTimeTo") != null && !conditions.get("creationTimeTo").equals("")) {
                    toCal = parseDate(conditions.get("creationTimeTo"));
                    if (toCal == null) {
                        logger.info("Criteria creationTimeTo has been ignored.");
                    }
                    getJobsReq.setCreationTimeTo(toCal);
                }

                if (conditions.get("jobType") != null && !conditions.get("jobType").equals("")) {
                    List<String> jobType = getJobsReq.getJobType();
                    jobType.add(conditions.get("jobType"));
                }

                if (conditions.get("jobStatus") != null && !conditions.get("jobStatus").equals("")) {
                    logger.info(" jobStatus condition= " + conditions.get("jobStatus").toString());
                    List<JobStatus> jobStatuss = getJobsReq.getJobStatus();
                    try {
                        jobStatuss.add(JobStatus.fromValue(conditions.get("jobStatus")));
                    } catch (java.lang.IllegalArgumentException e) {
                        logger.error("Service call failed on the client side. \nThe input jobStatus is not valid, please check it and try again.");
                        return null;
                    }
                }
            }
            GetJobsResponse getJobsResp = port.getJobs(getJobsReq);
            List<JobProfile> jobs = getJobsResp.getJobProfile();
            Iterator<JobProfile> itr = jobs.iterator();
            while (itr.hasNext()) {
                JobProfile job = (JobProfile) itr.next();
                logger.info(job.getJobId() + " : " + job.getJobType() + " : " + job.getJobStatus());
            }
            
            return getJobsResp;
        } catch (Exception e) {
        	logger.error("lms getJobs fail: para[" + conditionsStr + "]\n" + e.getMessage(), e);
        }
        return null;
    }//ENDOF getJobs()
	
	@Override
	public GetJobsResponse getCreateJobs(String conditionsStr)
	{
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public boolean abortJobs(String jobId)
	{
		String callName = "abortJob";
		try {
			BulkDataExchangeServicePort port = setRequestContext(callName);
	        AbortJobRequest abortJobsReq = new AbortJobRequest();
	        abortJobsReq.setJobId(jobId);
	        AbortJobResponse response = port.abortJob(abortJobsReq);
	        if (response.getAck().equals(AckValue.FAILURE) || response.getAck().equals(AckValue.PARTIAL_FAILURE)) {
	            logger.error("AbortJobResponse ack: " + response.getAck() + ", errorMessage: " + response.getErrorMessage().getError().get(0).getMessage());
	           
	        } else {
	            logger.debug("AbortJobResponse ack: success, jobid:" + jobId);
	        }
		} catch (Exception e) {
			logger.error("abortJobs error, jobId:" + jobId + e.getMessage(), e);
		}
        
		return Boolean.FALSE;
	}
	
	 /*
     * util method, construct the Calendar object from the input string,
     * it accepts format of "yyyy-MM-dd"
     */
    private static XMLGregorianCalendar parseDate(String cal) throws DatatypeConfigurationException {
        GregorianCalendar ret = null;
        SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd");
        try {
            df.parse(cal);
            String[] parts = cal.split("-");
            ret = (GregorianCalendar) Calendar.getInstance();
            ret.set(Integer.parseInt(parts[0]), Integer.parseInt(parts[1]) - 1,
                    Integer.parseInt(parts[2]), 0, 0, 0);
        // get here and we know the format is correct
        } catch (ParseException e) {
            System.out.println("ParseException caught when parsing your date string, please fix it and retry.");
            return null;
        }
        DatatypeFactory factory = DatatypeFactory.newInstance();
        XMLGregorianCalendar xmlGregorianCalendar = factory.newXMLGregorianCalendar(ret);
        return xmlGregorianCalendar;
    }
    
    /*
     * getPairs method parse the getJobs condition String, and put the name
     * value pair in to Map object for easier accessing. Sample condition string
     * can be:
     * "creationTimeFrom=2008-09-01&creationTimeTo=2008-10-02&jobType=RelistItem&jobStatus=Failed"
     * if the delimited char is "&"
     */
    public static Map<String, String> getPairs(String pairs, String splitStr) {
        if (pairs == null || pairs.equals("")) {
            return null;
        }
        String[] reqFields = pairs.split(splitStr);
        Map<String, String> parameterMap = new HashMap<String, String>();
        for (int i = 0; i < reqFields.length; i++) {
            String nameValuepair = reqFields[i];
            String[] nameValueArray = nameValuepair.split("=");
            parameterMap.put(nameValueArray[0].trim(),
                    nameValueArray.length <= 1 ? null : nameValueArray[1].trim());
        }
        return parameterMap;
    }
	
	public BulkDataExchangeServicePort setRequestContext(String callName) throws FileTransferException {

		String serverURL = serverUrlLocal.get();
		String userToken = userTokenLocal.get();
		logger.debug("serverURL :" + serverUrlLocal.get());
        if (serverURL == null) {
            logger.error(" serverURL can't be null ");
            throw new FileTransferException("serverURL can't be null");
        }
        if (userToken == null) {
        	logger.error(" User Token can't be null ");
        	throw new FileTransferException("User Token can't be null");
        }

        BulkDataExchangeServicePort port = null;
        // Call Web Service Operation
        BulkDataExchangeService service = new BulkDataExchangeService();
        port = service.getBulkDataExchangeServiceSOAP();
        BindingProvider bp = (BindingProvider) port;
        // Add the logging handler
        List handlerList = bp.getBinding().getHandlerChain();
        if (handlerList == null) {
            handlerList = new ArrayList();
        }
        LoggingHandler loggingHandler = new LoggingHandler();
        handlerList.add(loggingHandler);
        // register the handerList
        bp.getBinding().setHandlerChain(handlerList);
        // initialize WS operation arguments here
        Map requestProperties = bp.getRequestContext();
        requestProperties.put(BindingProvider.ENDPOINT_ADDRESS_PROPERTY, serverURL);
       
        Map<String, List<String>> httpHeaders = new HashMap<String, List<String>>();
        httpHeaders.put("X-EBAY-SOA-MESSAGE-PROTOCOL", Collections.singletonList("SOAP11"));
        httpHeaders.put("X-EBAY-SOA-OPERATION-NAME", Collections.singletonList(callName));
        httpHeaders.put("X-EBAY-SOA-SECURITY-TOKEN", Collections.singletonList(userToken));
        requestProperties.put(MessageContext.HTTP_REQUEST_HEADERS, httpHeaders);
        //http://developer.ebay.com/DevZone/bulk-data-exchange/CallRef/createUploadJob.html#Request.uploadJobType

        return port;
    }
}
