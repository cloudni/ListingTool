package com.lt.backend.system.service.impl;

import java.math.BigDecimal;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.backend.system.service.ITransactionAuthorizeService;
import com.lt.dao.mapper.AdAdMapper;
import com.lt.dao.mapper.AdCampaignMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportAdMapper;
import com.lt.dao.mapper.AdGoogleAdwordsReportCampaignMapper;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.GoogleAdwordsAdMapper;
import com.lt.dao.mapper.NotificationMapper;
import com.lt.dao.mapper.TransactionAuthorizeMapper;
import com.lt.dao.mapper.TransactionChangeLogMapper;
import com.lt.dao.mapper.TransactionDetailMapper;
import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.model.AdAd;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.AdChangeLog;
import com.lt.dao.model.AdGoogleAdwordsReportAd;
import com.lt.dao.model.AdGoogleAdwordsReportCampaign;
import com.lt.dao.model.Company;
import com.lt.dao.model.GoogleAdwordsAd;
import com.lt.dao.model.Notification;
import com.lt.dao.model.Transaction;
import com.lt.dao.model.TransactionAuthorize;
import com.lt.dao.model.TransactionChangeLog;
import com.lt.dao.model.TransactionDetail;
import com.lt.dao.po.AdCampaignPO;
import com.lt.dao.po.AdGoogleAdwordsReportCampaignPO;
import com.lt.dao.po.CompanyPO;
import com.lt.dao.po.TransactionPO;
import com.lt.platform.util.config.CusotmizedPropertyUtil;
import com.lt.platform.util.time.DateFormatUtil;
@Service
public class TransactionAuthorizeServiceImpl implements ITransactionAuthorizeService
{
	private static Logger logger = LoggerFactory
			.getLogger(TransactionAuthorizeServiceImpl.class);
	
	@Autowired
	private AdCampaignMapper adCampaignMapper;
	
	@Autowired
	private TransactionAuthorizeMapper transactionAuthorizeMapper;
	
	@Autowired
	private TransactionMapper transactionMapper;
	
	@Autowired
	private CompanyMapper companyMapper;
	
	@Autowired
	private TransactionChangeLogMapper transactionChangeLogMapper;
	
	@Autowired
	private NotificationMapper notificationMapper;
	
	@Autowired
	private AdGoogleAdwordsReportCampaignMapper adGoogleAdwordsReportCampaignMapper;
	
	@Autowired
	private AdGoogleAdwordsReportAdMapper adGoogleAdwordsReportAdMapper;
	
	@Autowired
	private GoogleAdwordsAdMapper googleAdwordsAdMapper;
	
	@Autowired
	private AdAdMapper adAdMapper;
	
	@Autowired
	private TransactionDetailMapper transactionDetailMapper;
	
	private static final String AD_CAMPAIGN = "ADCampaign";
	private static final String AD_AD = "ADAD";
	
	private static final String DATE_FORMAT = "yyyy-MM-dd";
	
	@Override
	public void updateCampaignCost(String reportDate) 
	{
		List<Company> companyList = companyMapper.selectAliveActivitiCompaign();//获取有有效活动的公司
		
		List<AdCampaignPO> stopAdCampaignList = null;
		//List<AdGoogleAdwordsReportCampaign> googleCampaignTotalList = null;
		List<AdGoogleAdwordsReportCampaign> googleCampaignList = null;
		List<TransactionAuthorize> authorizeList = null;
		//List<Transaction> transactionList = null;
		List<Notification> notificationList = null;
		List<TransactionChangeLog> logList = null;
		
		TransactionChangeLog log = null;
		TransactionAuthorize authorize = null;
		Transaction transaction = null;
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
			
			adGoogleAdwordsReportCampaignMapper.syncByGoogleAdwordsReportCampaign(date);//同步活动报表数据至活动报表统计表
			adGoogleAdwordsReportAdMapper.syncByGoogleAdwordsReportAd(date);//同步广告报表数据至广告报表统计表
			
			AdCampaignPO adCampaign = new AdCampaignPO();
			adCampaign.setCompanyId(company.getId());
			adCampaign.setReportDate(reportDate);
			List<AdCampaignPO> adCampaignList = adCampaignMapper.selectSelective(adCampaign);//全部活动
			
			
			for(AdCampaignPO adCampaignPO: adCampaignList) 
			{
				if(googleCampaignList == null) {
					googleCampaignList = new ArrayList<AdGoogleAdwordsReportCampaign>();
				}
//				if(googleCampaignTotalList == null) {
//					googleCampaignTotalList = new  ArrayList<AdGoogleAdwordsReportCampaign>();
//				}
				
				AdGoogleAdwordsReportCampaignPO reportCampaign = new AdGoogleAdwordsReportCampaignPO();
				reportCampaign.setAdCampaignId(adCampaignPO.getId());
				reportCampaign.setDate(date);
				googleCampaignList = adGoogleAdwordsReportCampaignMapper.selectByCampaign(reportCampaign);//查询待统计的campaign报表数据
				
				BigDecimal chargAmount = updateGoogleAdwordsReportCampaign(googleCampaignList, markupType, markupAmount, adCampaignPO.getId());
				//googleCampaignTotalList.addAll(googleCampaignList);
				
				adCampaignPO.setChargAmount(chargAmount);
			}
			
			BigDecimal balance = company.getBalance();
			for(AdCampaignPO adCampaignPO: adCampaignList) 
			{
				if(adCampaignPO.getChargAmount() == null || adCampaignPO.getChargAmount().compareTo(new BigDecimal(0)) <= 0) {
					continue;
				}
				//如果账户余额小于活动花费，将活动的冻结金额解冻，用于扣款。完成以后
				//发站内消息，提示本次活动需停止
//				if(transactionList == null) {
//					transactionList = new ArrayList<Transaction>();
//				}
				
				if(balance.compareTo(adCampaignPO.getChargAmount()) == -1) 
				{
					if(stopAdCampaignList == null) 
					{
						stopAdCampaignList = new ArrayList<AdCampaignPO>();
					}
					if(authorizeList == null) 
					{
						authorizeList = new ArrayList<TransactionAuthorize>();
					}
					if(notificationList == null)
					{
						notificationList = new ArrayList<Notification>();
					}
					
					stopAdCampaignList.add(adCampaignPO.clone());
					
					balance = balance.add(adCampaignPO.getFreezeMoney());
					
					authorize = new TransactionAuthorize();
					authorize.setId(adCampaignPO.getTransactionAuthorizeId());
					authorize.setCompanyId(company.getId());
					authorize.setRefId(adCampaignPO.getId());
					authorize.setRefObject(AD_CAMPAIGN);
					authorize.setAmount(new BigDecimal(0));
					authorizeList.add(authorize);
					
					transaction = new Transaction();
					transaction.setRefId(authorize.getRefId());
					transaction.setRefObject(authorize.getRefObject());
					transaction.setCompanyId(adCampaign.getCompanyId());
					transaction.setTotal(adCampaignPO.getFreezeMoney());
					transaction.setNet(adCampaignPO.getFreezeMoney());
					transaction.setPaymentTransactionType(TransactionPO.PAYMENT_TYPE_UNFREEZE);
					transaction.setStatus(TransactionPO.STATE_SUCCESS);
					transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
					transaction.setCreateUserId(adCampaignPO.getCreateUserId());
					transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
					transaction.setUpdateUserId(adCampaignPO.getCreateUserId());
					transactionMapper.insertSelective(transaction);
					//transactionList.add(transaction);
					
					notification = new Notification();
					notification.setTitle("balance unfreeze");
					notification.setContent("campaign id: " + adCampaignPO.getId() + " "
							+ "campaign name: " + adCampaignPO.getName() + " "
							+ "unfreeze amount: " + adCampaignPO.getFreezeMoney());
					notification.setIsNew(1);
					notification.setCompanyId(company.getId());
					notification.setCompanyName(company.getName());
					notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
					notificationList.add(notification);
				} 
				balance = balance.subtract(adCampaignPO.getChargAmount());
				
				transaction = new Transaction();
				transaction.setRefId(adCampaignPO.getId());
				transaction.setRefObject(AD_CAMPAIGN);
				transaction.setCompanyId(adCampaign.getCompanyId());
				transaction.setTotal(adCampaignPO.getChargAmount());
				transaction.setNet(adCampaignPO.getChargAmount());
				transaction.setPaymentTransactionType(TransactionPO.PAYMENT_TYPE_DEDUCTION);
				transaction.setStatus(TransactionPO.STATE_SUCCESS);
				transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				transaction.setCreateUserId(adCampaignPO.getCreateUserId());
				transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				transaction.setUpdateUserId(adCampaignPO.getCreateUserId());
				transactionMapper.insertSelective(transaction);
				int transactionId = transactionMapper.selectLastestInsertId();
				//transactionList.add(transaction);
				
				updateAdCost(date, adCampaignPO.getId(), transactionId, markupType, markupAmount, reportDate);
			}
			
			BigDecimal unfreezeAmount = new BigDecimal(0);//公司解冻资金
			if(stopAdCampaignList != null) 
			{
				Iterator<AdCampaignPO> iter = stopAdCampaignList.iterator();
				Integer authorizeDay = company.getAuthorizeDay();
				BigDecimal times = new BigDecimal(authorizeDay != null ? authorizeDay : 1);//默认冻结一天
				
				while(iter.hasNext()) 
				{
					AdCampaignPO stopAdCampaign = iter.next();
					BigDecimal freeze = stopAdCampaign.getBudget().multiply(times);
					
					if(balance.compareTo(freeze) >= 0) 
					{
						balance = balance.subtract(freeze);
						authorizeList.remove(new TransactionAuthorize(stopAdCampaign.getCompanyId()));
					} else {
						if(logList == null) {
							logList = new ArrayList<TransactionChangeLog>();
						}
						log = new TransactionChangeLog();
						log.setCompanyId(company.getId());
						log.setObjectType(1);
						log.setObjectId(stopAdCampaign.getId());
						log.setAction(AdChangeLog.ACTION_UPDATE);
						log.setContent("Balance is insufficient, emergency stop campaign:" 
								+ stopAdCampaign.getName() +" (company:" + company.getName() + ")");
						log.setStatus(AdChangeLog.STATUS_PENDING);
						log.setPriority(AdChangeLog.PRIORITY_URGENT);
						log.setCreateUserId(adCampaign.getCreateUserId());
						log.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
						logList.add(log);
						
						notification = new Notification();
						notification.setCompanyId(company.getId());
						notification.setCompanyName(company.getName());
						notification.setTitle("balance deduction");
						notification.setContent("campaign id: " + stopAdCampaign.getId() + " "
								+ "campaign name: " + stopAdCampaign.getName() + " "
								+ "deduction amount: " + stopAdCampaign.getFreezeMoney());
						notification.setIsNew(1);
						notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
						notificationList.add(notification);
						
						unfreezeAmount = unfreezeAmount.add(stopAdCampaign.getFreezeMoney());
					}
				}
			}
			if(company.getBalance().compareTo(balance) != 0) {
				company.setBalance(balance);
				company.setFreezeAmount(company.getFreezeAmount().subtract(unfreezeAmount));
				companyMapper.updateByPrimaryKeySelective(company);
			}
		}
		
		if(authorizeList != null && authorizeList.size() > 0) {
			transactionAuthorizeMapper.updateBatch(authorizeList);
		}
		if(logList != null && logList.size() > 0) 
		{
			transactionChangeLogMapper.batchInsertSelective(logList);
		}
//		if(transactionList != null && transactionList.size() > 0) 
//		{
//			transactionMapper.batchInsert(transactionList);
//		}
		if(notificationList != null && notificationList.size() > 0) 
		{
			notificationMapper.batchInsert(notificationList);
		}
//		if(googleCampaignTotalList != null && googleCampaignTotalList.size() > 0) 
//		{
//			adGoogleAdwordsReportCampaignMapper.batchUpdate(googleCampaignTotalList);
//		}
	}

	@Override
	public void freezeCampaignBudget(AdCampaign adCampaign)
	{
		
		Object o = CusotmizedPropertyUtil.getContextProperty("transaction.authorize.freeze.times");
		BigDecimal times = new BigDecimal(o != null ? Integer.parseInt(o.toString()) : 0);
		//TODO test junit
		times = new BigDecimal(2);
		BigDecimal freeze = adCampaign.getBudget().multiply(times);
		
		Transaction transaction = new Transaction();
		transaction.setCompanyId(adCampaign.getCompanyId());
		transaction.setTotal(freeze);
		transaction.setNet(freeze);
		transaction.setStatus(TransactionPO.STATE_SUCCESS);
		transaction.setPaymentTransactionType(TransactionPO.PAYMENT_TYPE_FREEZE);
		transactionMapper.insertSelective(transaction);

		TransactionAuthorize transactionAuthorize = new TransactionAuthorize();
		transactionAuthorize.setRefId(adCampaign.getId());
		
		
		transactionAuthorize.setAmount(freeze);
		
		transactionAuthorize.setCompanyId(adCampaign.getCompanyId());
		transactionAuthorize.setRefObject(AD_CAMPAIGN);
		transactionAuthorizeMapper.insertSelective(transactionAuthorize);
		
		Map<String, Object> map = new HashMap<String, Object>();
		map.put("id", adCampaign.getCompanyId());
		map.put("total", freeze.negate());
		companyMapper.updateBalanceById(map);
		
		Notification notification = new Notification();
		notification.setTitle("balance freeze");
		notification.setContent("campaign id: " + adCampaign.getId() + " "
				+ "campaign name: " + adCampaign.getName() + " "
				+ "freeze amount: " + freeze);
		notification.setIsNew(1);
		notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
	
	}
	
	/**
	 * 返回活动的费用=所有属于此adCampaign的所有google的ChargeAmount
	 * @param googleCampaignList
	 * @param markupType
	 * @param markupAmount
	 */
	private BigDecimal updateGoogleAdwordsReportCampaign(List<AdGoogleAdwordsReportCampaign> googleCampaignList, Integer markupType, BigDecimal  markupAmount, Integer adCampaignId) {
		BigDecimal total = new BigDecimal(0);
		for(AdGoogleAdwordsReportCampaign campaign: googleCampaignList) {
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
			adGoogleAdwordsReportCampaignMapper.update(campaign);
			total = total.add(result);
		}
		return total;
	}
	
	private void updateAdCost(Date date, Integer campaignId, Integer transactionId, Integer markupType, BigDecimal  markupAmount, String reportDate) {
		List<AdAd> adAdList = adAdMapper.selectByAdCampaign(campaignId);
		
		for(AdAd adAd: adAdList)
		{
			List<GoogleAdwordsAd> googleAdwordsAdlist = googleAdwordsAdMapper.selectByAdId(adAd.getId());
			
			BigDecimal total = new BigDecimal(0);
			for(GoogleAdwordsAd ad: googleAdwordsAdlist) 
			{
				AdGoogleAdwordsReportAd googleAdwordsReportAdCount = new AdGoogleAdwordsReportAd();
				googleAdwordsReportAdCount.setDate(date);
				googleAdwordsReportAdCount.setId(ad.getId());
				List<AdGoogleAdwordsReportAd> reportAdList = adGoogleAdwordsReportAdMapper.selectByAdId(googleAdwordsReportAdCount);
				
				total = updateGoogleAdwordsReportAd(reportAdList, markupType, markupAmount, adAd.getId()).add(total);
			}

			TransactionDetail detail = new TransactionDetail();
			detail.setTransacitonId(transactionId);
			detail.setAmount(total);
			detail.setRefId(adAd.getId());
			detail.setRefObject(AD_AD);
			detail.setChargeDateUtc(DateFormatUtil.converStrToInteger(reportDate + " 00:00:00"));
			detail.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
			transactionDetailMapper.insertSelective(detail);
		}
		
	}
	
	/**
	 * ad的费用=所有属于此ad的所有google的ChargeAmount
	 * @param googleCampaignList
	 * @param markupType
	 * @param markupAmount
	 */
	private BigDecimal updateGoogleAdwordsReportAd(List<AdGoogleAdwordsReportAd> googleAdList, Integer markupType, BigDecimal  markupAmount, Integer adAdId) {
		BigDecimal total = new BigDecimal(0);
		for(AdGoogleAdwordsReportAd ad: googleAdList) {
			BigDecimal cost = ad.getCost();
			if(cost.compareTo(new BigDecimal(0)) == 0) {
				continue;
			}
			BigDecimal result = null;
			cost = cost.divide(new BigDecimal(1000000), 4, BigDecimal.ROUND_HALF_UP);
			switch (markupType)
			{
			case CompanyPO.DEDUCTION_TYPE_PERCENTAGE:
				result = cost.multiply(markupAmount).add(cost);
				break;
			case CompanyPO.DEDUCTION_TYPE_FIXED:
				result = cost.add(markupAmount);
				break;
			case CompanyPO.DEDUCTION_TYPE_CLICK_NUMBER:
				result = cost.add(new BigDecimal(ad.getClicks()).multiply(markupAmount));
				break;
			default:
				break;
			}
			
			ad.setChargeAmount(result);
			ad.setIsCharged(Boolean.TRUE);
			ad.setMarkupAmount(markupAmount);
			ad.setMarkupType(markupType.byteValue());
			ad.setAdAdId(adAdId);
			adGoogleAdwordsReportAdMapper.updateSelective(ad);
			
			total = total.add(result);
		}
		return total;
	}
}
