package com.lt.thirdpartylibrary.ebay.base;

import com.ebay.sdk.ApiAccount;
import com.ebay.sdk.ApiContext;
import com.ebay.sdk.ApiCredential;
import com.ebay.sdk.CallRetry;

public class EbayApiUtil {
	private ApiContext apiContext = new ApiContext();
	public static final String SERVER_URL = "https://api.ebay.com/wsapi";
	public static final String EPS_SERVER_URL = "https://api.ebay.com/ws/api.dll";
	public static final String SIGNIN_URL = "https://api.ebay.com/ws/eBayISAPI.dll?SignIn";
	public static final int TIMEOUT = 180000;

	public EbayApiUtil(String developer, String application, String certificate, String token) {
		try {
			// Enable Call-Retry.
			CallRetry cr = new CallRetry();
			cr.setMaximumRetries(3);
			cr.setDelayTime(1000); // Wait for one second between each
									// retry-call.

			String[] apiErrorCodes = new String[] { "10007", // "Internal error to the application."
					"931", // "Validation of the authentication token in API request failed."
					"521", // Test of Call-Retry:
							// "The specified time window is invalid."
					"124" // Test of Call-Retry: "Developer name invalid."
			};
			cr.setTriggerApiErrorCodes(apiErrorCodes);

			// Set trigger exceptions for CallRetry.
			// Build a dummy SdkSoapException so that we can get its Class.
			@SuppressWarnings("rawtypes")
			java.lang.Class[] tcs = new java.lang.Class[] { com.ebay.sdk.SdkSoapException.class };
			cr.setTriggerExceptions(tcs);

			apiContext.setCallRetry(cr);

			apiContext.setTimeout(TIMEOUT);

			this.loadConfiguration(developer, application, certificate, token);

			// Add listener for token renewal event.
			apiContext.getApiCredential().addTokenEventListener(
					new EbayApiUtilTokenEventListener(this));
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	public void loadConfiguration(String developer, String application, String certificate, String token) throws Exception {
		
		this.apiContext.setApiServerUrl(SERVER_URL);
		this.apiContext.setEpsServerUrl(EPS_SERVER_URL);
		this.apiContext.setSignInUrl(SIGNIN_URL);
		
		ApiAccount ac = new ApiAccount();
		ac.setDeveloper(developer);
		ac.setApplication(application);
		ac.setCertificate(certificate);
		
		ApiCredential apiCred = new ApiCredential();
		apiCred.setApiAccount(ac);
		apiCred.seteBayToken(token);
		
		this.apiContext.setApiCredential(apiCred);

	}
	
	public ApiContext getApiContext() {
		return this.apiContext;
	}
}
