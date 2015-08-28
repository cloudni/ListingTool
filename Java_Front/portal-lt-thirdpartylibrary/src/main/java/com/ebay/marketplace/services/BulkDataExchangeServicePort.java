package com.ebay.marketplace.services;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebResult;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.xml.bind.annotation.XmlSeeAlso;

@WebService(name="BulkDataExchangeServicePort", targetNamespace="http://www.ebay.com/marketplace/services")
@SOAPBinding(parameterStyle=SOAPBinding.ParameterStyle.BARE)
@XmlSeeAlso({ObjectFactory.class})
public abstract interface BulkDataExchangeServicePort
{
  @WebMethod
  @WebResult(name="createUploadJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract CreateUploadJobResponse createUploadJob(@WebParam(name="createUploadJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") CreateUploadJobRequest paramCreateUploadJobRequest);

  @WebMethod
  @WebResult(name="startUploadJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract StartUploadJobResponse startUploadJob(@WebParam(name="startUploadJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") StartUploadJobRequest paramStartUploadJobRequest);

  @WebMethod
  @WebResult(name="abortJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract AbortJobResponse abortJob(@WebParam(name="abortJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") AbortJobRequest paramAbortJobRequest);

  @WebMethod
  @WebResult(name="getJobsResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract GetJobsResponse getJobs(@WebParam(name="getJobsRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") GetJobsRequest paramGetJobsRequest);

  @WebMethod
  @WebResult(name="getJobStatusResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract GetJobStatusResponse getJobStatus(@WebParam(name="getJobStatusRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") GetJobStatusRequest paramGetJobStatusRequest);

  @WebMethod
  @WebResult(name="startDownloadJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract StartDownloadJobResponse startDownloadJob(@WebParam(name="startDownloadJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") StartDownloadJobRequest paramStartDownloadJobRequest);

  @WebMethod
  @WebResult(name="createRecurringJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract CreateRecurringJobResponse createRecurringJob(@WebParam(name="createRecurringJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") CreateRecurringJobRequest paramCreateRecurringJobRequest);

  @WebMethod
  @WebResult(name="deleteRecurringJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract DeleteRecurringJobResponse deleteRecurringJob(@WebParam(name="deleteRecurringJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") DeleteRecurringJobRequest paramDeleteRecurringJobRequest);

  @WebMethod
  @WebResult(name="getRecurringJobsResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract GetRecurringJobsResponse getRecurringJobs(@WebParam(name="getRecurringJobsRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") GetRecurringJobsRequest paramGetRecurringJobsRequest);

  @WebMethod
  @WebResult(name="getRecurringJobExecutionStatusResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract GetRecurringJobExecutionStatusResponse getRecurringJobExecutionStatus(@WebParam(name="getRecurringJobExecutionStatusRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") GetRecurringJobExecutionStatusRequest paramGetRecurringJobExecutionStatusRequest);

  @WebMethod
  @WebResult(name="getRecurringJobExecutionHistoryResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract GetRecurringJobExecutionHistoryResponse getRecurringJobExecutionHistory(@WebParam(name="getRecurringJobExecutionHistoryRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") GetRecurringJobExecutionHistoryRequest paramGetRecurringJobExecutionHistoryRequest);

  @WebMethod
  @WebResult(name="activateRecurringJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract ActivateRecurringJobResponse activateRecurringJob(@WebParam(name="activateRecurringJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") ActivateRecurringJobRequest paramActivateRecurringJobRequest);

  @WebMethod
  @WebResult(name="suspendRecurringJobResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract SuspendRecurringJobResponse suspendRecurringJob(@WebParam(name="suspendRecurringJobRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") SuspendRecurringJobRequest paramSuspendRecurringJobRequest);

  @WebMethod
  @WebResult(name="abortRecurringJobExecutionResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract AbortRecurringJobExecutionResponse abortRecurringJobExecution(@WebParam(name="abortRecurringJobExecutionRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") AbortRecurringJobExecutionRequest paramAbortRecurringJobExecutionRequest);
}