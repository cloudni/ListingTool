package com.lt.dao.po;

import com.lt.dao.model.EbayCategory;

public class EbayCategoryPO extends EbayCategory
{
	private Boolean assignFlag;
	
	private Boolean parentFlag;
	
	private String categoryNameCn;//临时，为了快速匹配

	public Boolean getAssignFlag()
	{
		return assignFlag;
	}

	public void setAssignFlag(Boolean assignFlag)
	{
		this.assignFlag = assignFlag;
	}

	public Boolean getParentFlag()
	{
		return parentFlag;
	}

	public void setParentFlag(Boolean parentFlag)
	{
		this.parentFlag = parentFlag;
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
