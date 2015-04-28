package com.lt.frontend.common.util;

import java.util.HashMap;
import java.util.Map;

import com.lt.dao.po.TransactionPO;

public class I18nKeyConstants
{
	public static final String key_type = "type";
	public static final String key_status = "status";
	public static final String key_paymentTransactionType = "paymentTransactionType";
	
	public static final String transaction_type_paypal = "transaction_type_paypal";
	public static final String transaction_type_system = "transaction_type_system";
	
	public static final String transaction_status_create = "transaction_status_create";
	public static final String transaction_status_success = "transaction_status_success";
	public static final String transaction_status_cancel = "transaction_status_cancel";
	public static final String transaction_status_fail = "transaction_status_fail";
	
	public static final String payment_transaction_type_deposit = "payment_transaction_type_deposit";
	public static final String payment_transaction_type_withdraw = "payment_transaction_type_withdraw";
	public static final String payment_transaction_type_freeze = "payment_transaction_type_freeze";
	public static final String payment_transaction_type_unfreeze = "payment_transaction_type_unfreeze";
	public static final String payment_transaction_type_deduaction = "payment_transaction_type_deduaction";

	private static Map<String, Map<Object, String>> i18nMap = new HashMap<String, Map<Object, String>>();
	static {
		Map<Object, String> i18nKeyMap = new HashMap<Object, String>();
		i18nKeyMap.put(TransactionPO.TYPE_PAYPAL, transaction_type_paypal);
		i18nKeyMap.put(TransactionPO.TYPE_SYSTEM, transaction_type_system);
		i18nMap.put(key_type, i18nKeyMap);
		
		i18nKeyMap = new HashMap<Object, String>();
		i18nKeyMap.put(TransactionPO.STATE_CREATE, transaction_status_create);
		i18nKeyMap.put(TransactionPO.STATE_SUCCESS, transaction_status_success);
		i18nKeyMap.put(TransactionPO.STATE_CANCEL, transaction_status_cancel);
		i18nKeyMap.put(TransactionPO.STATE_FAIL, transaction_status_fail);
		i18nMap.put(key_status, i18nKeyMap);
		
		i18nKeyMap = new HashMap<Object, String>();
		i18nKeyMap.put(TransactionPO.PAYMENT_TYPE_DEPOSIT, payment_transaction_type_deposit);
		i18nKeyMap.put(TransactionPO.PAYMENT_TYPE_WITHDRAW, payment_transaction_type_withdraw);
		i18nKeyMap.put(TransactionPO.PAYMENT_TYPE_FREEZE, payment_transaction_type_freeze);
		i18nKeyMap.put(TransactionPO.PAYMENT_TYPE_UNFREEZE, payment_transaction_type_unfreeze);
		i18nKeyMap.put(TransactionPO.PAYMENT_TYPE_DEDUCTION, payment_transaction_type_deduaction);
		i18nMap.put(key_paymentTransactionType, i18nKeyMap);
	}
	
	public static String getI18nKey(String keyType, Object key) {
		Map<Object, String> i18nKeyMap = i18nMap.get(keyType);
		return i18nKeyMap.get(key);
	}
}
