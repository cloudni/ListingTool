package com.lt.frontend.ebay.service;

import java.util.Map;

import com.lt.dao.mapper.StoreMapper;
import com.lt.dao.model.Store;

/**
 * ebay Entity Store
 * @author wolf.yansl
 *
 */
public interface IEbayStoreService {

	/**
	 * get Ebay Store Authentication parameters 
	 * @param companyId  businessman Entity ID
	 * @param storeId	ebay Entity ID
	 * @return
	 * @throws Exception
	 */
	public Map<String,Object> findEbayStoreAuthParameters(String companyId,String storeId)throws Exception;
}
