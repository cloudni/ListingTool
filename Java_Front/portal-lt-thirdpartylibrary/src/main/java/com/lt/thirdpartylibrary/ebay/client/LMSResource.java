package com.lt.thirdpartylibrary.ebay.client;

import java.io.InputStream;
import java.util.Properties;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class LMSResource {
	protected static Logger logger = LoggerFactory.getLogger("LMSResource.logger");
	
	private static final LMSResource resource = new LMSResource();
	private Properties lmsPro = null;
	
	private LMSResource(){
		lmsPro = new Properties();

		try {
			InputStream is = this.getClass().getResourceAsStream("/lt_ebay_lms.properties");
			lmsPro.load(is);
		} catch(Exception e) {
			logger.error("load lt_ebay.properties fail " + e.getMessage(), e);
		}
	}
	
	public static LMSResource getInstance() {
		return resource;
	}
	
	public String getReource(String key) {
		return lmsPro.get(key) == null ? "" : lmsPro.get(key).toString();
	}
	
	public String getBulkDataExchangeURL() {
		return getReource(LMSConstants.BLUK_DATE_EXCHANGE_URL);
	}
	
	public String getFileTransferURL() {
		return getReource(LMSConstants.FILE_TRANSFER_URL);
	}
	
	public String getJobStatusQueryInterval() {
		return getReource(LMSConstants.GET_JOB_STATUS_QUERY_INTERVAL);
	}
	
	public String getLogging() {
		return getReource(LMSConstants.LOGGING);
	}
	
	public static void main(String[] args)
	{
		String str = LMSResource.getInstance().getBulkDataExchangeURL();
		System.out.println(str);
	}
}
