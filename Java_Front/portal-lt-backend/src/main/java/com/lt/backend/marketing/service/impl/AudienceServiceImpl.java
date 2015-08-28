package com.lt.backend.marketing.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.marketing.service.IAudienceService;
import com.lt.dao.mapper.GoogleAdwordsAudienceMapper;
import com.lt.dao.po.GoogleAdwordsAudiencePO;

@Service
public class AudienceServiceImpl implements IAudienceService
{
    @Autowired
    private GoogleAdwordsAudienceMapper googleAdwordsAudienceMapper;

    @Override
    public List<GoogleAdwordsAudiencePO> getAudienceList(GoogleAdwordsAudiencePO po)
    {
        return googleAdwordsAudienceMapper.selectAllByPage(po);
    }

    @Override
    public int saveAudience(GoogleAdwordsAudiencePO po)
    {
        return googleAdwordsAudienceMapper.insert(po);
    }

    @Override
    public List<GoogleAdwordsAudiencePO> getJobList()
    {
        return googleAdwordsAudienceMapper.getJobList();
    }

    @Override
    public int updateAudienceRun(String ids)
    {
        return googleAdwordsAudienceMapper.updateAudienceRun(ids);
    }

    public boolean checkExist(String name, Integer id) {
        int cnt = googleAdwordsAudienceMapper.checkExist(name, id);
        if (cnt > 0) {
            return true;
        }
        return false;
    }
}
