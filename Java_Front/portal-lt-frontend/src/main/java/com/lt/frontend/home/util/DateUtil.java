package com.lt.frontend.home.util;

import java.sql.Timestamp;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

import com.lt.platform.util.lang.StringUtil;



/**
 * @Description 日期时间工具 
 * @Author zhuss
 */
public class DateUtil
{
	private static final Log log = LogFactory.getLog(DateUtil.class);
	
	
	/**
	 * 获取当前日期及时间
	 * @return 返回当前日期及时间
	 */
	public static Date getNow()
	{
		return Calendar.getInstance().getTime();
	}

	/**
	 * 获取两个日期中较小的日期
	 * @param date1 日期1
	 * @param date2 日期2
	 * @return 返回较小的日期
	 */
	public static Date getSmallDate(Date date1, Date date2)
	{
		return date1.compareTo(date2) < 0 ? date1 : date2;
	}

	/**
	 * 获取两个日期中较大的日期
	 * @param date1 日期1
	 * @param date2 日期2
	 * @return 返回较大的日期
	 */
	public static Date getBigDate(Date date1, Date date2)
	{
		return date1.compareTo(date2) > 0 ? date1 : date2;
	}

	/**
	 * 在指定的日期上增加年数
	 * @param yearAmount 年数
	 * @param date 指定日期
	 * @return 返回增加月数后的日期
	 */
	public static Date addYear2Date(int yearAmount, Date date)
	{
		Date newDate = null;
		if (date != null)
		{
			Calendar calendar = Calendar.getInstance();
			calendar.setTime(date);
			calendar.add(Calendar.YEAR, yearAmount);
			newDate = calendar.getTime();
		}
		return newDate;
	}

	/**
	 * 在指定的日期上增加月数
	 * @param monthAmount 月数
	 * @param date 指定日期
	 * @return 返回增加月数后的日期
	 */
	public static Date addMonth2Date(int monthAmount, Date date)
	{
		Date newDate = null;
		if (date != null)
		{
			Calendar calendar = Calendar.getInstance();
			calendar.setTime(date);
			calendar.add(Calendar.MONTH, monthAmount);
			newDate = calendar.getTime();
		}
		return newDate;
	}

	/**
	 * 在指定的日期上增加天数
	 * @param dayAmount 天数
	 * @param date 指定日期
	 * @return 返回增加天数后的日期
	 */
	public static Date addDay2Date(int dayAmount, Date date)
	{
		Date newDate = null;
		if (date != null)
		{
			Calendar calendar = Calendar.getInstance();
			calendar.setTime(date);
			calendar.add(Calendar.DAY_OF_MONTH, dayAmount);
			newDate = calendar.getTime();
		}
		return newDate;
	}

	/**
	 * 在指定的日期上增加小时数
	 * @param hourAmount 小时数
	 * @param date 指定日期
	 * @return 返回增加小时数后的日期
	 */
	public static Date addHour2Date(int hourAmount, Date date)
	{
		Date newDate = null;
		if (date != null)
		{
			Calendar calendar = Calendar.getInstance();
			calendar.setTime(date);
			calendar.add(Calendar.HOUR_OF_DAY, hourAmount);
			newDate = calendar.getTime();
		}
		return newDate;
	}
	
	/**
	 * 在指定的日期上增加小时数
	 * @param hourAmount 小时数
	 * @param date 指定日期 
	 * @param "yyyy-MM-dd HH:mm"
	 * @return 返回增加小时数后的日期
	 */
	public static String addHour2DateToString(int hourAmount, Date date,String format)
	{
		Date newDate = null;
		if (date != null)
		{
			Calendar calendar = Calendar.getInstance();
			calendar.setTime(date);
			calendar.add(Calendar.HOUR_OF_DAY, hourAmount);
			newDate = calendar.getTime();
		}
		return formatDate(format,newDate,"");
	}

	/**
	 * 在指定的日期上增加分钟数
	 * @param minuteAmount 分钟数
	 * @param date 指定日期
	 * @return 返回增加分钟数后的日期
	 */
	public static Date addMinute2Date(int minuteAmount, Date date)
	{
		Date newDate = null;
		if (date != null)
		{
			Calendar calendar = Calendar.getInstance();
			calendar.setTime(date);
			calendar.add(Calendar.MINUTE, minuteAmount);
			newDate = calendar.getTime();
		}
		return newDate;
	}

	/**
	 * 将日期转换成指定格式的字符串
	 * @param format 时间表现形式，例如："yyyy-MM-dd"，"yyyy-MM-dd HH:mm:ss"等
	 * @param date 待格式化的日期
	 * @return 返回格式化后的日期字符串
	 */
	public static String formatDate(String format, Date date)
	{
		return formatDate(format, date, "");
	}
	
	/**
	 * 日期字符串转换成指定格式
	 * @param str
	 * @param fromformat
	 * @param toformat
	 * @return
	 * @throws ParseException 
	 */
	public static String formatStrToStr(String str,String fromformat,String toformat) throws ParseException{
		SimpleDateFormat in = new SimpleDateFormat(fromformat);
		SimpleDateFormat out = new SimpleDateFormat(toformat);
		return out.format(in.parse(str));
	}

	/**
	 * 将日期转换成指定格式的字符串
	 * @param format 时间表现形式，例如："yyyy-MM-dd"，"yyyy-MM-dd HH:mm:ss"等
	 * @param date 待格式化的日期
	 * @param nullString 空日期的替换字符，满足特殊需要
	 * @return 返回格式化后的日期字符串
	 */
	public static String formatDate(String format, Date date, String nullString)
	{
		String formatStr = nullString;

		if (date != null)
		{
			SimpleDateFormat simpleDateFormat = new SimpleDateFormat(format);
			formatStr = simpleDateFormat.format(date);
		}

		return formatStr;
	}

	/**
	 * 将日期转换成"yyyy-MM-dd HH:mm:ss"格式的字符串
	 * @param date 待格式化的日期
	 * @return 返回格式化后的日期字符串
	 */
	public static String formatDateTime(Date date)
	{
		String formatStr = "";

		if (date != null)
		{
			SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			formatStr = simpleDateFormat.format(date);
		}

		return formatStr;
	}

	/**
	 * 将字符串解析成年月日期类型，如果字符串含有/则按/分割,否则按-分割
	 * @param dateYMStr 待解析的字符串
	 * @return 返回解析后的日期
	 */
	public static Date getDateYM(String dateYMStr)
	{
		Date date = null;
		try
		{
			if (dateYMStr != null)
			{
				String separator = dateYMStr.indexOf('/') > 0 ? "/" : "-";
				DateFormat dateFormat = new SimpleDateFormat("yyyy" + separator + "MM");
				date = dateFormat.parse(dateYMStr);
			}
		}
		catch(ParseException parse)
		{
			log.error("getDateYM()方法解析日期出错！", parse);
		}
		return date;
	}

	/**
	 * 将字符串解析成年月日日期类型，如果字符串含有/则按/分割,否则按-分割
	 * @param dateStr 待解析的字符串
	 * @return 返回解析后的日期
	 */
	public static Date getDate(String dateStr)
	{
		Date date = null;
		try
		{
			if (dateStr != null)
			{
				String separator = dateStr.indexOf('/') > 0 ? "/" : "-";
				DateFormat dateFormat = new SimpleDateFormat("yyyy" + separator + "MM" + separator + "dd");
				date = dateFormat.parse(dateStr);
			}
		}
		catch(ParseException parse)
		{
			log.error("getDate()方法解析日期出错！", parse);
		}
		return date;
	}

	/**
	 * 将字符串解析成日期类型，格式自定
	 * @param dateStr 待解析的字符串
	 * @return 返回解析后的日期
	 */
	public static Date getDate(String dateStr, String formatStr)
	{
		Date date = null;
		try
		{
			if (StringUtil.isNotBlank(formatStr)&&StringUtil.isNotBlank(dateStr))
			{
				DateFormat dateFormat = new SimpleDateFormat(formatStr);
				date = dateFormat.parse(dateStr);
			}
		}
		catch(ParseException parse)
		{
			log.error("getDate()方法解析日期出错！", parse);
		}
		return date;
	}

	/**
	 * 将字符串解析成年月日时分秒日期时间类型，如果字符串含有/则按/分割,否则以-分
	 * @param dateTimeStr 待解析的字符串
	 * @return 返回解析后的日期
	 */
	public static Date getDateTime(String dateTimeStr)
	{
		Date date = null;
		try
		{
			String separator = dateTimeStr.indexOf('/') > 0 ? "/" : "-";
			DateFormat dateFormat = new SimpleDateFormat("yyyy" + separator + "MM" + separator + "dd HH:mm:ss");
			date = dateFormat.parse(dateTimeStr);
		}
		catch(ParseException parse)
		{
			log.error("getDateTime()方法解析日期出错！", parse);
		}
		return date;
	}

	/**
	 * 获取传入日期的年份
	 * @param date 待解析的日期
	 * @return 返回该日期的年份
	 */
	public static int getYear(Date date)
	{
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.YEAR);
	}

	/**
	 * 获取传入日期的月份
	 * @param date 待解析的日期
	 * @return 返回该日期的月份
	 */
	public static int getMonth(Date date)
	{
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.MONTH) + 1;
	}

	/**
	 * 获取传入日期月份的日
	 * @param 待解析的日期
	 * @return 返回该日期的日
	 */
	public static int getDay(Date date)
	{
		Calendar c = Calendar.getInstance();
		c.setTime(date);
		return c.get(Calendar.DATE);
	}

	/**
	 * 两个日期的月份差
	 * @param fromDate 起始日期
	 * @param toDate 结束日期
	 * @return 返回两个日期的月份差，例1998-4-21~1998-6-21 相差2个月，返回2
	 */
	public static int getDiffMonths(Date fromDate, Date toDate)
	{
		Calendar c = Calendar.getInstance();
		c.setTime(fromDate);
		int fromYear = c.get(Calendar.YEAR);
		int fromMonth = c.get(Calendar.MONTH) + 1;
		c.setTime(toDate);
		int toYear = c.get(Calendar.YEAR);
		int toMonth = c.get(Calendar.MONTH) + 1;
		int monthCount = 0;

		if (toYear == fromYear)
		{
			monthCount = toMonth - fromMonth;
		}
		else if (toYear - fromYear == 1)
		{
			monthCount = 12 - fromMonth + toMonth;
		}
		else
		{
			monthCount = 12 - fromMonth + 12 * (toYear - fromYear - 1) + toMonth;
		}
		return monthCount;
	}

	/**
	 * 两个日期的天数差
	 * @param fromDate 起始日期
	 * @param toDate 结束日期
	 * @return 返回两个日期的天数差，例1998-4-21~1998-4-25 相差4天，返回4
	 */
	public static int getDiffDays(Date fromDate, Date toDate)
	{
		return (int) ((toDate.getTime() - fromDate.getTime()) / (1000 * 60 * 60 * 24));
	}

	
	/**
	 * 两个日期的小时差，自定义精度和舍入方式
	 * @param fromDate 起始日期
	 * @param toDate 结束日期
	 * @return 返回两个日期的天数差，例1998-4-21~1998-4-25 相差4天，返回4
	 */
	public static double getDiffHours(Date fromDate, Date toDate,int scale,int roundType)
	{
		//return Tools.numberDivide(toDate.getTime() - fromDate.getTime(), (1000 * 60 * 60 ), scale, roundType);
		return (int) ((toDate.getTime() - fromDate.getTime()) / (1000 * 60 * 60 ));
	}
	
	/**
	 * 两个日期的秒数差
	 * @param fromDate 起始日期
	 * @param toDate 结束日期
	 * @return 返回两个日期的秒数差，例1998-4-21 10:00:00~1998-4-21 10:00:50 相差50秒，返回50
	 */
	public static Long getDiffSeconds(Date fromDate, Date toDate)
	{
		Calendar fromCal = Calendar.getInstance();
		fromCal.setTime(fromDate);
		fromCal.set(Calendar.MILLISECOND, 0);

		Calendar toCal = Calendar.getInstance();
		toCal.setTime(toDate);
		toCal.set(Calendar.MILLISECOND, 0);
		Long diff = (toCal.getTime().getTime() - fromCal.getTime().getTime()) / 1000;
		return diff;
	}

	/**
	 * 获取一个星期中的第几天，周日算第一天
	 * @param date 待解析的日期
	 * @return 返回一个星期中的第几天
	 */
	public static int getDayOfWeek(Date date)
	{
		Calendar calendar = Calendar.getInstance();
		calendar.setTime(date);
		int dayOfWeek = calendar.get(Calendar.DAY_OF_WEEK);
		return dayOfWeek;
	}

	/**
	 * 获取一个星期中的第几天，周一算第一天
	 * @param date 待解析的日期
	 * @return 返回一个星期中的第几天
	 */
	public static int getChinaDayOfWeek(Date date)
	{
		Calendar calendar = Calendar.getInstance();
		calendar.setTime(date);
		int dayOfWeek = calendar.get(Calendar.DAY_OF_WEEK);
		if (1 == dayOfWeek)
		{
			dayOfWeek = 8;
		}
		return dayOfWeek - 1;
	}

	/**
	 * 获取一个月中的第几天，一个月中第一天的值为1
	 * @param date 待解析的日期
	 * @return 返回一个月中的第几天
	 */
	public static int getDayOfMonth(Date date)
	{
		Calendar calendar = Calendar.getInstance();
		calendar.setTime(date);
		int dayOfMonth = calendar.get(Calendar.DAY_OF_MONTH);
		return dayOfMonth;
	}

	/**
	 * 获取当前时间的时间戳，精确到毫秒
	 * @return 返回当前时间的时间戳
	 */
	public static Long getTimestamp()
	{
		return System.currentTimeMillis();
	}

	/**
	 * 获取某日的0时0分0秒的Date对象
	 * @param datetime 待解析的日期
	 * @return 传入日期的0时0分0秒的Date对象
	 */
	public static Date getDayStart(Date datetime)
	{
		if (null == datetime)
		{
			return null;
		}
		Calendar cal = Calendar.getInstance();
		cal.setTime(datetime);
		cal.set(Calendar.HOUR_OF_DAY, 0);
		cal.set(Calendar.MINUTE, 0);
		cal.set(Calendar.SECOND, 0);
		return cal.getTime();
	}

	/**
	 * 获取某日的23时59分59秒的Date对象
	 * @param datetime 待解析的日期
	 * @return Date 传入日期的23时59分59秒的Date对象
	 */
	public static Date getDayEnd(Date datetime)
	{
		if (null == datetime)
		{
			return null;
		}
		Calendar cal = Calendar.getInstance();
		cal.setTime(datetime);
		cal.set(Calendar.HOUR_OF_DAY, 23);
		cal.set(Calendar.MINUTE, 59);
		cal.set(Calendar.SECOND, 59);
		return cal.getTime();
	}

	/**
	 * 由Timestamp类型对象转换成Date类型对象
	 * @Time Apr 21, 2009 10:00:17 AM create
	 * @param timestamp
	 * @return Date
	 * @author lizhenqiang
	 */
	public static Date transToDate(Timestamp timestamp)
	{
		if (timestamp != null)
		{
			return new Date(timestamp.getTime());
		}
		return null;
	}

	/**
	 * 遍历指定年月，以周为循环生成一个6*7的二维数组，空闲位为Null
	 * @Time 2009-9-8 下午06:00:45 create
	 * @param year
	 * @param month
	 * @return
	 * @author maoliang
	 */
	public static Date[][] makeCalendar(int year, int month)
	{
		Date[][] dateArray = new Date[6][7];
		//Object[][]
		//指定年月的第一天
		Date date = DateUtil.getDate(year + "-" + month + "-01");
		//次月的第一天
		Date lastDate = DateUtil.addMonth2Date(1, date);
		//第一天是周几
		int firstDayWeek = DateUtil.getDayOfWeek(date);
		//将星期日处理为一周的最后一天
		if (1 == firstDayWeek)
		{
			firstDayWeek = 8;
		}
		int row = 0;
		int col = firstDayWeek - 2;
		//遍历一个月，以周为循环生成二维数组
		while (DateUtil.getDiffDays(date, lastDate) > 0)
		{
			if (col > 6)
			{
				row = row + 1;
				col = 0;
			}
			dateArray[row][col] = date;
			date = DateUtil.addDay2Date(1, date);
			col++;
		}

		return dateArray;
	}

	/**
	 * 获取指定年份的休息日列表
	 * @Time 2009-9-8 下午06:47:13 create
	 * @param year
	 * @return
	 * @author maoliang
	 */
	public static List<Date> getWeekEndList(Integer year)
	{
		Date date = DateUtil.getDate(year + "-01-01");
		//次年的第一天
		Date lastDate = DateUtil.addYear2Date(1, date);
		List<Date> weekendList = new ArrayList<Date>();
		while (DateUtil.getDiffDays(date, lastDate) > 0)
		{
			int dayOfweek = DateUtil.getChinaDayOfWeek(date);
			if (6 == dayOfweek || 7 == dayOfweek)
			{
				//System.out.println(DateUtil.formatDate("yyyy-mMM-dd", date) + ":" + dayOfweek);
				weekendList.add(date);
			}
			date = DateUtil.addDay2Date(1, date);
		}
		return weekendList;
	}
	
}
