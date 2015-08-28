package com.lt.dao.po;

import com.lt.platform.util.lang.StringUtil;

public class TrackingTagPO
{
	private Integer companyId;
	private Integer storeId;
	private String ebaySiteIds;//站点id，可能包含多个
	private String[] ebaySiteNames;//站点名称数组
	private Boolean selectFlag;//查询时是否根据条件过滤
	private Boolean selectDescFlag;//查询正则表达式的匹配方式：匹配或者不匹配
	private String selectDescRule;//查询正则表达式
	private String[] replaceRuleArray;//替换的正则表达式规则，如果查询出“<itemtool>开头</itemtool>结尾”的信息
	private String[] replaceTarget;//替换的结果，如果将“<itemtool>开头</itemtool>结尾”的信息替换成“abc”
	private String descriptionReviseMode;//append还是replace

	private Integer currentCompanyId;//当前操作的公司（在for循环中，用于临时记录当前操作的公司，用于向下传参）
	private Integer currentStoreId;//当前操作的站点（在for循环中，用于临时记录当前操作的门店，用于向下传参）
	private Integer variationFlag;//单个和多个，1代表单个，2代表多个
	
	private Integer start;
	private Integer end;
	
	public static final String SPLIT = ",";
	public static final Integer VARIATION_FLAG_ONE = 1;
	public static final Integer VARIATION_FLAG_MORE = 2;
	
	public static final String DESCRIPT_REVISE_MODE_APPEND = "Append";//追加
	public static final String DESCRIPT_REVISE_MODE_REPLACE = "Replace";//替换（实质是删除，将内容替换成""）
	public static final String DESCRIPT_REVISE_MODE_APPEND_AND_REPLACE = "AppendAndReplace";//追加 + 替换
	public static final String DESCRIPT_REVISE_MODE_COMPARE = "Compare";
	
	public Integer getCompanyId()
	{
		return companyId;
	}
	public void setCompanyId(Integer companyId)
	{
		this.companyId = companyId;
	}
	public Integer getStoreId()
	{
		return storeId;
	}
	public void setStoreId(Integer storeId)
	{
		this.storeId = storeId;
	}
	public String getEbaySiteIds()
	{
		return ebaySiteIds;
	}
	public void setEbaySiteIds(String ebaySiteIds)
	{
		this.ebaySiteIds = ebaySiteIds;
		
		if(StringUtil.isNotBlank(ebaySiteIds))
		{
			String[] ebaySiteIdArray = ebaySiteIds.split(SPLIT);
			
			String[] ebaySiteNames = new String[ebaySiteIdArray.length];
			for(int i = 0; i < ebaySiteIdArray.length; i ++)
			{
				ebaySiteNames[i] = SiteUtil.getValue(Integer.parseInt(ebaySiteIdArray[i]));
			}
			this.setEbaySiteNames(ebaySiteNames);
		}
	}
	public Boolean getSelectDescFlag()
	{
		return selectDescFlag;
	}
	public void setSelectDescFlag(Boolean selectDescFlag)
	{
		this.selectDescFlag = selectDescFlag;
	}
	public String getSelectDescRule()
	{
		return selectDescRule;
	}
	public void setSelectDescRule(String selectDescRule)
	{
		this.selectDescRule = selectDescRule;
	}
	public String[] getReplaceRuleArray()
	{
		return replaceRuleArray;
	}
	public void setReplaceRuleArray(String[] replaceRuleArray)
	{
		this.replaceRuleArray = replaceRuleArray;
	}
	public String[] getReplaceTarget()
	{
		return replaceTarget;
	}
	public void setReplaceTarget(String[] replaceTarget)
	{
		this.replaceTarget = replaceTarget;
	}
	public Integer getCurrentCompanyId()
	{
		return currentCompanyId;
	}
	public void setCurrentCompanyId(Integer currentCompanyId)
	{
		this.currentCompanyId = currentCompanyId;
	}
	public Integer getCurrentStoreId()
	{
		return currentStoreId;
	}
	public void setCurrentStoreId(Integer currentStoreId)
	{
		this.currentStoreId = currentStoreId;
	}
	public Integer getVariationFlag()
	{
		return variationFlag;
	}
	public void setVariationFlag(Integer variationFlag)
	{
		this.variationFlag = variationFlag;
	}
	public Boolean getSelectFlag()
	{
		return selectFlag;
	}
	public void setSelectFlag(Boolean selectFlag)
	{
		this.selectFlag = selectFlag;
	}
	public String getDescriptionReviseMode()
	{
		return descriptionReviseMode;
	}
	public void setDescriptionReviseMode(String descriptionReviseMode)
	{
		this.descriptionReviseMode = descriptionReviseMode;
	}
	public String[] getEbaySiteNames()
	{
		return ebaySiteNames;
	}
	public void setEbaySiteNames(String[] ebaySiteNames)
	{
		this.ebaySiteNames = ebaySiteNames;
	}
	public Integer getStart()
	{
		return start;
	}
	public void setStart(Integer start)
	{
		this.start = start;
	}
	public Integer getEnd()
	{
		return end;
	}
	public void setEnd(Integer end)
	{
		this.end = end;
	}
	
}
