package com.lt.backend.system.service;

import java.util.List;

import com.lt.dao.model.Store;

public interface IStoreService
{

    /**
     * List Company  init data
     * Author devin
     * @param Company
     * @return
     */
    List<Store> getStores(Store po);

    /**
     * List Company  init data
     * Author devin
     * @param Company
     * @return
     */
    List<Store> getPlatforms(Integer companyId);
}
