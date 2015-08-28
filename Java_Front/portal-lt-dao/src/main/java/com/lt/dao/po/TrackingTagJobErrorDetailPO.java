package com.lt.dao.po;

import com.lt.dao.model.TrackingTagJobErrorDetail;

public class TrackingTagJobErrorDetailPO extends TrackingTagJobErrorDetail
{
	private String ebayToken;

	public String getEbayToken()
	{
		return ebayToken;
	}

	public void setEbayToken(String ebayToken)
	{
		this.ebayToken = ebayToken;
	}

}
