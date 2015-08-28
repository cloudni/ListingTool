package com.lt.backend.marketing.controller;

import javax.servlet.http.HttpServletRequest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import com.lt.backend.marketing.service.IAdChangeLogServcie;
import com.lt.dao.model.AdChangeLog;
import com.lt.dao.po.AdChangeLogPO;
import com.lt.platform.util.Constants;

@Controller
@RequestMapping("/marketing")
public class AdChangeLogController
{
    
    @Autowired
    IAdChangeLogServcie adChangeLogServcie;

    /**
     * 
     * @param AdChangeLogPO
     * @return
     * @throws Exception
     */
    @RequestMapping("adchangelog/getAdChangeLog")
    public ModelAndView getAdChangeLog(HttpServletRequest request, AdChangeLogPO po) {
        po.setRequestPath(request);
        po.setIspaging(true);
        po.setResults(adChangeLogServcie.getAdChangeLog(po));
        
        ModelAndView mv = new ModelAndView("/marketing/ad_change_log");
        mv.addObject("page", po);
        return mv;
    }

    @RequestMapping("adchangelog/updateStatus")
    @ResponseBody
    public String updateStatus(AdChangeLog AdChangeLog) {
        adChangeLogServcie.updateStatus(AdChangeLog);
        return Constants.SUCCESS;
    }
    
}
