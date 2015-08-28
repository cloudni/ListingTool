package com.lt.dao.po;

import com.lt.dao.model.Store;

public class StorePO extends Store
{
	private String devId;
	
	private String appId;
	
	private String certId;

	public String getDevId()
	{
		return devId;
	}

	public void setDevId(String devId)
	{
		this.devId = devId;
	}

	public String getAppId()
	{
		return appId;
	}

	public void setAppId(String appId)
	{
		this.appId = appId;
	}

	public String getCertId()
	{
		return certId;
	}

	public void setCertId(String certId)
	{
		this.certId = certId;
	}
}
