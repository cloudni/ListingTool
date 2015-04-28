package com.lt.thirdpartylibrary.paypal.util.bean;

public class PaymentCondition
{
	/**
	 *  payment history condition count
	 */
	private String count;
	/**
	 * payment history condition start_id
	 */
	private String startId;
	/**
	 * payment history condition start_index
	 */
	private String startIndex;
	/**
	 * payment history condition start_time
	 */
	private String startTime;
	/**
	 * payment history condition end_time
	 */
	private String endTime; 
	/**
	 * payment history condition payee_id
	 */
	private String payeeId; 
	/**
	 * payment history condition sort_by
	 */
	private String sortBy; 
	/**
	 * payment history condition sort_order
	 */
	private String sortOrder;
	
	//getter and setter
	public String getCount()
	{
		return count;
	}
	public void setCount(String count)
	{
		this.count = count;
	}
	public String getStartId()
	{
		return startId;
	}
	public void setStartId(String startId)
	{
		this.startId = startId;
	}
	public String getStartIndex()
	{
		return startIndex;
	}
	public void setStartIndex(String startIndex)
	{
		this.startIndex = startIndex;
	}
	public String getStartTime()
	{
		return startTime;
	}
	public void setStartTime(String startTime)
	{
		this.startTime = startTime;
	}
	public String getEndTime()
	{
		return endTime;
	}
	public void setEndTime(String endTime)
	{
		this.endTime = endTime;
	}
	public String getPayeeId()
	{
		return payeeId;
	}
	public void setPayeeId(String payeeId)
	{
		this.payeeId = payeeId;
	}
	public String getSortBy()
	{
		return sortBy;
	}
	public void setSortBy(String sortBy)
	{
		this.sortBy = sortBy;
	}
	public String getSortOrder()
	{
		return sortOrder;
	}
	public void setSortOrder(String sortOrder)
	{
		this.sortOrder = sortOrder;
	}
	
}
