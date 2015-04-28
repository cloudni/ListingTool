package com.lt.backend.system.service.test;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;

import org.junit.Test;
import org.springframework.beans.factory.annotation.Autowired;

import test.BaseJunitTest;

import com.lt.backend.system.service.ITransactionAuthorizeService;
import com.lt.dao.mapper.AdCampaignMapper;
import com.lt.dao.mapper.AdChangeLogMapper;
import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.AdChangeLog;

public class TestTransactionAuthorizeService extends BaseJunitTest
{
	@Autowired
	private ITransactionAuthorizeService transactionAuthorizeService;

	@Autowired
	private AdCampaignMapper adCampaignMapper;
	
	@Autowired
	private TransactionMapper transactionMapper;
	
	@Autowired
	private AdChangeLogMapper adChangeLogMapper;

	@Test
	public void testCreateCampaign()
	{
		Integer companyId = 1;
		// 模拟创建活动
		AdCampaign adCampaign = new AdCampaign();
		adCampaign.setBudget(new BigDecimal(2));
		adCampaign.setName("test");
		adCampaign.setCompanyId(companyId);
		adCampaignMapper.insertSelective(adCampaign);
		Integer campaginId = transactionMapper.selectLastestInsertId();
		adCampaign.setId(campaginId);

		transactionAuthorizeService.freezeCampaignBudget(adCampaign);
	}
	
	@Test
	public void testAdd() {
		transactionAuthorizeService.updateCampaignCost("2015-04-06");
	}
	
	
	@Test
	public void testAdChangeLogMapper() {
		List<AdChangeLog> list = new ArrayList<AdChangeLog>();
		AdChangeLog log = new AdChangeLog();
		log.setCompanyId(1);
		log.setObjectType(1);
		log.setObjectId(16);
		log.setAction(1);
		log.setContent("content B");
		log.setStatus(1);
		log.setPriority(4);
		list.add(log);
		
		log = new AdChangeLog();
		log.setCompanyId(2);
		log.setObjectType(2);
		log.setObjectId(2);
		log.setAction(2);
		log.setContent("2");
		log.setStatus(2);
		log.setPriority(2);
		list.add(log);
		adChangeLogMapper.batchInsertSelective(list);
	}
}
