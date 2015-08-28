package com.lt.backend.system.service.impl;

import java.math.BigDecimal;
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
import com.lt.dao.mapper.AdAdvertiseMapper;
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
import com.lt.dao.mapper.TransactionAuthorizeMapper;
import com.lt.dao.mapper.TransactionChangeLogMapper;
import com.lt.dao.mapper.TransactionDetailMapper;
import com.lt.dao.mapper.TransactionMapper;
import com.lt.dao.model.AdAdvertise;
import com.lt.dao.model.AdCampaign;
import com.lt.dao.model.AdChangeLog;
import com.lt.dao.model.AdFacebookReportAd;
import com.lt.dao.model.Company;
import com.lt.dao.model.Notification;
import com.lt.dao.model.Transaction;
import com.lt.dao.model.TransactionAuthorize;
import com.lt.dao.model.TransactionChangeLog;
import com.lt.dao.model.TransactionDetail;
import com.lt.dao.po.AdCampaignPO;
import com.lt.dao.po.AdGoogleAdwordsReportAdPO;
import com.lt.dao.po.CampaignCostPO;
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
	private AdAdvertiseMapper adAdvertiseMapper;
	@Autowired
	private TransactionDetailMapper transactionDetailMapper;
	@Autowired
	private AdGoogleAdwordsReportAdGroupMapper adGoogleAdwordsReportAdGroupMapper;
	@Autowired
	private AdGoogleAdwordsReportUrlMapper adGoogleAdwordsReportUrlMapper;
	@Autowired
	private AdGoogleAdwordsReportDestinationUrlMapper adGoogleAdwordsReportDestinationUrlMapper;
	@Autowired
	private AdGoogleAdwordsReportGeoMapper adGoogleAdwordsReportGeoMapper;
	@Autowired
	private AdGoogleAdwordsReportKeywordsMapper adGoogleAdwordsReportKeywordsMapper;
	@Autowired
	private AdFacebookReportAdSetMapper adFacebookReportAdSetMapper;
	@Autowired
	private AdFacebookReportCampaignMapper adFacebookReportCampaignMapper;
	@Autowired
	private AdFacebookReportAdMapper adFacebookReportAdMapper;
	
	private static final String AD_CAMPAIGN = "ADCampaign";
	private static final String AD_AD = "ADAdvertise";
	
	private static final String DATE_FORMAT = "yyyy-MM-dd";
	
	private static final String CONTENTS_FORMAT = "广告系列：<a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>, %s 扣除费用：<span style=\"color: red\">$%s</span>";
	private static final String UNFREEZE_TITLE = "解冻广告系列<a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>的冻结金额$%S";
	private static final String UNFREEZE_CONTENT = "<a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>广告系列冻结金额被解冻，冻结金额：$%s, 解冻金额将冲入账户余额，如不及时充值，此广告系列将被停止。";
	private static final String FREEZE_TITLE = "广告系列<a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>冻结金额$%S";
	private static final String FREEZE_CONTENT = "<a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>广告系列冻结金额$%s, 从账户余额划至冻结金额。";
	private static final String DEDUCTION_TITLE = "%s <a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>广告系列 扣款$%s";
	private static final String DEDUCTION_CONTENT = "统计时间：%s，  广告系列：<a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>，  账户余额：$%s，  扣款：$%s，  剩余金额：$%s";
	private static final String WARN_TITLE = "账户余额即将用尽，请及时充值";
	private static final String WARN_CONTENT = "当前账户余额：$%s（不包含冻结金额$%s）, 每天广告系列预算总金额：$%s";
	private static final String CHANGE_LOG_WARN_CONTENT = "警告：当前账户余额将用尽， 公司：%s, 当前账户余额：$%s（不包含冻结金额$%s）, 每天广告系列预算总金额：$%s";
	private static final String CHANGE_LOG__STOP_UNFREEZE_CONTENT = "<a href=\"https://www.itemtool.com/index.php/marketing/advertisement/ADCampaign/view/id/%s.html\" target=\"_blank\">%s</a>广告系列冻结金额被解冻，冻结金额：$%s, 请及时停止广告系列。";
	
	@Override
	public void updateCampaignCost(String reportDate)  throws Exception
	{
		Date date = DateFormatUtil.convertStrToDate(reportDate, DATE_FORMAT);
		
		List<Company> companyList = companyMapper.selectAliveActivitiCompaign();//获取有有效活动的公司
		
		logger.info("start excute cost company cost about campaign");
		for(Company company: companyList) 
		{
			
			List<AdCampaignPO> stopAdCampaignList = new ArrayList<AdCampaignPO>();
			List<TransactionAuthorize> authorizeList = new ArrayList<TransactionAuthorize>();
			//List<Transaction> transactionList = null;
			List<Notification> notificationList = new ArrayList<Notification>();
			List<TransactionChangeLog> logList = new ArrayList<TransactionChangeLog>();
			
			BigDecimal tempBalance = company.getBalance();//账户可用余额,用于临时统计
			BigDecimal balance = company.getBalance();//账户可用余额
			BigDecimal totalCampaignBudget = BigDecimal.ZERO;//账户总预算
			
			AdCampaignPO adCampaign = new AdCampaignPO();
			adCampaign.setCompanyId(company.getId());
			adCampaign.setReportDate(reportDate);
			List<AdCampaignPO> adCampaignList = adCampaignMapper.selectSelective(adCampaign);//全部活动
			
			
			for(AdCampaignPO adCampaignPO: adCampaignList) 
			{
				totalCampaignBudget = totalCampaignBudget.add(adCampaignPO.getBudget());
				/**获取活动扣款*/
				CampaignCostPO campaignCostPO = new CampaignCostPO();
				campaignCostPO.setLtAdCampaignId(adCampaignPO.getId());
				campaignCostPO.setDate(date);
				BigDecimal chargAmount = adGoogleAdwordsReportCampaignMapper.countAmountByCampaignId(campaignCostPO);
				
				/*获取Facebook 活动扣款*/
				BigDecimal facebookAmount = adFacebookReportCampaignMapper.countAmountByCampaignId(campaignCostPO);
				
				chargAmount = chargAmount.add(facebookAmount);
				adCampaignPO.setChargeAmount(chargAmount);
				//BigDecimal chargAmount = adCampaignPO.getChargeAmount();
				
				if(chargAmount == null || BigDecimal.ZERO.setScale(4).equals(chargAmount))
					continue;
				
				//如果是修改扣费结果,修改transaction金额，修改company的balance（先不考虑balance可能为负数的情况）
				/*if(2 == adCampaignPO.getIsCharged())
				{
					//查询该活动在报表日期已存在的扣款交易
					TransactionPO record = new TransactionPO();
					record.setRefId(adCampaignPO.getId());
					record.setRefObject(AD_CAMPAIGN);
					record.setRefDate(reportDate);
					record.setPaymentTransactionType(TransactionPO.PAYMENT_TYPE_DEDUCTION);
					TransactionPO tranPo = transactionMapper.selectByRefObject(record);
					//即上一次统计结果和这次统计结果不一致,账户余额 = 账户余额 + 上一次扣款 - 这次扣款
					if(tranPo != null && !chargAmount.equals(tranPo.getNet()))
					{
						tempBalance = tempBalance.add(tranPo.getNet()).subtract(chargAmount);
						
						tranPo.setTotal(chargAmount);
						tranPo.setNet(chargAmount);
						tranPo.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
						transactionMapper.updateByPrimaryKeySelective(tranPo);
					}
					
					updateTransactionDetail(adCampaignPO.getId(), reportDate);
					continue;
				//如果已经处理，不再重新处理
				} else if(1 == adCampaignPO.getIsCharged())
				{
					continue;
				//如果为待处理，先按顺序，统计剩余金额，和待停止的活动（因冻结金额可能被解冻）
				} else {*/
					//如果可用余额小于该活动花费，则解冻该活动的冻结金额
					//(前提是冻结金额仍存在，正常逻辑，只要活动在运行，冻结金额就应该存在，
					//但是目前停止活动是人为触发，不排除时间差存在导致没有冻结资金但是活动仍然在运行)
					if(tempBalance.compareTo(chargAmount) == -1 && adCampaignPO.getFreezeMoney().compareTo(BigDecimal.ZERO.setScale(4)) == 1) 
					{
						tempBalance = tempBalance.add(adCampaignPO.getFreezeMoney());//将冻结金额放入可用余额
						stopAdCampaignList.add(adCampaignPO.clone());//加入至待停止的活动集合
					} 
					tempBalance = tempBalance.subtract(chargAmount);
				/*}*/
			}
			
			/**处理待停止的活动*/
			BigDecimal unfreezeAmount = BigDecimal.ZERO;//公司解冻资金
			if(!stopAdCampaignList.isEmpty()) 
			{
				Iterator<AdCampaignPO> iter = stopAdCampaignList.iterator();
				
				while(iter.hasNext()) 
				{
					//如果账户余额大于待停止活动的冻结金额，将不再停止此活动
					AdCampaignPO stopAdCampaign = iter.next();
					BigDecimal freeze = stopAdCampaign.getFreezeMoney();
					
					if(tempBalance.compareTo(freeze) >= 0) 
					{
						tempBalance = tempBalance.subtract(freeze);
					} else 
					{
						/**解冻冻结金额*/
						TransactionAuthorize authorize = new TransactionAuthorize();
						authorize.setId(stopAdCampaign.getTransactionAuthorizeId());
						authorize.setCompanyId(company.getId());
						authorize.setRefId(stopAdCampaign.getId());
						authorize.setRefObject(AD_CAMPAIGN);
						authorize.setAmount(BigDecimal.ZERO);
						authorizeList.add(authorize);
						
						/**解冻相关交易记录*/
						Transaction transaction = new Transaction();
						transaction.setType(TransactionPO.TYPE_SYSTEM);
						transaction.setRefId(authorize.getRefId());
						transaction.setRefObject(authorize.getRefObject());
						transaction.setCompanyId(adCampaign.getCompanyId());
						transaction.setTotal(stopAdCampaign.getFreezeMoney());
						transaction.setNet(stopAdCampaign.getFreezeMoney());
						transaction.setPaymentTransactionType(TransactionPO.PAYMENT_TYPE_UNFREEZE);
						transaction.setStatus(TransactionPO.STATE_SUCCESS);
						transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
						transaction.setCreateUserId(0);
						transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
						transaction.setUpdateUserId(0);
						transactionMapper.insertSelective(transaction);
						//transactionList.add(transaction);
						
						/**解冻发送站内信，通知客户*/
						String freezeMoneyStr = freeze.setScale(2, BigDecimal.ROUND_HALF_UP).toString();
						Notification notification = new Notification();
						notification.setTitle(String.format(UNFREEZE_TITLE, stopAdCampaign.getId(), stopAdCampaign.getName(), freezeMoneyStr));
						notification.setContent(String.format(UNFREEZE_CONTENT, stopAdCampaign.getId(), stopAdCampaign.getName(), freezeMoneyStr));
						notification.setIsNew(1);
						notification.setCompanyId(company.getId());
						notification.setCompanyName(company.getName());
						notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
						notificationList.add(notification);
						
						/**发送变更记录，通知管理员*/
						TransactionChangeLog log = new TransactionChangeLog();
						log.setCompanyId(company.getId());
						log.setObjectType(1);
						log.setObjectId(stopAdCampaign.getId());
						log.setAction(AdChangeLog.ACTION_UPDATE);
						log.setContent(String.format(CHANGE_LOG__STOP_UNFREEZE_CONTENT, stopAdCampaign.getId(), stopAdCampaign.getName(), freezeMoneyStr));
						log.setStatus(AdChangeLog.STATUS_PENDING);
						log.setPriority(AdChangeLog.PRIORITY_URGENT);
						log.setCreateUserId(0);
						log.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
						logList.add(log);
						
						unfreezeAmount = unfreezeAmount.add(stopAdCampaign.getFreezeMoney());
					}
				}
			}
			balance = balance.add(unfreezeAmount);//将全部的解冻金额加入账户余额
			
			/**记录活动扣款详情**/
			for(AdCampaignPO adCampaignPO: adCampaignList) 
			{
				BigDecimal chargAmount = adCampaignPO.getChargeAmount();
				if(chargAmount == null || BigDecimal.ZERO.setScale(4).equals(chargAmount))
					continue;
				
				//如果状态为已修改，逻辑待定
				if(2 == adCampaignPO.getIsCharged())
				{
					continue;
				//如果已经处理，逻辑待定
				} else if(1 == adCampaignPO.getIsCharged())
				{
					continue;
				}
				
				/**交易扣款*/
				Transaction transaction = new Transaction();
				transaction.setType(TransactionPO.TYPE_SYSTEM);
				transaction.setRefId(adCampaignPO.getId());
				transaction.setRefObject(AD_CAMPAIGN);
				transaction.setRefDate(reportDate);
				transaction.setCompanyId(adCampaign.getCompanyId());
				transaction.setTotal(chargAmount);
				transaction.setNet(chargAmount);
				transaction.setPaymentTransactionType(TransactionPO.PAYMENT_TYPE_DEDUCTION);
				transaction.setStatus(TransactionPO.STATE_SUCCESS);
				transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				transaction.setCreateUserId(0);
				transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				transaction.setUpdateUserId(0);
				
				//格式广告系列：XXXX，2015/05/25扣除费用 $60.06
				String rDate = reportDate.replace("-", "/");
				String amount = chargAmount.setScale(2, BigDecimal.ROUND_HALF_UP).toString();
				String contents = String.format(CONTENTS_FORMAT, adCampaignPO.getId(), adCampaignPO.getName(), rDate, amount);
				transaction.setContents(contents);
				transactionMapper.insertSelective(transaction);
				Integer transactionId = transactionMapper.selectLastestInsertId();
				//transactionList.add(transaction);
				
				//处理交易详情
				insertTransactionDetail(adCampaignPO.getId(), transactionId, reportDate);
				
				/**将扣款信息发送站内信给客户*/
				String balanceStr = balance.setScale(2, BigDecimal.ROUND_HALF_UP).toString();
				balance = balance.subtract(chargAmount);//账户余额去除当前活动的花费
				String lastBalance = balance.setScale(2, BigDecimal.ROUND_HALF_UP).toString();
				
				Notification notification = new Notification();
				notification.setCompanyId(company.getId());
				notification.setCompanyName(company.getName());
				notification.setTitle(String.format(DEDUCTION_TITLE, reportDate, adCampaignPO.getId(), adCampaignPO.getName(), amount));
				notification.setContent(String.format(DEDUCTION_CONTENT, reportDate, adCampaignPO.getId(), adCampaignPO.getName(), balanceStr, amount, lastBalance));
				notification.setIsNew(1);
				notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				notificationList.add(notification);
			}

			if(authorizeList.size() > 0) {
				transactionAuthorizeMapper.updateBatch(authorizeList);
			}
			if(logList.size() > 0) 
			{
				transactionChangeLogMapper.batchInsertSelective(logList);
			}
//			if(transactionList.size() > 0) 
//			{
//				transactionMapper.batchInsert(transactionList);
//			}
			if(notificationList.size() > 0) 
			{
				notificationMapper.batchInsert(notificationList);
			}
			
			if(company.getBalance().compareTo(balance) != 0) {
				company.setBalance(balance);
				company.setAuthorizeAmount(company.getAuthorizeAmount().subtract(unfreezeAmount));
				company.setInstantAmount(BigDecimal.ZERO);
				companyMapper.updateByPrimaryKeySelective(company);
			}
			
			/**如果账户余额不足一天的活动总预算时的相关操作*/
		
			//如果可用余额 <= 活动总预算，则提示管理员去google adwords 关闭该公司的所有活动
			String balanceStr = balance.setScale(2, BigDecimal.ROUND_HALF_UP).toString();
			String totalCampaignBudgetStr = totalCampaignBudget.setScale(2, BigDecimal.ROUND_HALF_UP).toString();
			if(balance.compareTo(totalCampaignBudget) <= 0) {
				/**发送警告信息给管理员*/
				TransactionChangeLog log = new TransactionChangeLog();
				log.setCompanyId(company.getId());
				log.setObjectType(1);
				log.setObjectId(0);
				log.setAction(AdChangeLog.ACTION_UPDATE);
				log.setContent(String.format(CHANGE_LOG_WARN_CONTENT, company.getName(), balanceStr, company.getAuthorizeAmount(), totalCampaignBudgetStr));
				log.setStatus(AdChangeLog.STATUS_PENDING);
				log.setPriority(AdChangeLog.PRIORITY_HIGHEST);
				log.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				logList.add(log);
				
				/**发送警告信息给客户*/
				Notification notification = new Notification();
				notification.setTitle(WARN_TITLE);
				notification.setContent(String.format(WARN_CONTENT, balanceStr, company.getAuthorizeAmount(), totalCampaignBudgetStr));
				notification.setIsNew(1);
				notification.setCompanyId(company.getId());
				notification.setCompanyName(company.getName());
				notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				notificationList.add(notification);
			}
		}
		
		adGoogleAdwordsReportAdGroupMapper.updateCharged(date);
		adGoogleAdwordsReportAdMapper.updateCharged(date);
		adGoogleAdwordsReportUrlMapper.updateCharged(date);
		adGoogleAdwordsReportCampaignMapper.updateCharged(date);
		adGoogleAdwordsReportDestinationUrlMapper.updateCharged(date);
		adGoogleAdwordsReportGeoMapper.updateCharged(date);
		adGoogleAdwordsReportKeywordsMapper.updateCharged(date);
		
		adFacebookReportAdSetMapper.updateCharged(date);
		adFacebookReportCampaignMapper.updateCharged(date);
		adFacebookReportAdMapper.updateCharged(date);
		
		logger.info("end excute cost company cost about campaign");
	}

	
	
	private void insertTransactionDetail(Integer campaignId, Integer transactionId, String reportDate) {
		Date date = DateFormatUtil.convertStrToDate(reportDate, DATE_FORMAT);
		
		List<AdAdvertise> adAdList = adAdvertiseMapper.selectByAdCampaign(campaignId);
		for(AdAdvertise adAd: adAdList)
		{
			AdGoogleAdwordsReportAdPO reportAd = new AdGoogleAdwordsReportAdPO();
			reportAd.setLtAdAdvertiseId(adAd.getId());
			reportAd.setDate(date);
			BigDecimal adTotal = adGoogleAdwordsReportAdMapper.countAmountByAdId(reportAd);
			
			TransactionDetail detail = new TransactionDetail();
			detail.setTransacitonId(transactionId);
			detail.setAmount(adTotal);
			detail.setRefId(adAd.getId());
			detail.setRefObject(AD_AD);
			detail.setRefDate(reportDate);
			detail.setChargeDateUtc(DateFormatUtil.converStrToInteger(reportDate + " 00:00:00"));
			detail.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
			detail.setCreateUserId(0);
			detail.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
			detail.setUpdateUserId(0);
			transactionDetailMapper.insertSelective(detail);
		}
	}
	
	//修改交易历史详情
	private void updateTransactionDetail(Integer campaignId, String reportDate) {
		Date date = DateFormatUtil.convertStrToDate(reportDate, DATE_FORMAT);
		
		List<AdAdvertise> adAdList = adAdvertiseMapper.selectByAdCampaign(campaignId);
		for(AdAdvertise adAd: adAdList)
		{
			AdGoogleAdwordsReportAdPO reportAd = new AdGoogleAdwordsReportAdPO();
			reportAd.setLtAdAdvertiseId(adAd.getId());
			reportAd.setDate(date);
			BigDecimal adTotal = adGoogleAdwordsReportAdMapper.countAmountByAdId(reportAd);
			
			AdFacebookReportAd faceBookAd = new AdFacebookReportAd();
			faceBookAd.setLtAdAdvertiseId(adAd.getId());
			faceBookAd.setDate(date);
			BigDecimal facebookTotal = adFacebookReportAdMapper.countAmountByAdId(faceBookAd);
			
			adTotal = adTotal.add(facebookTotal);
			TransactionDetail para = new TransactionDetail();
			para.setRefId(adAd.getId());
			para.setRefObject(AD_AD);
			para.setRefDate(reportDate);
			TransactionDetail detail = transactionDetailMapper.getDetailByRefObject(para);
			
			//如果不相等，表示重新下载adwords的report的cost发生了变化，与交易详情不相等，修改交易详情
			if(adTotal != null && detail != null && !adTotal.equals(detail.getAmount()))
			{
				detail.setAmount(adTotal);
				detail.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
				transactionDetailMapper.updateByPrimaryKeySelective(detail);
			}
		}
	}
	
	@Override
	public void freezeCampaignBudget(AdCampaign adCampaign)
	{
		if(adCampaign.getBudget().compareTo(BigDecimal.ZERO) == 1)
		{
			logger.warn("adcampaign[id : %s, name : %s] budget is null or 0");
			return;
		}
		
		Object o = CusotmizedPropertyUtil.getContextProperty("transaction.authorize.freeze.times");
		BigDecimal times = new BigDecimal(o != null ? Integer.parseInt(o.toString()) : 1);//默认一天
		BigDecimal freeze = adCampaign.getBudget().multiply(times);
		
		Transaction transaction = new Transaction();
		transaction.setCompanyId(adCampaign.getCompanyId());
		transaction.setFee(BigDecimal.ZERO);
		
		TransactionAuthorize historyAuthorize = transactionAuthorizeMapper.selectByRefObject(adCampaign.getId(), AD_CAMPAIGN);
		//如果不存在冻结历史，则
		if(historyAuthorize == null )
		{
			
		} else if (freeze.compareTo(historyAuthorize.getAmount())  > 0)
		{
			
		} else if (freeze.compareTo(historyAuthorize.getAmount())  < 0)
		{
			
		} else {
			return;
		}
		
		transaction.setTotal(freeze);
		transaction.setNet(freeze);
		
		transaction.setStatus(TransactionPO.STATE_SUCCESS);
		transaction.setPaymentTransactionType(TransactionPO.PAYMENT_TYPE_FREEZE);
		transaction.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		transaction.setCreateUserId(0);
		transaction.setUpdateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
		transaction.setUpdateUserId(0);
		transactionMapper.insertSelective(transaction);
		
		TransactionAuthorize transactionAuthorize = new TransactionAuthorize();
		transactionAuthorize.setRefId(adCampaign.getId());
		transactionAuthorize.setRefObject(AD_CAMPAIGN);
		transactionAuthorize.setAmount(freeze);
		transactionAuthorize.setCompanyId(adCampaign.getCompanyId());
		transactionAuthorizeMapper.insertSelective(transactionAuthorize);
		
		Map<String, Object> map = new HashMap<String, Object>();
		map.put("id", adCampaign.getCompanyId());
		map.put("total", freeze.negate());
		companyMapper.updateBalanceById(map);
		
		String freezeStr = freeze.setScale(2, BigDecimal.ROUND_HALF_UP).toString();
		Notification notification = new Notification();
		notification.setTitle(String.format(FREEZE_TITLE, adCampaign.getId(), adCampaign.getName(), freezeStr));
		notification.setContent(String.format(FREEZE_CONTENT, adCampaign.getId(), adCampaign.getName(), freezeStr));
		notification.setIsNew(1);
		notification.setCompanyId(adCampaign.getCompanyId());
		//notification.setCompanyName(adCampaign.get);
		notification.setCreateTimeUtc(DateFormatUtil.getCurrentIntegerTime());
	
	}
	
	public static void main(String[] args)
	{
		BigDecimal bd = new BigDecimal("4.156211");
		System.out.println(bd.setScale(2, BigDecimal.ROUND_HALF_UP).toString());
	}
}
