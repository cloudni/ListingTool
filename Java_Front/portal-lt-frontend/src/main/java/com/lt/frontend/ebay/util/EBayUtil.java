package com.lt.frontend.ebay.util;

import com.ebay.sdk.ApiAccount;
import com.ebay.sdk.ApiContext;
import com.ebay.sdk.ApiCredential;

/**
 * ebay 工具类
 * @author wolf.yansl
 *
 */
public class EBayUtil
{
	
	/**
	 * ebay 配置远程授权
	 * @param devId 
	 * @param appId 
	 * @param certId
	 * @param ApiServerUrl 远程授权地址
	 * @return
	 */
	public static ApiContext createApiContext( String devId, String appId, String certId, String ApiServerUrl){
		
		ApiAccount ac = new ApiAccount();
		ac.setDeveloper(devId);
   	    ac.setApplication(appId);
   	    ac.setCertificate(certId);

	
		ApiCredential apiCred = new ApiCredential();
		apiCred.setApiAccount(ac);

		ApiContext apiContext = new ApiContext();
		apiContext.setApiCredential(apiCred);
		apiContext.setApiServerUrl(ApiServerUrl);
	
        return apiContext;
	}

}
