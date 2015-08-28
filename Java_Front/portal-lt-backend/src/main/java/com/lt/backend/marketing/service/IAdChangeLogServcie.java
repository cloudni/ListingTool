package com.lt.backend.marketing.service;

import java.util.List;

import org.springframework.stereotype.Service;

import com.lt.dao.model.AdChangeLog;
import com.lt.dao.po.AdChangeLogPO;

@Service
public interface IAdChangeLogServcie
{
    public List<AdChangeLogPO> getAdChangeLog(AdChangeLogPO po);
    
    public int updateStatus(AdChangeLog po);
}
