package com.lt.backend.system.service.impl;

import java.math.BigDecimal;
import java.util.Date;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.system.service.ITransactionAuthorizeInstantService;
import com.lt.dao.mapper.AdCampaignMapper;
import com.lt.dao.mapper.AdFacebookReportAdMapper;
import com.lt.dao.mapper.AdFacebookReportAdSetMapper;
import com.lt.dao.mapper.AdFacebookReportCampaignMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportAdGroupMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportAdMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportCampaignMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportDestinationUrlMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportGeoMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportKeywordsMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportUrlMapper;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.GoogleAdwordsAdMapper;
import com.lt.dao.mapper.NotificationMapper;
import com.lt.dao.mapper.TransactionChangeLogMapper;
import com.lt.dao.model.Company;
import com.lt.dao.po.CampaignCostPO;
import com.lt.dao.po.CompanyPO;
import com.lt.platform.util.time.DateFormatUtil;

@Service
public class TransactionAuthorizeInstantServiceImpl implements
		ITransactionAuthorizeInstantService
{
	private static Logger logger = LoggerFactory.getLogger(TransactionAuthorizeInstantServiceImpl.class);
	
	@Autowired
	private AdCampaignMapper adCampaignMapper;
	@Autowired
	private CompanyMapper companyMapper;
	@Autowired
	private TransactionChangeLogMapper transactionChangeLogMapper;
	@Autowired
	private NotificationMapper notificationMapper;
	@Autowired
	private GoogleAdwordsAdMapper googleAdwordsAdMapper;
	@Autowired 
	private AdGoogleAdwordsReportCampaignMapper adGoogleAdwordsReportCampaignMapper;
	@Autowired
	private AdGoogleAdwordsReportAdMapper adGoogleAdwordsReportAdMapper;
	@Autowired
	private AdGoogleAdwordsReportUrlMapper adGoogleAdwordsReportUrlMapper;
	@Autowired
	private AdGoogleAdwordsReportDestinationUrlMapper adGoogleAdwordsReportDestinationUrlMapper;
	@Autowired
	private AdGoogleAdwordsReportGeoMapper adGoogleAdwordsReportGeoMapper;
	@Autowired
	private AdGoogleAdwordsReportAdGroupMapper adGoogleAdwordsReportAdGroupMapper;
	@Autowired
	private AdGoogleAdwordsReportKeywordsMapper adGoogleAdwordsReportKeywordsMapper;
	@Autowired
	private AdFacebookReportAdSetMapper adFacebookReportAdSetMapper;
	@Autowired
	private AdFacebookReportCampaignMapper adFacebookReportCampaignMapper;
	@Autowired
	private AdFacebookReportAdMapper adFacebookReportAdMapper;
	
	private static final String DATE_FORMAT = "yyyy-MM-dd";

	@Override
	public void updateCampaignCostByInstant(String reportDate)
	{
		logger.info("start excute updateCampaignCostByInstant");
		List<Company> companyList = companyMapper.selectAliveActivitiCompaign();//获取有有效活动的公司
		
		Date date = DateFormatUtil.convertStrToDate(reportDate, DATE_FORMAT);
		
		//根据统计时间获取报表的状态。可能存在的值为null（定时未跑），0（定时跑，未扣款），1（已扣款），2（已修改扣款详情）
		//如果值为null和0,设置isCharged的值为0，如果值为1，2，设置isCharged的值为2
		Integer isCharged = adGoogleAdwordsReportCampaignMapper.getIsCharged(date);

		isCharged = (isCharged == null || isCharged == 0) ? 0 : (isCharged == 1 || isCharged == 2) ? 2 : isCharged;
		
		CampaignCostPO campaignCostPO = new CampaignCostPO();
		campaignCostPO.setDate(date);
		campaignCostPO.setIsCharged(isCharged);
		
		/*关于google adwords的统计*/
		adGoogleAdwordsReportCampaignMapper.delete(campaignCostPO);//先将上一次的同步数据删除
		adGoogleAdwordsReportCampaignMapper.sync(campaignCostPO);//同步活动报表数据
		
		adGoogleAdwordsReportAdGroupMapper.delete(campaignCostPO);
		adGoogleAdwordsReportAdGroupMapper.sync(campaignCostPO);
		
		adGoogleAdwordsReportAdMapper.delete(campaignCostPO);
		adGoogleAdwordsReportAdMapper.sync(campaignCostPO);//同步ad报表数据
		
		adGoogleAdwordsReportUrlMapper.delete(campaignCostPO);
		adGoogleAdwordsReportUrlMapper.sync(campaignCostPO);
		
		adGoogleAdwordsReportDestinationUrlMapper.delete(campaignCostPO);
		adGoogleAdwordsReportDestinationUrlMapper.sync(campaignCostPO);
		
		adGoogleAdwordsReportGeoMapper.delete(campaignCostPO);
		adGoogleAdwordsReportGeoMapper.sync(campaignCostPO);
		
		adGoogleAdwordsReportKeywordsMapper.delete(campaignCostPO);
		adGoogleAdwordsReportKeywordsMapper.sync(campaignCostPO);
		
		/*关于Facebook的扣款统计*/
		adFacebookReportAdMapper.delete(campaignCostPO);
		adFacebookReportAdMapper.sync(campaignCostPO);
		
		adFacebookReportCampaignMapper.delete(campaignCostPO);
		adFacebookReportCampaignMapper.sync(campaignCostPO);
		
		adFacebookReportAdSetMapper.delete(campaignCostPO);
		adFacebookReportAdSetMapper.sync(campaignCostPO);
		for(Company company: companyList) 
		{
			Integer markupType = company.getMarkupType();//扣款类型
			BigDecimal  markupAmount = company.getMarkupAmount();//扣款值
			
			CampaignCostPO campaignCostPOTemp = new CampaignCostPO();
			campaignCostPOTemp.setMarkupAmount(markupAmount);
			campaignCostPOTemp.setMarkupType(markupType);
			campaignCostPOTemp.setDate(date);
			campaignCostPOTemp.setCompanyId(company.getId());
			
			switch (markupType)
			{
			case CompanyPO.DEDUCTION_TYPE_PERCENTAGE:
				/*关于google adwords的统计*/
				adGoogleAdwordsReportCampaignMapper.updateByPercentage(campaignCostPOTemp);
				adGoogleAdwordsReportAdGroupMapper.updateByPercentage(campaignCostPOTemp);
				adGoogleAdwordsReportAdMapper.updateByPercentage(campaignCostPOTemp);
				adGoogleAdwordsReportUrlMapper.updateByPercentage(campaignCostPOTemp);
				adGoogleAdwordsReportDestinationUrlMapper.updateByPercentage(campaignCostPOTemp);
				adGoogleAdwordsReportGeoMapper.updateByPercentage(campaignCostPOTemp);
				adGoogleAdwordsReportKeywordsMapper.updateByPercentage(campaignCostPOTemp);
				
				/*关于Facebook的扣款统计*/
				adFacebookReportAdMapper.updateByPercentage(campaignCostPOTemp);
				adFacebookReportCampaignMapper.updateByPercentage(campaignCostPOTemp);
				adFacebookReportAdSetMapper.updateByPercentage(campaignCostPOTemp);
				break;
			case CompanyPO.DEDUCTION_TYPE_CLICK_NUMBER:
				/*关于google adwords的统计*/
				adGoogleAdwordsReportCampaignMapper.updateByClicks(campaignCostPOTemp);
				adGoogleAdwordsReportAdGroupMapper.updateByClicks(campaignCostPOTemp);
				adGoogleAdwordsReportAdMapper.updateByClicks(campaignCostPOTemp);
				adGoogleAdwordsReportUrlMapper.updateByClicks(campaignCostPOTemp);
				adGoogleAdwordsReportDestinationUrlMapper.updateByClicks(campaignCostPOTemp);
				adGoogleAdwordsReportGeoMapper.updateByClicks(campaignCostPOTemp);
				adGoogleAdwordsReportKeywordsMapper.updateByClicks(campaignCostPOTemp);
				
				/*关于Facebook的扣款统计*/
				adFacebookReportAdMapper.updateByClicks(campaignCostPOTemp);
				adFacebookReportCampaignMapper.updateByClicks(campaignCostPOTemp);
				adFacebookReportAdSetMapper.updateByClicks(campaignCostPOTemp);
				break;
			default:
				break;
			}
			
			//如果可用余额 * 警告系数 < 预扣款金额,则给管理员发送警告
//			BigDecimal instantAmount = adGoogleAdwordsReportCampaignMapper.countAmountByCompanyId(campaign);
//			if(instantAmount == null)	continue;
//			
//			if(instantAmount != null && !company.getInstantAmount().equals(instantAmount)) {
//				company.setInstantAmount(instantAmount);
//				companyMapper.updateByPrimaryKeySelective(company);
//			}
		}
		
		logger.info("end excute updateCampaignCostByInstant");
	}
	
	public static void main(String[] args)
	{
		
	}
}
