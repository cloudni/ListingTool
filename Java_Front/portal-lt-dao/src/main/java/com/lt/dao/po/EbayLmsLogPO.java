package com.lt.dao.po;

import com.lt.dao.model.EbayLmsLog;

public class EbayLmsLogPO extends EbayLmsLog
{

	@Override
	public int hashCode()
	{
		final int prime = 31;
		int result = 1;
		result = prime * result
				+ ((super.getId() == null) ? 0 : super.getId().hashCode());
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
		EbayLmsLogPO other = (EbayLmsLogPO) obj;
		if (super.getCmdDate() == null && super.getItemId() == null)
		{
			if (other.getCmdDate() != null || other.getItemId() != null)
			{
				return false;
			}
		} else if (super.getCmdDate().equals(other.getCmdDate())
				&& super.getItemId().equals(other.getItemId()))
		{
			return true;
		}
		return true;
	}

}
