package com.lt.thirdpartylibrary.paypal.util.bean;

import java.util.ArrayList;
import java.util.List;

import com.paypal.base.rest.PayPalModel;

public class PaymentHistoryVO extends PayPalModel
{
	/**
	 * A list of Payment resources
	 */
	private List<PaymentVO> paypalPayments = new ArrayList<PaymentVO>();

	/**
	 * Number of items returned in each range of results. Note that the last results range could have fewer items than the requested number of items.
	 */
	private int count;

	/**
	 * Identifier of the next element to get the next range of results.
	 */
	private String nextId;

	/**
	 * Default Constructor
	 */
	public PaymentHistoryVO() {
	}

	public List<PaymentVO> getPaypalPayments()
	{
		return paypalPayments;
	}

	public void setPaypalPayments(List<PaymentVO> paypalPayments)
	{
		this.paypalPayments = paypalPayments;
	}

	public int getCount()
	{
		return count;
	}

	public void setCount(int count)
	{
		this.count = count;
	}

	public String getNextId()
	{
		return nextId;
	}

	public void setNextId(String nextId)
	{
		this.nextId = nextId;
	}
	
}
