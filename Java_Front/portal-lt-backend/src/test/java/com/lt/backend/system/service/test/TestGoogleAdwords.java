package com.lt.backend.system.service.test;

import org.junit.Test;
import org.springframework.beans.factory.annotation.Autowired;

import test.BaseJunitTest;

import com.lt.backend.googleadwords.service.IReportService;



public class TestGoogleAdwords extends BaseJunitTest
{

    @Autowired
    private IReportService reportService;
    
    @Test
    public void  insert() throws Exception{
        reportService.downloadAdwordsReport();
    } 
}
