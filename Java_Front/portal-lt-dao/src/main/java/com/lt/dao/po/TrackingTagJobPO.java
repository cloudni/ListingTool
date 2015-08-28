package com.lt.dao.po;

import com.lt.dao.model.TrackingTagJob;

public class TrackingTagJobPO extends TrackingTagJob
{
	private String userToken;

	public String getUserToken()
	{
		return userToken;
	}

	public void setUserToken(String userToken)
	{
		this.userToken = userToken;
	}
}
