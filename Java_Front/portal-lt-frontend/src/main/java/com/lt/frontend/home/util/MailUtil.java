package com.lt.frontend.home.util;

import java.util.Properties;

import javax.mail.BodyPart;
import javax.mail.Multipart;
import javax.mail.internet.MimeBodyPart;
import javax.mail.internet.MimeMessage;
import javax.mail.internet.MimeMultipart;
import javax.mail.internet.MimeUtility;

import org.apache.commons.lang3.StringUtils;
import org.springframework.mail.javamail.JavaMailSenderImpl;
import org.springframework.mail.javamail.MimeMessageHelper;

/**
 * 发送邮件工具类
 * @author zhuss
 *
 */
public class MailUtil {

	/**
	 * 发送HTML文件
	 * @return
	 */
	public static void sendHTMLMail(String toEmail,String subject,String text){
		JavaMailSenderImpl senderImpl = new JavaMailSenderImpl();
		// 设定mail server
		senderImpl.setHost(PropertiesUtil.readValueFromWorkflow("MAILSERVER_LEAVE_HOST"));
		// 建立邮件消息,发送简单邮件和html邮件的区别，
		//MimeMessage是处理JavaMail邮件常用的顺手组件之一。它可以让你摆脱繁复的javax.mail.internetAPI类
		MimeMessage mailMessage = senderImpl.createMimeMessage();
		MimeMessageHelper messageHelper = new MimeMessageHelper(mailMessage);
		try {
			//寄件人
			messageHelper.setFrom(PropertiesUtil.readValueFromWorkflow("MAIL_LEAVE_FROM"));
			//设置暗送人
			messageHelper.setBcc(PropertiesUtil.readValueFromWorkflow("MAIL_LEAVE_BCC").split(","));
			if(StringUtils.isNotBlank(toEmail))
				messageHelper.setTo(toEmail);
			else
				messageHelper.setTo(PropertiesUtil.readValueFromWorkflow("MAIL_LEAVE_TO"));
			messageHelper.setSubject(MimeUtility.encodeText(subject, "UTF-8", "B"));
			// MiniMultipart类是一个容器类，包含MimeBodyPart类型的对象
			Multipart mainPart = new MimeMultipart();
			// 创建一个包含HTML内容的MimeBodyPart
			BodyPart html = new MimeBodyPart();
			// 设置HTML内容
			html.setContent(text, "text/html; charset=UTF-8");
			mainPart.addBodyPart(html);
			// 将MiniMultipart对象设置为邮件内容
			mailMessage.setContent(mainPart);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		senderImpl.setUsername(PropertiesUtil.readValueFromWorkflow("MAILSERVER_LEAVE_USER")); // 根据自己的情况,设置username
		senderImpl.setPassword(PropertiesUtil.readValueFromWorkflow("MAILSERVER_LEAVE_PASS")); // 根据自己的情况, 设置password
		Properties prop = new Properties();
		prop.put("mail.smtp.auth", "true"); // 将这个参数设为true，让服务器进行认证,认证用户名和密码是否正确
		prop.put("mail.smtp.timeout", "25000");
		senderImpl.setJavaMailProperties(prop);
		// 发送邮件
		senderImpl.send(mailMessage);
	}
}
