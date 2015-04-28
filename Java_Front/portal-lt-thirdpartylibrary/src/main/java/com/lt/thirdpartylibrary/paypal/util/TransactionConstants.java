package com.lt.thirdpartylibrary.paypal.util;

public class TransactionConstants
{
	public static final String TYPE_PAYPAL = "paypal";
	public static final String PAYMENT_TYPE = "paymentType";
	/**
	 * 支付请求的浮点数格式
	 */
	public static final String DOUBLE_FORMAT = "%.2f";
	
	/**
	 * 接口名称
	 */
	public static final String INTERFACE_PAYMENT = "payment";
	public static final String INTERFACE_PAYOUT = "payout";
	
	/**
	 * 接口动作
	 */
	public static final String INTERFACE_PAYMENT_CREATE = "payment_create";
	public static final String INTERFACE_PAYMENT_EXECUTE = "payment_execute";
	public static final String INTERFACE_PAYOUT_EXECUTE = "payout_execute";
	
	public static final String CALLBACK_FORMAT = "{status:%s, msg:%s}";
	public static final String PARA_FORMAT = "{reason:%s,companyId:%s, campaignId:%s, budget:%s}";
	
	public static final String REASION_FORMAT_FAIL = "format parament fail";
	public static final String REASION_PARAMENT_NULL = "parament is not null";
	public static final String REASION_PARAMENT_FREEZE = "company balance is not enough";
	
	public static final String CALL_ERROR = "error";
	public static final String CALL_SUCCESS = "success";
	
	public static String formatMsg(String status, String reason, String companyId, String campaignId, String budget) {
		String msg = String.format(CALLBACK_FORMAT, status, 
				String.format(PARA_FORMAT, reason,companyId, campaignId, budget));
		return msg;
	}
	
	public static String getNullErrorMsg(String companyId, String campaignId, String budget) {
		return formatMsg(CALL_ERROR, REASION_PARAMENT_NULL, companyId, campaignId, budget);
	}
	
	public static String getFormatErrorMsg(String companyId, String campaignId, String budget) {
		return formatMsg(CALL_ERROR, REASION_FORMAT_FAIL, companyId, campaignId, budget);
	}
	public static String getFreezeErrorMsg(String companyId, String campaignId, String budget) {
		return formatMsg(CALL_ERROR, REASION_PARAMENT_FREEZE, companyId, campaignId, budget);
	}
}
