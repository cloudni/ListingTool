package com.ebay.marketplace.services;

import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebResult;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.xml.bind.annotation.XmlSeeAlso;

@WebService(name="FileTransferServicePort", targetNamespace="http://www.ebay.com/marketplace/services")
@SOAPBinding(parameterStyle=SOAPBinding.ParameterStyle.BARE)
@XmlSeeAlso({ObjectFactory.class})
public abstract interface FileTransferServicePort
{
  @WebMethod(action="urn:uploadFile")
  @WebResult(name="uploadFileResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract UploadFileResponse uploadFile(@WebParam(name="uploadFileRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") UploadFileRequest paramUploadFileRequest);

  @WebMethod(action="urn:downloadFile")
  @WebResult(name="downloadFileResponse", targetNamespace="http://www.ebay.com/marketplace/services", partName="params")
  public abstract DownloadFileResponse downloadFile(@WebParam(name="downloadFileRequest", targetNamespace="http://www.ebay.com/marketplace/services", partName="params") DownloadFileRequest paramDownloadFileRequest);
}