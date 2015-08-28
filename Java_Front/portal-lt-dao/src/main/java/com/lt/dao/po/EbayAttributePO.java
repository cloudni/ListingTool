package com.lt.dao.po;

import com.lt.dao.model.EbayAttribute;

public class EbayAttributePO extends EbayAttribute
{
	private Integer entityAttrId;
	
	public EbayAttributePO() {
		
	}
	
	public EbayAttributePO(String name) {
		this.setName(name);
	}

	public Integer getEntityAttrId()
	{
		return entityAttrId;
	}

	public void setEntityAttrId(Integer entityAttrId)
	{
		this.entityAttrId = entityAttrId;
	}

	@Override
	public int hashCode()
	{
		final int prime = 31;
		int result = 1;
		result = prime * result
				+ ((getName() == null) ? 0 : getName().hashCode());
		return result;
	}

	@Override
	public boolean equals(Object obj)
	{
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		EbayAttributePO other = (EbayAttributePO) obj;
		if (getName() == null)
		{
			if (other.getName() != null)
				return false;
		} else if (!getName().equals(other.getName()))
			return false;
		return true;
	}
	
}
