package com.lt.platform.util.time;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.apache.commons.lang3.time.DateFormatUtils;
import org.joda.time.DateTime;
import org.joda.time.format.DateTimeFormat;
import org.joda.time.format.DateTimeFormatter;

import com.lt.platform.framework.exception.RDPException;
import com.lt.platform.util.lang.ObjectUtil;

/**
 * 
 * @ClassName: DateUtil
 * @author:  wuwh 
 * @CreateDate: 2014-3-28 下午4:16:18   
 * @UpdateUser: wuwh   
 * @UpdateDate: 2014-3-28 下午4:16:18   
 * @UpdateRemark: 说明本次修改内容
 * @Description:  应用服务日期covert
 * @version: V1.0
 */
public class DateFormatUtil extends DateFormatUtils{
    /**
     * 
     * @Title: convertDateToStr
     * @author:  wuwh 
     * @CreateDate: 2014-3-28 下午4:22:28   
     * @UpdateUser: wuwh   
     * @UpdateDate: 2014-3-28 下午4:22:28   
     * @UpdateRemark: 说明本次修改内容
     * @Description:  返回自己所需格式的日期，如2014-12-13 yyyy-MM-dd
     * @version: V1.0
     * @param date 日期函数
     * @param pattern 返回自己所需字符型的日期
     * @return
     * @throws RDPException 
     */
    public static String convertDateToStr(Date date, String pattern) {
        final DateTimeFormatter formatter = DateTimeFormat.forPattern(pattern);
        if(ObjectUtil.isNotNull(date)){
        	 return formatter.print(new DateTime(date.getTime()));
        }
        return "";
       
    }
    /**
     * 
     * @Title: convertStrToDate
     * @author:  wuwh 
     * @CreateDate: 2014-3-28 下午5:07:02   
     * @UpdateUser: wuwh   
     * @UpdateDate: 2014-3-28 下午5:07:02   
     * @UpdateRemark: 说明本次修改内容
     * @Description:  字符日期转换自己所需格式的日期
     * @version: V1.0
     * @param date
     * @param pattern
     * @return
     * @throws RDPException
     */
    public static Date convertStrToDate(String date, String pattern) throws RDPException {
        final DateTimeFormatter formatter = DateTimeFormat.forPattern(pattern);
        if(ObjectUtil.isNotNull(date)){
        	 return formatter.parseDateTime(date).toDate();
        }
        return null;
       
    }
    /**
     * 
     * @Title: getDate
     * @author:  wuwh 
     * @CreateDate: 2014-3-28 下午5:12:34   
     * @UpdateUser: wuwh   
     * @UpdateDate: 2014-3-28 下午5:12:34   
     * @UpdateRemark: 说明本次修改内容
     * @Description:  获取时间信息
     * @version: V1.0
     * @return
     * @throws RDPException
     */
    public static Date getDate() throws RDPException {
       return new DateTime().toDate();
       
    }
    
    public static Integer paypalTimeStringToLongTime(String paypalTimeString) {
		DateFormat dft = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		String formatString = paypalTimeString.replace("T", " ").replace("Z", "");
		Integer longTime = 0;
		try
		{
			longTime = (int) dft.parse(formatString).getTime();
		} catch (ParseException e)
		{
			
			e.printStackTrace();
		}
		return longTime;
	}
	
    /**
     * 获取当前的时间的Integer型值，到秒
     * @return
     */
	public static Integer getCurrentIntegerTime() {
		long date = System.currentTimeMillis()/1000;
		
		return (Integer)new Long(date).intValue();
	}
	
	public static String convertIntegerToString(Integer date, String pattern) {
		DateFormat dft = new SimpleDateFormat(pattern);
		
		return dft.format(new Date((long)date * 1000));
	}
	
	public static String convertIntegerToString(Integer date) {
		
		return convertIntegerToString(date, "yyyy-MM-dd HH:mm:ss");
	}
	
	public static Integer converStrToInteger(String date, String pattern) {
		long lon = 0;
		try
		{
			lon = new SimpleDateFormat(pattern).parse(date).getTime()/1000;
		} catch (ParseException e)
		{
			e.printStackTrace();
		}
		return (Integer)new Long(lon).intValue();
	}
	
	public static Integer converStrToInteger(String date) {
		
		return converStrToInteger(date, "yyyy-MM-dd HH:mm:ss");
	}
	
}
