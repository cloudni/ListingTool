package com.lt.thirdpartylibrary.paypal.util;

import java.util.Properties;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.paypal.api.openidconnect.Userinfo;
import com.paypal.base.rest.PayPalResource;

public class GeneratePaypalApiContext
{
	private static Logger logger = LoggerFactory.getLogger(GeneratePaypalApiContext.class);
	
	//private static long defaultAccessTokenMaxAge = 0;
	//private static String accessToken = "";
	
	private static Userinfo userinfo = null;
	
	public static void initConfig(Properties properties) 
	{
		PayPalResource.initConfig(properties);
		/*OAuthTokenCredential oAuthTokenCredential = PayPalResource.initConfig(properties);
		try
		{
			String accessToken = RedisCacheUtli.getString(ACCESS_TOKEN);
			//Long defaultAccessTokenMaxAge = Long.parseLong(RedisCacheUtli.getString("defaultAccessTokenMaxAge"));
			if(StringUtil.isBlank(accessToken)) {
				accessToken = oAuthTokenCredential.getAccessToken();
				Long defaultAccessTokenMaxAge = oAuthTokenCredential.expiresIn()*1000 + new Date().getTime();
				
				RedisCacheUtli.setString(ACCESS_TOKEN, accessToken);
				RedisCacheUtli.setString(DEFAULT_ACCESS_TOKEN_MAX_AGE, defaultAccessTokenMaxAge + "");
				logger.info("get access token and lift cycle success, and put redis cache success");
				logger.info("access token:" + accessToken + " lift cycle:" + defaultAccessTokenMaxAge + "");
			}
			
			//userinfo = Userinfo.getUserinfo(accessToken);
			//HttpClientResultUtil result = HttpClientUtil.get(userinfo.getUserId());
			//System.out.println(result.getContext());
		} catch (PayPalRESTException e)
		{
			logger.error("init paypal config fail:" + e.getMessage(), e);
		}*/
	}
	
	public static Userinfo getUserInfo() {
		
		return userinfo;
	}
	
}
