/**   
 * @Title: CusotmizedPropertyUtil.java 
 * @Package com.lt.platform.util.config 
 * @Description: 锟斤拷一锟戒话锟斤拷锟斤拷锟斤拷锟侥硷拷锟斤拷什么 
 * Copyright: Copyright (c) 2014 
 * Company:wuwh team by iss
 * @author: wuwh   
 * @date: 2014锟斤拷5锟斤拷19锟斤拷 锟斤拷锟斤拷4:17:55 
 * @version: V1.0
 * update Release(锟侥硷拷锟斤拷锟斤拷锟铰�
 * <pre>
 * author--updateDate--description----------------------Flag锟斤拷锟斤拷锟斤拷锟斤拷
 * wuwh    2014-5-1    锟斤拷锟斤拷codesyle                      #wuwh001
 *
 *
 *
 * </pre>
 *
 */
package com.lt.thirdpartylibrary.paypal.util;

import java.util.Properties;

import org.springframework.beans.BeansException;
import org.springframework.beans.factory.config.ConfigurableListableBeanFactory;
import org.springframework.beans.factory.config.PropertyPlaceholderConfigurer;

public class PaypalCusotmizedPropertyUtil extends PropertyPlaceholderConfigurer {

	@Override
	protected void processProperties(
			ConfigurableListableBeanFactory beanFactoryToProcess,
			Properties props) throws BeansException {
		
		GeneratePaypalApiContext.initConfig(props);
	}

}
