package com.lt.frontend.ebay.bean;

import java.io.Serializable;

import com.lt.platform.framework.core.model.MyBatisSuperModel;
/**
 * ebay token
 */
public class EbayToken extends MyBatisSuperModel implements Serializable
{

	/**
	 * ebay token 内容
	 */
	private String token;
	/**
	 * ebay sessionID
	 */
	private String sessionID;
	/**
	 * ebay token 生命周期
	 */
	private String tokenExp;
	public String getToken()
	{
		return token;
	}
	public void setToken(String token)
	{
		this.token = token;
	}
	public String getSessionID()
	{
		return sessionID;
	}
	public void setSessionID(String sessionID)
	{
		this.sessionID = sessionID;
	}
	public String getTokenExp()
	{
		return tokenExp;
	}
	public void setTokenExp(String tokenExp)
	{
		this.tokenExp = tokenExp;
	}
	
	
}
