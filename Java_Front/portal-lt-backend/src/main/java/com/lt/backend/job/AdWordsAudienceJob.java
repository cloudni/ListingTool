package com.lt.backend.job;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang.StringUtils;
import org.apache.log4j.Logger;
import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;

import com.google.api.ads.adwords.axis.factory.AdWordsServices;
import com.google.api.ads.adwords.axis.v201502.cm.Operator;
import com.google.api.ads.adwords.axis.v201502.rm.AdwordsUserListServiceInterface;
import com.google.api.ads.adwords.axis.v201502.rm.ExpressionRuleUserList;
import com.google.api.ads.adwords.axis.v201502.rm.Rule;
import com.google.api.ads.adwords.axis.v201502.rm.RuleItem;
import com.google.api.ads.adwords.axis.v201502.rm.RuleItemGroup;
import com.google.api.ads.adwords.axis.v201502.rm.StringKey;
import com.google.api.ads.adwords.axis.v201502.rm.StringRuleItem;
import com.google.api.ads.adwords.axis.v201502.rm.StringRuleItemStringOperator;
import com.google.api.ads.adwords.axis.v201502.rm.UserList;
import com.google.api.ads.adwords.axis.v201502.rm.UserListMembershipStatus;
import com.google.api.ads.adwords.axis.v201502.rm.UserListOperation;
import com.google.api.ads.adwords.axis.v201502.rm.UserListReturnValue;
import com.google.api.ads.adwords.lib.client.AdWordsSession;
import com.google.common.collect.Lists;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.lt.dao.po.GoogleAdwordsAudiencePO;
import com.lt.platform.util.CommonUtil;
import com.lt.platform.util.MailUtil;
import com.lt.platform.util.config.PropertiesUtil;
import com.lt.platform.util.http.HttpClientResultUtil;
import com.lt.platform.util.http.HttpClientUtil;
import com.lt.platform.util.security.MD5Util;
import com.lt.thirdpartylibrary.googleadwords.util.AdwordsUtil;

/**
 * AdWords Audience定时任务
 * 
 * 
 */
public class AdWordsAudienceJob extends QuartzJobBean {
    
    private static Logger log = Logger.getLogger(AdWordsAudienceJob.class);
//  "http://192.168.0.48/portal-lt-backend/common/adwords/";
    private static final String ADWORDS_URL = "http://transaction.itemtool.com/portal-lt-backend/common/adwords/";
    
    @Override
    protected void executeInternal(JobExecutionContext context) throws JobExecutionException {

            
            log.info("Audience Job 开始");
            // 下载报表
            try {
                Map<String, String> map = new HashMap<String, String>();
                map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
                HttpClientResultUtil result = HttpClientUtil.post(ADWORDS_URL + "getAudienceJobList.shtml", map);
                String content = result.getContext();
                log.info("Audience Job List:" + content);
                if (StringUtils.isEmpty(content)) return;
                
                List<GoogleAdwordsAudiencePO> list = new Gson().fromJson(content, new TypeToken<List<GoogleAdwordsAudiencePO>>(){}.getType());
                if (list == null || list.size() == 0) return;
                
                String ids = createAudience2Adwords(list);
                if (ids == null) {
                    return;
                }
                log.info("ids:" + ids);

                map = new HashMap<String, String>();
                map.put("ids", ids);
                map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
                HttpClientUtil.post(ADWORDS_URL + "updateAudienceRun.shtml", map);
                
                log.info("Audience Job结束");
                MailUtil.sendHTMLMail(PropertiesUtil.getContextProperty("mail.error.to").toString(), "Audience Job运行成功", "生成数据：" + content);
            } catch (Exception e) {
                MailUtil.sendHTMLMail(PropertiesUtil.getContextProperty("mail.error.to").toString(), "Audience Job运行异常", "Exception:\n" + CommonUtil.getExceptionMessage(e));
                /*log.error("Audience Job下载异常，休眠10分钟后重试！");
                try
                {
                    Thread.sleep(10 * 60 * 1000);
                } catch (InterruptedException e1)
                {
                }*/
                return;
            }
        
    }
    
    public static String createAudience2Adwords(List<GoogleAdwordsAudiencePO> list) throws Exception {
        AdWordsSession session = AdwordsUtil.getSession();

        AdwordsUserListServiceInterface userListService = new AdWordsServices().get(session, AdwordsUserListServiceInterface.class);
        String ids = "";
        for (GoogleAdwordsAudiencePO po : list) {
            try {
                @SuppressWarnings("unchecked")
                Map<String, Double> mapData = new Gson().fromJson(po.getRule(), Map.class);
                RuleItem checkoutRuleItem;
                RuleItem[] ris = new RuleItem[mapData.size()];
                int i = 0;
                for (Map.Entry<String, Double> entry : mapData.entrySet()){
                    String value = entry.getValue().toString();
                    StringKey pageTypeKey = new StringKey(entry.getKey());
                    
                    StringRuleItem checkoutStringRuleItem = new StringRuleItem();
                    checkoutStringRuleItem.setKey(pageTypeKey);
                    checkoutStringRuleItem.setOp(StringRuleItemStringOperator.EQUALS);
                    checkoutStringRuleItem.setValue(value.substring(0, value.indexOf(".")));
                    
                    checkoutRuleItem = new RuleItem();
                    checkoutRuleItem.setStringRuleItem(checkoutStringRuleItem);
                    ris[i++] = checkoutRuleItem;
                }
                RuleItemGroup checkoutMultipleItemGroup = new RuleItemGroup();
                checkoutMultipleItemGroup.setItems(ris);
                Rule rule = new Rule();
                rule.setGroups(new RuleItemGroup[] {checkoutMultipleItemGroup});
                ExpressionRuleUserList expressionUserList = new ExpressionRuleUserList();
                expressionUserList.setName(po.getName());
                expressionUserList.setRule(rule);
                expressionUserList.setStatus(UserListMembershipStatus.OPEN);
                expressionUserList.setMembershipLifeSpan(90L);
                
                List<UserListOperation> operations = Lists.newArrayList();
                //for (UserList userList : new UserList[] {expressionUserList, dateUserList}) {
                for (UserList userList : new UserList[] {expressionUserList}) {
                    UserListOperation operation = new UserListOperation();
                    operation.setOperand(userList);
                    operation.setOperator(Operator.ADD);
                    operations.add(operation);
                }
                // Submit the operations.
                UserListReturnValue result = userListService.mutate(operations.toArray(new UserListOperation[operations.size()]));
    
                for (UserList userListResult : result.getValue()) {
                  log.info(String.format("User list added with ID %d, name '%s', status '%s', list type '%s',"
                      + " accountUserListStatus '%s', description '%s'.%n",
                      userListResult.getId(),
                      userListResult.getName(),
                      userListResult.getStatus().getValue(),
                      userListResult.getListType() == null ? null : userListResult.getListType().getValue(),
                      userListResult.getAccountUserListStatus().getValue(),
                      userListResult.getDescription()));
                }
                ids += "," + po.getPkId();
            } catch (Exception e) {
                log.error("创建Audience异常:" + po.getName() + CommonUtil.getExceptionMessage(e));
            }
        }
        if (ids.length() > 0) {
            return ids.substring(1);
        }
        return null;
    }
    
    public static void main(String[] args) throws Exception
    {

        Map<String, String> map = new HashMap<String, String>();
        map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
        HttpClientResultUtil result = HttpClientUtil.post(ADWORDS_URL + "getAudienceJobList.shtml", map);
        String content = result.getContext();
        log.info("Audience Job List:" + content);
        if (StringUtils.isEmpty(content)) return;
        
        List<GoogleAdwordsAudiencePO> list = new Gson().fromJson(content, new TypeToken<List<GoogleAdwordsAudiencePO>>(){}.getType());

        if (list == null || list.size() == 0) return;
        
        createAudience2Adwords(list);
    }
}