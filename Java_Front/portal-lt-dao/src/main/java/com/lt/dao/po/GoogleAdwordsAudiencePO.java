package com.lt.dao.po;

import com.lt.dao.model.GoogleAdwordsAudience;
import com.lt.platform.util.time.DateFormatUtil;

public class GoogleAdwordsAudiencePO extends GoogleAdwordsAudience
{
	private String companyName;
    private String objectName;

	public GoogleAdwordsAudiencePO() {
	    
	}
	
    public String getCompanyName()
    {
        return companyName;
    }
    public void setCompanyName(String companyName)
    {
        this.companyName = companyName;
    }
	public String getCreateTimeStr()
	{
		if(getCreateTimeUtc() != null && getCreateTimeUtc() > 0)
		{
			return DateFormatUtil.convertIntegerToString(getCreateTimeUtc());
		}
		return null;
	}
	public String getUpdateTimeStr()
	{	
		if(getUpdateTimeUtc() != null && getUpdateTimeUtc() > 0)
		{
		    return DateFormatUtil.convertIntegerToString(getUpdateTimeUtc());
		}
		return null;
	}

    public String getObjectName()
    {
        return objectName;
    }

    public void setObjectName(String objectName)
    {
        this.objectName = objectName;
    }
}
