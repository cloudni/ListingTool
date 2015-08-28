package com.lt.backend.system.service;

import java.util.List;

import com.lt.dao.po.EbayListingPO;
import com.lt.dao.po.TrackingTagPO;

/**
 * 
 * @author jameschen
 *
 */
public interface IEbayListingService
{
	/**
	 * 批量跟新产品的pixel
	 * @param filePathPre 上传文件的保存路径
	 * @param trackingTag 查询匹配参数的条件集合
	 */
	public void batchUpdatePixel(String filePathPre, TrackingTagPO trackingTag)  throws Exception;


	/**
	 * 根据company或store获取有效的Site列表
	 * @param ebayListingPO
	 * @return
	 */
    List<EbayListingPO> selectSiteByCompanyAndStore(EbayListingPO ebayListingPO);
    
    /**
	 * 批量跟新产品的描述
	 * @param storeId 门店id
	 */
	public String batchUpdateDescByStore(Integer storeId, String filePathPre)  throws Exception;

}
