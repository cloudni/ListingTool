package com.ebay.marketplace.services;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.logging.Logger;
import javax.xml.namespace.QName;
import javax.xml.ws.Service;
import javax.xml.ws.WebEndpoint;
import javax.xml.ws.WebServiceClient;
import javax.xml.ws.WebServiceFeature;

@WebServiceClient(name="FileTransferService", targetNamespace="http://www.ebay.com/marketplace/services", wsdlLocation="http://developer.ebay.com/webservices/file-transfer/latest/FileTransferService.wsdl")
public class FileTransferService extends Service
{
  private static final URL FILETRANSFERSERVICE_WSDL_LOCATION;
  private static final Logger logger = Logger.getLogger(FileTransferService.class.getName());

  public FileTransferService(URL wsdlLocation, QName serviceName)
  {
    super(wsdlLocation, serviceName);
  }

  public FileTransferService() {
    super(FILETRANSFERSERVICE_WSDL_LOCATION, new QName("http://www.ebay.com/marketplace/services", "FileTransferService"));
  }

  @WebEndpoint(name="FileTransferServiceSOAP")
  public FileTransferServicePort getFileTransferServiceSOAP()
  {
    return (FileTransferServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "FileTransferServiceSOAP"), FileTransferServicePort.class);
  }

  @WebEndpoint(name="FileTransferServiceSOAP")
  public FileTransferServicePort getFileTransferServiceSOAP(WebServiceFeature[] features)
  {
    return (FileTransferServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "FileTransferServiceSOAP"), FileTransferServicePort.class, features);
  }

  @WebEndpoint(name="FileTransferServiceHttp")
  public FileTransferServicePort getFileTransferServiceHttp()
  {
    return (FileTransferServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "FileTransferServiceHttp"), FileTransferServicePort.class);
  }

  @WebEndpoint(name="FileTransferServiceHttp")
  public FileTransferServicePort getFileTransferServiceHttp(WebServiceFeature[] features)
  {
    return (FileTransferServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "FileTransferServiceHttp"), FileTransferServicePort.class, features);
  }

  static
  {
    URL url = null;
    try
    {
      URL baseUrl = FileTransferService.class.getResource(".");
      url = new URL(baseUrl, "http://developer.ebay.com/webservices/file-transfer/latest/FileTransferService.wsdl");
    } catch (MalformedURLException e) {
      logger.warning("Failed to create URL for the wsdl Location: 'http://developer.ebay.com/webservices/file-transfer/latest/FileTransferService.wsdl', retrying as a local file");
      logger.warning(e.getMessage());
    }
    FILETRANSFERSERVICE_WSDL_LOCATION = url;
  }
}