package com.lt.thirdpartylibrary.ebay.base;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.ebay.sdk.TokenEventListener;
import com.ebay.sdk.util.eBayUtil;

public class EbayApiUtilTokenEventListener implements TokenEventListener {
	private static Logger logger = LoggerFactory.getLogger(EbayApiUtilTokenEventListener.class);
	EbayApiUtil ebayApiUtil;
	
	public EbayApiUtilTokenEventListener(EbayApiUtil ebayApiUtil) {
		this.ebayApiUtil = ebayApiUtil;
	}
	
	 public void renewToken(String newToken)
	  {
		 logger.info("eBay Token has been renewed successfully!");
	  }

	  public void warnHardExpiration(java.util.Date expirationDate)
	  {
		  logger.info("Received token hard-expiration-warning: " + eBayUtil.toAPITimeString(expirationDate));
	  }
}
