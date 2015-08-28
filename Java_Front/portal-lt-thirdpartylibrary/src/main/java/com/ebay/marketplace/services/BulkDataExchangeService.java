package com.ebay.marketplace.services;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.logging.Logger;

import javax.xml.namespace.QName;
import javax.xml.ws.Service;
import javax.xml.ws.WebEndpoint;
import javax.xml.ws.WebServiceClient;
import javax.xml.ws.WebServiceFeature;

@WebServiceClient(name="BulkDataExchangeService", targetNamespace="http://www.ebay.com/marketplace/services", wsdlLocation="http://developer.ebay.com/webservices/bulk-data-exchange/latest/BulkDataExchangeService.wsdl")
public class BulkDataExchangeService extends Service
{
  private static final URL BULKDATAEXCHANGESERVICE_WSDL_LOCATION;
  private static final Logger logger = Logger.getLogger(BulkDataExchangeService.class.getName());

  public BulkDataExchangeService(URL wsdlLocation, QName serviceName)
  {
    super(wsdlLocation, serviceName);
  }

  public BulkDataExchangeService() {
    super(BULKDATAEXCHANGESERVICE_WSDL_LOCATION, new QName("http://www.ebay.com/marketplace/services", "BulkDataExchangeService"));
  }

  @WebEndpoint(name="BulkDataExchangeServiceHttp")
  public BulkDataExchangeServicePort getBulkDataExchangeServiceHttp()
  {
    return (BulkDataExchangeServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "BulkDataExchangeServiceHttp"), BulkDataExchangeServicePort.class);
  }

  @WebEndpoint(name="BulkDataExchangeServiceHttp")
  public BulkDataExchangeServicePort getBulkDataExchangeServiceHttp(WebServiceFeature[] features)
  {
    return (BulkDataExchangeServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "BulkDataExchangeServiceHttp"), BulkDataExchangeServicePort.class, features);
  }

  @WebEndpoint(name="BulkDataExchangeServiceSOAP")
  public BulkDataExchangeServicePort getBulkDataExchangeServiceSOAP()
  {
    return (BulkDataExchangeServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "BulkDataExchangeServiceSOAP"), BulkDataExchangeServicePort.class);
  }

  @WebEndpoint(name="BulkDataExchangeServiceSOAP")
  public BulkDataExchangeServicePort getBulkDataExchangeServiceSOAP(WebServiceFeature[] features)
  {
    return (BulkDataExchangeServicePort)super.getPort(new QName("http://www.ebay.com/marketplace/services", "BulkDataExchangeServiceSOAP"), BulkDataExchangeServicePort.class, features);
  }

  static
  {
    URL url = null;
    try
    {
      URL baseUrl = BulkDataExchangeService.class.getResource(".");
      url = new URL(baseUrl, "http://developer.ebay.com/webservices/bulk-data-exchange/latest/BulkDataExchangeService.wsdl");
    } catch (MalformedURLException e) {
      logger.warning("Failed to create URL for the wsdl Location: 'http://developer.ebay.com/webservices/bulk-data-exchange/latest/BulkDataExchangeService.wsdl', retrying as a local file");
      logger.warning(e.getMessage());
    }
    BULKDATAEXCHANGESERVICE_WSDL_LOCATION = url;
  }
}