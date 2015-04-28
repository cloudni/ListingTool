package com.lt.thirdpartylibrary.paypal.util;

public class PaypalResponse
{
	private String paymentType;
	private String paymentId;
	private String PayerID;
	private String token;
	
	public String getPaymentType()
	{
		return paymentType;
	}
	public void setPaymentType(String paymentType)
	{
		this.paymentType = paymentType;
	}
	public String getPaymentId()
	{
		return paymentId;
	}
	public void setPaymentId(String paymentId)
	{
		this.paymentId = paymentId;
	}
	public String getPayerID()
	{
		return PayerID;
	}
	public void setPayerID(String payerID)
	{
		PayerID = payerID;
	}
	public String getToken()
	{
		return token;
	}
	public void setToken(String token)
	{
		this.token = token;
	}
}
