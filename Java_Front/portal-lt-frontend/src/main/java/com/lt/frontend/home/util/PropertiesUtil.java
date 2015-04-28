package com.lt.frontend.home.util;

import java.io.InputStream;
import java.util.Properties;

/**
 * 解析属性文件工具类
 * 
 * @author zhuss
 * 
 */
public class PropertiesUtil {

	/**
	 * 利用属性文件的load的方法读取属性文件,key为文件中的字段名
	 * 
	 * @param key
	 * @return
	 */
	public static String readValueFromWorkflow(String key) {
		String fileName = "/properties/workflow.properties";
		//String filePath = Class.class.getClass().getResource("/").getPath() + fileName;  
		Properties props = new Properties();
		InputStream in = null;
		String value = "";
		try {
			in = PropertiesUtil.class.getResourceAsStream(fileName);
			props.load(in);
			value = props.getProperty(key);
			in.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return value;
	}
	
	/**
	 * 利用属性文件的load的方法读取属性文件,key为文件中的字段名
	 * 
	 * @param key
	 * @return
	 */
	public static String readValueFromReport(String key) {
		String fileName = "/properties/report.properties";
		//String filePath = Class.class.getClass().getResource("/").getPath() + fileName;  
		Properties props = new Properties();
		InputStream in = null;
		String value = "";
		try {
			in = PropertiesUtil.class.getResourceAsStream(fileName);
			props.load(in);
			value = props.getProperty(key);
			in.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return value;
	}
	
	/**
	 * 读取指定文件中的属性值
	 * @param fileName	文件名
	 * @param key		属性
	 * @return
	 * @date: 2014年9月1日
	 */
	public static String getValue(String fileName, String key) {
		Properties props = new Properties();
		InputStream in = null;
		String value = null;
		try {
			in = PropertiesUtil.class.getResourceAsStream(fileName);
			props.load(in);
			value = props.getProperty(key);
			in.close();
		} catch (Exception e) {
			e.printStackTrace();
		}
		return value;
		
	}
	
}
