package com.lt.thirdpartylibrary.paypal.service.impl;

import java.util.Date;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.dao.mapper.TransactionAccessTokenMapper;
import com.lt.dao.model.TransactionAccessToken;
import com.lt.platform.framework.core.redis.RedisCacheUtli;
import com.lt.platform.util.time.DateFormatUtil;
import com.lt.thirdpartylibrary.paypal.service.ITransactionAccessTokenService;
import com.lt.thirdpartylibrary.paypal.util.PaypalConstant;
import com.paypal.base.rest.OAuthTokenCredential;
import com.paypal.base.rest.PayPalResource;

@Service
public class TransactionAccessTokenServiceImpl implements ITransactionAccessTokenService
{
	private static Logger logger = LoggerFactory.getLogger(TransactionAccessTokenServiceImpl.class);
	private static final String ACCESS_TOKEN = "accessToken";
	private static final String DEFAULT_ACCESS_TOKEN_MAX_AGE = "defaultAccessTokenMaxAge";
	
	@Autowired
	private TransactionAccessTokenMapper transactionAccessTokenMapper;
	
	public String getAccessToken() throws Exception
	{
		String accessToken = null;
		Long defaultAccessTokenMaxAge = null;
		String defaultAccessTokenMaxAgeStr = null;
		synchronized (TransactionAccessTokenServiceImpl.class)
		{
			long currentLong = new Date().getTime();
			TransactionAccessToken token = null;
			
			try {
				accessToken = RedisCacheUtli.getString(ACCESS_TOKEN);
				defaultAccessTokenMaxAgeStr = RedisCacheUtli.getString(DEFAULT_ACCESS_TOKEN_MAX_AGE);
			} catch (Exception e) {
				//logger.error("get access token from radis fail:" + e.getMessage(), e);
				
				token = transactionAccessTokenMapper.selectEnabled();
				if(token != null) {
					accessToken = token.getAccessToken();
					defaultAccessTokenMaxAgeStr = token.getLiftCycle() == null?"":token.getLiftCycle()+"";
				}
			}
			
			boolean getAccessFlag = false;
			if(defaultAccessTokenMaxAgeStr == null) 
			{
				getAccessFlag = true;
			} else
			{
				defaultAccessTokenMaxAge = Long.parseLong(defaultAccessTokenMaxAgeStr);
				if(currentLong + PaypalConstant.SAFETY_TIME > defaultAccessTokenMaxAge)
				{
					getAccessFlag = true;
				}
			}
			if(getAccessFlag) 
			{
				OAuthTokenCredential oAuthTokenCredential = PayPalResource.getOAuthTokenCredential();
				accessToken = oAuthTokenCredential.getAccessToken();
				defaultAccessTokenMaxAge = oAuthTokenCredential.expiresIn()*1000 + new Date().getTime();
				
				try {
					RedisCacheUtli.setString(ACCESS_TOKEN, accessToken);
					RedisCacheUtli.setString(DEFAULT_ACCESS_TOKEN_MAX_AGE, defaultAccessTokenMaxAge + "");
				} catch (Exception e) {
					//logger.error("set access token from radis fail:" + e.getMessage(), e);
					
					if(token != null) {
						token.setEnabled(Boolean.FALSE);
						transactionAccessTokenMapper.updateByPrimaryKeySelective(token);
					}
					
					TransactionAccessToken newToken = new TransactionAccessToken();
					newToken.setAccessToken(accessToken);
					newToken.setLiftCycle(defaultAccessTokenMaxAge);
					newToken.setEnabled(Boolean.TRUE);
					newToken.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
					transactionAccessTokenMapper.insertSelective(newToken);
				} 
				
				logger.info("access token:" + accessToken + " lift cycle:" + defaultAccessTokenMaxAge + "");
			}
		}
		
		return accessToken;
	}
}
