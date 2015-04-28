package com.lt.backend.category.service;

import java.util.List;

import com.lt.dao.model.EbayCategory;
import com.lt.dao.po.EbayCategoryPO;
/**
 * 
 * @author jameschen
 *
 */
public interface IEbayCategoryService
{
    /**
     * 根据条件查询ebay 的category 列表
     * @param record
     * @return
     */
    public List<EbayCategoryPO> selectByParentId(EbayCategoryPO record);
    /**
     * 根据ebay category id修改EbayCategory
     * @param ebayCategory
     */
	public void updateByCategoryIdSelective(EbayCategory ebayCategory);
}
