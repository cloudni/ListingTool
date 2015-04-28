package com.lt.thirdpartylibrary.paypal.util;

public class PaypalConstant {
	/**
	 * payment session key
	 */
	public static final String PAYER_ID = "PayerID";
	public static final String PAYMENT_ID = "paymentId";
	public static final String TOKEN = "token";
	
	public static final String APPROVAL_URL = "approval_url";
	
	public static final long SAFETY_TIME = 900000;//access token safely time
	
	public static final String CURRENCY_USD = "USD";
	public static final String METHOD_PAYPAL = "paypal";
	public static final String INTENT_SALE = "sale";
	
	public static final String EXCEPTION_CODE_1 = "get access token fail";
	public static final String EXCEPTION_CODE_2 = "access token expired";
	public static final String EXCEPTION_CODE_3 = "request parameter fail";
	public static final String EXCEPTION_CODE_4 = "paypal question";
	public static final String EXCEPTION_CODE_5 = "internet question";
	public static final String EXCEPTION_CODE_6 = "payment timeout";
}
