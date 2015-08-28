package com.lt.backend.marketing.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.marketing.service.IAdChangeLogServcie;
import com.lt.dao.mapper.AdChangeLogMapper;
import com.lt.dao.model.AdChangeLog;
import com.lt.dao.po.AdChangeLogPO;

@Service
public class AdChangeLogServcie implements IAdChangeLogServcie
{
    @Autowired
    private  AdChangeLogMapper adChangeLogMapper;
    
    public List<AdChangeLogPO> getAdChangeLog(AdChangeLogPO po) {
        
        List<AdChangeLogPO> list = adChangeLogMapper.getAdChangeLog(po);
        return list;
    }

    @Override
    public int updateStatus(AdChangeLog po)
    {
        return adChangeLogMapper.updateByPrimaryKeySelective(po);
    }
}
