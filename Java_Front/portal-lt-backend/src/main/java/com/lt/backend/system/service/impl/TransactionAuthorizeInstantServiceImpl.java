package com.lt.backend.system.service.impl;

import java.math.BigDecimal;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.system.service.ITransactionAuthorizeInstantService;
import com.lt.dao.mapper.AdCampaignMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportCampaignTempMapper;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.GoogleAdwordsAdMapper;
import com.lt.dao.mapper.NotificationMapper;
import com.lt.dao.mapper.TransactionChangeLogMapper;
import com.lt.dao.model.AdChangeLog;
import com.lt.dao.model.AdGoogleAdwordsReportCampaignTemp;
import com.lt.dao.model.Company;
import com.lt.dao.model.Notification;
import com.lt.dao.model.TransactionChangeLog;
import com.lt.dao.po.AdCampaignPO;
import com.lt.dao.po.AdGoogleAdwordsReportCampaignTempPO;
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
	private AdGoogleAdwordsReportCampaignTempMapper adGoogleAdwordsReportCampaignTempMapper;
	
	private static final String DATE_FORMAT = "yyyy-MM-dd";
	
	private static final Float WARN_VALUE = (float) 0.8;

	@Override
	public void updateCampaignCostByInstant(String reportDate)
	{
		List<Company> companyList = companyMapper.selectAliveActivitiCompaign();//获取有有效活动的公司
		
		List<AdGoogleAdwordsReportCampaignTemp> googleCampaignList = null;
		List<Notification> notificationList = null;
		List<TransactionChangeLog> logList = null;
		
		TransactionChangeLog log = null;
		Notification notification = null;
		
		DateFormat dft = new SimpleDateFormat(DATE_FORMAT);
		Date date = null;
		try
		{
			date = dft.parse(reportDate);
		} catch (Exception e)
		{
			logger.error(e.getMessage(), e);
		}
		
		for(Company company: companyList) 
		{
			Integer markupType = company.getMarkupType();//扣款类型
			BigDecimal  markupAmount = company.getMarkupAmount();//扣款值
			BigDecimal balance = company.getBalance();//账户可用余额
			BigDecimal instantAmount = new BigDecimal(0);//账户预扣金额
			
			adGoogleAdwordsReportCampaignTempMapper.delete(date);//先将上一次的同步数据删除
			adGoogleAdwordsReportCampaignTempMapper.syncByGoogleAdwordsReportCampaign(date);//同步活动报表数据至活动报表统计表
			
			AdCampaignPO adCampaign = new AdCampaignPO();
			adCampaign.setCompanyId(company.getId());
			adCampaign.setReportDate(reportDate);
			List<AdCampaignPO> adCampaignList = adCampaignMapper.selectSelective(adCampaign);//全部活动
			
			
			for(AdCampaignPO adCampaignPO: adCampaignList) 
			{
				if(googleCampaignList == null) {
					googleCampaignList = new ArrayList<AdGoogleAdwordsReportCampaignTemp>();
				}
				if(notificationList == null)
				{
					notificationList = new ArrayList<Notification>();
				}
				
				AdGoogleAdwordsReportCampaignTempPO reportCampaign = new AdGoogleAdwordsReportCampaignTempPO();
				reportCampaign.setAdCampaignId(adCampaignPO.getId());
				reportCampaign.setDate(date);
				googleCampaignList = adGoogleAdwordsReportCampaignTempMapper.selectByCampaign(reportCampaign);//查询待统计的campaign报表数据
				
				BigDecimal chargAmount = updateGoogleAdwordsReportCampaign(googleCampaignList, markupType, markupAmount, adCampaignPO.getId());
				
				if(chargAmount == null || chargAmount.compareTo(new BigDecimal(0)) <= 0) {
					continue;
				}
				
				instantAmount = instantAmount.add(chargAmount);
			}
			
			//如果可用余额 * 警告系数 < 预扣款金额,则给管理员发送警告
			if(balance.multiply(new BigDecimal(WARN_VALUE)).compareTo(instantAmount) < 0) {
				if(logList == null) {
					logList = new ArrayList<TransactionChangeLog>();
				}
				log = new TransactionChangeLog();
				log.setCompanyId(company.getId());
				log.setObjectType(1);
				log.setObjectId(0);
				log.setAction(AdChangeLog.ACTION_UPDATE);
				log.setContent("warn: " + company.getName() + " company balance " + balance + ", deduct the amount of " + instantAmount);
				log.setStatus(AdChangeLog.STATUS_PENDING);
				log.setPriority(AdChangeLog.PRIORITY_HIGHEST);
				log.setCreateUserId(adCampaign.getCreateUserId());
				log.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				logList.add(log);
				
				notification = new Notification();
				notification.setTitle("balance warn");
				notification.setContent(company.getName() + " company balance " + balance + ", deduct the amount of " + instantAmount + ", Please recharge time");
				notification.setIsNew(1);
				notification.setCompanyId(company.getId());
				notification.setCompanyName(company.getName());
				notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				notificationList.add(notification);
			}
			
			//如果可用余额 <= 预扣款金额，则提示管理员去google adwords 关闭该公司的所有活动
			if(balance.compareTo(instantAmount) <= 0) {
				log = new TransactionChangeLog();
				log.setCompanyId(company.getId());
				log.setObjectType(1);
				log.setObjectId(0);
				log.setAction(AdChangeLog.ACTION_UPDATE);
				log.setContent(company.getName() + " company balance " + balance + ", deduct the amount of " + instantAmount + ", please stop all google campaign");
				log.setStatus(AdChangeLog.STATUS_PENDING);
				log.setPriority(AdChangeLog.PRIORITY_HIGHEST);
				log.setCreateUserId(adCampaign.getCreateUserId());
				log.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				logList.add(log);
				
				notification = new Notification();
				notification.setTitle("balance warn");
				notification.setContent(company.getName() + " company balance " + balance + ", deduct the amount of " + instantAmount + ", So we will stop campaigns");
				notification.setIsNew(1);
				notification.setCompanyId(company.getId());
				notification.setCompanyName(company.getName());
				notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				notificationList.add(notification);
			}
			
			if(company.getInstantAmount().compareTo(instantAmount) != 0) {
				company.setInstantAmount(instantAmount);
				companyMapper.updateByPrimaryKeySelective(company);
			}
		}
		
		if(logList != null && logList.size() > 0) 
		{
			transactionChangeLogMapper.batchInsertSelective(logList);
		}
		if(notificationList != null && notificationList.size() > 0) 
		{
			notificationMapper.batchInsert(notificationList);
		}

	}

	/**
	 * 返回活动的费用=所有属于此adCampaign的所有google的ChargeAmount
	 * @param googleCampaignList
	 * @param markupType
	 * @param markupAmount
	 */
	private BigDecimal updateGoogleAdwordsReportCampaign(List<AdGoogleAdwordsReportCampaignTemp> googleCampaignList, Integer markupType, BigDecimal  markupAmount, Integer adCampaignId) {
		BigDecimal total = new BigDecimal(0);
		for(AdGoogleAdwordsReportCampaignTemp campaign: googleCampaignList) {
			BigDecimal result = null;
			BigDecimal totalCost = campaign.getTotalCost().divide(new BigDecimal(1000000), 4, BigDecimal.ROUND_HALF_UP);
			switch (markupType)
			{
			case CompanyPO.DEDUCTION_TYPE_PERCENTAGE:
				result = totalCost.multiply(markupAmount).add(totalCost);
				break;
			case CompanyPO.DEDUCTION_TYPE_FIXED:
				result = totalCost.add(markupAmount);
				break;
			case CompanyPO.DEDUCTION_TYPE_CLICK_NUMBER:
				result = totalCost.add(new BigDecimal(campaign.getClicks()).multiply(markupAmount));
				break;
			default:
				break;
			}
			
			campaign.setChargeAmount(result);
			campaign.setIsCharged(Boolean.TRUE);
			campaign.setMarkupAmount(markupAmount);
			campaign.setMarkupType(markupType.byteValue());
			campaign.setAdCampaignId(adCampaignId);
			adGoogleAdwordsReportCampaignTempMapper.updateByClicks(campaign);
			total = total.add(result);
		}
		return total;
	}
	
}
