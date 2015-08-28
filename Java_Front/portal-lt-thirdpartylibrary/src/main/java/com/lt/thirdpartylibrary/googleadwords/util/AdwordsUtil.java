package com.lt.thirdpartylibrary.googleadwords.util;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.google.api.ads.adwords.lib.client.AdWordsSession;
import com.google.api.ads.common.lib.auth.OfflineCredentials;
import com.google.api.ads.common.lib.auth.OfflineCredentials.Api;
import com.google.api.client.auth.oauth2.Credential;
import com.lt.platform.util.CommonUtil;

public class AdwordsUtil
{
    private static Logger log = LoggerFactory.getLogger(AdwordsUtil.class);
    
    /**
     * 取得Google AdwordsSession
     * @return
     */
    public static AdWordsSession getSession() throws Exception
    {
        Credential oAuth2Credential;
        try
        {
            oAuth2Credential = new OfflineCredentials.Builder()
                    .forApi(Api.ADWORDS).fromFile().build().generateCredential();

            // Construct an AdWordsSession.
            AdWordsSession session = new AdWordsSession.Builder().fromFile()
                    .withOAuth2Credential(oAuth2Credential).build();
            return session;
        } catch (Exception e)
        {
            log.error("创建adwords session 失败！\n" + CommonUtil.getExceptionMessage(e));
            throw e;
        }
    }
    
}
