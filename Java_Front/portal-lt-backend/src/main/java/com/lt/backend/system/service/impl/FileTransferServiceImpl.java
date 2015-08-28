package com.lt.backend.system.service.impl;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.zip.GZIPOutputStream;

import javax.activation.DataHandler;
import javax.activation.FileDataSource;
import javax.xml.ws.BindingProvider;
import javax.xml.ws.handler.MessageContext;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.ebay.marketplace.services.AckValue;
import com.ebay.marketplace.services.DownloadFileRequest;
import com.ebay.marketplace.services.DownloadFileResponse;
import com.ebay.marketplace.services.FileAttachment;
import com.ebay.marketplace.services.FileTransferService;
import com.ebay.marketplace.services.FileTransferServicePort;
import com.ebay.marketplace.services.UploadFileRequest;
import com.ebay.marketplace.services.UploadFileResponse;
import com.lt.backend.system.service.IFileTransferService;
import com.lt.backend.system.util.FileTransferException;
import com.lt.backend.system.util.StreamUtils;
import com.lt.dao.mapper.TrackingTagJobErrorDetailMapper;
import com.lt.dao.model.TrackingTagJobErrorDetail;
import com.lt.thirdpartylibrary.ebay.client.LoggingHandler;

@Service
public class FileTransferServiceImpl implements IFileTransferService
{
	private Logger logger = LoggerFactory.getLogger(this.getClass());
	@Autowired
	private TrackingTagJobErrorDetailMapper trackingTagJobErrorDetailMapper;
	
	private static final ThreadLocal<String> userTokenLocal = new ThreadLocal<String>();
	private static final ThreadLocal<String> serverUrlLocal = new ThreadLocal<String>();
	private static final ThreadLocal<Integer> ltJobIdLocal = new ThreadLocal<Integer>();
	
	private static final Integer STEP_2 = 2;
	private static final Integer STEP_5 = 5;
	
	@Override
	public void initThreadLocalPara(String userToken, String serverUrl, Integer ltJobId) {
		userTokenLocal.set(userToken);
		serverUrlLocal.set(serverUrl);
		ltJobIdLocal.set(ltJobId);
	}
	
	@Override
	public boolean uploadFile(String xmlFile,String jobId, String fileReferenceId){
        String callName = "uploadFile";
        boolean uploadOK = false;
        try {
        	String compressedFileName = compressFileToGzip(xmlFile);
            
            FileTransferServicePort port = setFTSMessageContext(callName);
            
            UploadFileRequest request = new UploadFileRequest();
            FileAttachment attachment = new FileAttachment();
            File fileToUpload = new File(compressedFileName);
            DataHandler dh = new DataHandler(new FileDataSource(fileToUpload));
            attachment.setData(dh);
            attachment.setSize(fileToUpload.length());
            String fileFormat = "gzip";
            request.setFileFormat(fileFormat);
            /*
             *For instance, the Bulk Data Exchange Service uses a job ID as a primary identifier,
             * so, if you're using the Bulk Data Exchange Service, enter the job ID as the taskReferenceId.
             */

            request.setTaskReferenceId(jobId);
            request.setFileReferenceId(fileReferenceId);
            request.setFileAttachment(attachment);
          
            UploadFileResponse response = port.uploadFile(request);
            if (response.getAck().equals(AckValue.SUCCESS)) {
            	uploadOK = !uploadOK;
            }else {
                logger.error(response.getErrorMessage().getError().get(0).getMessage());
                TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
                detail.setEbayJobId(jobId);
                detail.setEbayDownFileRefId(fileReferenceId);
                detail.setErrorMessage(response.getErrorMessage().getError().get(0).getMessage());
                detail.setTrackingTagJobId(ltJobIdLocal.get());
                detail.setStep(STEP_2);
                trackingTagJobErrorDetailMapper.insertSelective(detail);
            }
        } catch (Exception e) {
        	TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
            detail.setEbayJobId(jobId);
            detail.setEbayDownFileRefId(fileReferenceId);
            detail.setErrorMessage(e.getMessage());
            detail.setTrackingTagJobId(ltJobIdLocal.get());
            detail.setStep(STEP_2);
            trackingTagJobErrorDetailMapper.insertSelective(detail);
        }
        
        return uploadOK;
    }
	
	@Override
    public boolean downloadFile(String fileName, String jobId,String fileReferenceId) {
        String callName = "downloadFile";
        boolean downloadOK = false;
        
        InputStream in = null;
        BufferedInputStream bis = null;
        FileOutputStream fos = null;
        BufferedOutputStream bos = null;
        try {
        	 FileTransferServicePort port = setFTSMessageContext(callName);
             DownloadFileRequest request = new DownloadFileRequest();
             request.setFileReferenceId(fileReferenceId);
             request.setTaskReferenceId(jobId);
             DownloadFileResponse response = port.downloadFile(request);
             if (response.getAck().equals(AckValue.SUCCESS)) {
                 downloadOK = !downloadOK;
             }else {
                  logger.error("callName:downloadFile;" + "jobId:" + jobId + ";fileReferenceId:" + fileReferenceId + "erroMessage:" + response.getErrorMessage().getError().get(0).getMessage());
                  
                  TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
                  detail.setEbayJobId(jobId);
                  detail.setEbayDownFileRefId(fileReferenceId);
                  detail.setErrorMessage(response.getErrorMessage().getError().get(0).getMessage());
                  detail.setTrackingTagJobId(ltJobIdLocal.get());
                  detail.setStep(STEP_5);
                  trackingTagJobErrorDetailMapper.insertSelective(detail);
                  return downloadOK;
             }
             FileAttachment attachment = response.getFileAttachment();
             DataHandler dh = attachment.getData();
            
             in = dh.getInputStream();
             bis = new BufferedInputStream(in);

             fos = new FileOutputStream(new File(fileName)); // "C:/myDownLoadFile.gz"
             bos = new BufferedOutputStream(fos);
             
             int bytes_read = 0;
             byte[] dataBuf = new byte[4096];
             while ((bytes_read = bis.read(dataBuf)) != -1) {
                 bos.write(dataBuf, 0, bytes_read);
             }
             
             logger.info("File attachment has been saved successfully to " + fileName);
        } catch (Exception e) {
        	logger.error("save file attachment fail\n" + e.getMessage(), e);
        	TrackingTagJobErrorDetail detail = new TrackingTagJobErrorDetail();
            detail.setEbayJobId(jobId);
            detail.setEbayDownFileRefId(fileReferenceId);
            detail.setErrorMessage(e.getMessage());
            detail.setTrackingTagJobId(ltJobIdLocal.get());
            detail.setStep(STEP_5);
            trackingTagJobErrorDetailMapper.insertSelective(detail);
        }finally {
         	StreamUtils.closeInputStream(in);
         	StreamUtils.closeInputStream(bis);
         	StreamUtils.closeOutputStream(fos);
         	StreamUtils.closeOutputStream(bos);
         }
       
        return downloadOK;
    }

    private String compressFileToGzip(String inFilename) {
        // compress the xml file into gz file in the save folder
        String outFilename = null;
        String usingPath = inFilename.substring(0, inFilename.lastIndexOf(File.separator) + 1);
        String fileName = inFilename.substring(inFilename.lastIndexOf(File.separator) + 1);
        outFilename = usingPath + fileName + ".gz";
        
        BufferedReader br = null;
        FileReader fr = null;
        FileOutputStream fos = null;
        GZIPOutputStream gos = null;
        BufferedOutputStream bos = null;
        try {
        	fr = new FileReader(inFilename);
            br = new BufferedReader(fr);
            
            fos = new FileOutputStream(outFilename);
            gos = new GZIPOutputStream(fos);
            bos = new BufferedOutputStream(gos);
            logger.info("Writing gz file...");
            int c;
            while ((c = fr.read()) != -1) {
            	bos.write(c);
            }
        } catch (FileNotFoundException e) {
        	logger.error(e.getMessage(), e);
        } catch (IOException e) {
        	logger.error(e.getMessage(), e);
        } finally {
        	StreamUtils.closeReader(fr);
        	StreamUtils.closeReader(br);
        	StreamUtils.closeOutputStream(fos);
        	StreamUtils.closeOutputStream(gos);
        	StreamUtils.closeOutputStream(bos);
        }
        logger.info("The compressed file has been saved to " + outFilename);
        return outFilename;
    }

    public FileTransferServicePort setFTSMessageContext(String callName) throws FileTransferException{
    	 logger.debug("serverURL :" + serverUrlLocal.get());
         if (serverUrlLocal.get() == null) {
             logger.error(" serverURL can't be null ");
             throw new FileTransferException("serverURL can't be null");
         }
         if (userTokenLocal.get() == null) {
         	logger.error(" User Token can't be null ");
         	throw new FileTransferException("User Token can't be null");
         }
         
        FileTransferService service = new FileTransferService();
        FileTransferServicePort port = service.getFileTransferServiceSOAP();
        BindingProvider bp = (BindingProvider) port;

        bp.getRequestContext().put(BindingProvider.ENDPOINT_ADDRESS_PROPERTY, serverUrlLocal.get());
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
        // set http address
        requestProperties.put(BindingProvider.ENDPOINT_ADDRESS_PROPERTY, serverUrlLocal.get());
        Map<String, List<String>> httpHeaders = new HashMap<String, List<String>>();
        httpHeaders.put("X-EBAY-SOA-MESSAGE-PROTOCOL", Collections.singletonList("SOAP12"));
        httpHeaders.put("X-EBAY-SOA-OPERATION-NAME", Collections.singletonList(callName));
        httpHeaders.put("X-EBAY-SOA-SECURITY-TOKEN", Collections.singletonList(userTokenLocal.get()));
        requestProperties.put(MessageContext.HTTP_REQUEST_HEADERS, httpHeaders);
        return port;

    }
}
