package com.lt.dao.po;

import com.lt.dao.model.GoogleAdwordsCategory;

public class GoogleAdwordsCategoryPO extends GoogleAdwordsCategory
{
	private Integer ebayCategorysiteid;
	
	private Boolean parentFlag;
	
	private Boolean assignFlag;
	
	private String categoryNameCn;//为了快速匹配使用，后期可以删除

	public Integer getEbayCategorysiteid()
	{
		return ebayCategorysiteid;
	}

	public void setEbayCategorysiteid(Integer ebayCategorysiteid)
	{
		this.ebayCategorysiteid = ebayCategorysiteid;
	}

	public Boolean getParentFlag()
	{
		return parentFlag;
	}

	public void setParentFlag(Boolean parentFlag)
	{
		this.parentFlag = parentFlag;
	}

	public Boolean getAssignFlag()
	{
		return assignFlag;
	}

	public void setAssignFlag(Boolean assignFlag)
	{
		this.assignFlag = assignFlag;
	}

	public String getCategoryNameCn()
	{
		return categoryNameCn;
	}

	public void setCategoryNameCn(String categoryNameCn)
	{
		this.categoryNameCn = categoryNameCn;
	}

}
