package com.lt.backend.marketing.service;

import java.util.List;

import com.lt.dao.po.GoogleAdwordsAudiencePO;

public interface IAudienceService
{

    public List<GoogleAdwordsAudiencePO> getAudienceList(GoogleAdwordsAudiencePO po);
    public List<GoogleAdwordsAudiencePO> getJobList();
    public int saveAudience(GoogleAdwordsAudiencePO po);
    public int updateAudienceRun(String ids);
    public boolean checkExist(String name, Integer id);
}
