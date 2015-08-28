package com.lt.dao.po;

import com.lt.dao.model.EbayListing;

public class EbayListingPO extends EbayListing
{
	private String listingDesc;
	
	private Integer total;
	
    private String siteName;
    
    private Integer platform;
    
    private String primaryLevelTcate;
    
    private String secondaryLevelTcate;

	public String getListingDesc()
	{
		return listingDesc;
	}

	public void setListingDesc(String listingDesc)
	{
		this.listingDesc = listingDesc;
	}

	public Integer getTotal()
	{
		return total;
	}

	public void setTotal(Integer total)
	{
		this.total = total;
	}

    public String getSiteName()
    {
        return siteName;
    }

    public void setSiteName(String siteName)
    {
        this.siteName = siteName;
    }

    public Integer getPlatform()
    {
        return platform;
    }

    public void setPlatform(Integer platform)
    {
        this.platform = platform;
    }

	public String getPrimaryLevelTcate()
	{
		return primaryLevelTcate;
	}

	public void setPrimaryLevelTcate(String primaryLevelTcate)
	{
		this.primaryLevelTcate = primaryLevelTcate;
	}

	public String getSecondaryLevelTcate()
	{
		return secondaryLevelTcate;
	}

	public void setSecondaryLevelTcate(String secondaryLevelTcate)
	{
		this.secondaryLevelTcate = secondaryLevelTcate;
	}

}
