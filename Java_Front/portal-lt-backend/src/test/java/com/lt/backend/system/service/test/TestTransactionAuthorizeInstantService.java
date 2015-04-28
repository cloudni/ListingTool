package com.lt.backend.system.service.test;

import org.junit.Test;
import org.springframework.beans.factory.annotation.Autowired;

import test.BaseJunitTest;

import com.lt.backend.system.service.ITransactionAuthorizeInstantService;

public class TestTransactionAuthorizeInstantService extends BaseJunitTest
{
	@Autowired
	private ITransactionAuthorizeInstantService transactionAuthorizeInstantService;
	
	@Test
	public void testUpdateCampaignCostByInstant() {
		transactionAuthorizeInstantService.updateCampaignCostByInstant("2015-04-06");
	}
}
