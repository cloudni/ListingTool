package com.lt.frontend.ebay.service.impl;

import java.util.Map;

import javax.annotation.Resource;

import org.springframework.stereotype.Service;

import com.lt.dao.mapper.StoreMapper;
import com.lt.dao.model.Store;
import com.lt.frontend.ebay.service.IEbayStoreService;
/**
 * ebay Entity Store
 * @author wolf.yansl
 *
 */
@Service
public class EbayStoreServiceImpl implements IEbayStoreService {

	@Resource
	private StoreMapper storeMapper;

	@Override
	public Map<String,Object> findEbayStoreAuthParameters(String companyId, String storeId)throws Exception {
		return storeMapper.selectAuthStore(companyId, storeId);
	}
	
	
}
