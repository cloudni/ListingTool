package com.lt.backend.system.service.impl;

import java.util.List;

import javax.annotation.Resource;

import org.springframework.stereotype.Service;

import com.lt.backend.system.service.IStoreService;
import com.lt.dao.mapper.StoreMapper;
import com.lt.dao.model.Store;
@Service
public class StoreServiceImpl implements IStoreService
{
	@Resource
	private StoreMapper storeMapper;

    @Override
    public List<Store> getStores(Store po)
    {
        return storeMapper.getStores(po);
    }

    @Override
    public List<Store> getPlatforms(Integer companyId)
    {
        return storeMapper.getPlatforms(companyId);
    }

}
