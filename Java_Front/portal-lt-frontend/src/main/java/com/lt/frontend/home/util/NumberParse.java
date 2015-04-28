package com.lt.frontend.home.util;

import java.text.DecimalFormat;
public class NumberParse {
	private static final DecimalFormat RMB  =  new DecimalFormat("###,###.##");
	private static final DecimalFormat df  =  new DecimalFormat("########.#########");
	private static final DecimalFormat usDF =  new DecimalFormat("###,###.#########");
	private static 	final	DecimalFormat   IntegerFormat   =   new   DecimalFormat("###,###"); 
	public static String parseDouble(Long i1, Long i2) {
		DecimalFormat df = new DecimalFormat("##.##");
		String s = "";
		if (i2 == 0) {
			s = "0%";
		} else {
			Double d = 0.0, d1 = 0.0, d2 = 0.0;
			d1 = Double.parseDouble(df.format(i1));
			d2 = Double.parseDouble(df.format(i2));
			d = (d2 / d1) * 100;
			s = df.format(d) + "%";
		}

		return s;
	}

	public static String parseLong(Long d, String fmtString) {
		DecimalFormat df = null;
		if (fmtString == null) {
			df = new DecimalFormat("##.##");
		} else {
			new DecimalFormat(fmtString);
		}

		String s = df.format(d);

		return s;
	}

	
	public static Double parseStrToDouble(String doubleStr) {
		if(doubleStr == null || doubleStr.isEmpty()){
			doubleStr = "0";
		}
		String s = doubleStr.replace(",", "");
		return Double.parseDouble(s);
	}
	

	public static String parseDoubleToStr(Double d) {
		if(d == 0 || d == null){
			return "0";
		}
		String s = df.format(d);
		return s;
	}
	
	public static String parseDoubleToStr(Double d,boolean usFlag) {
		String s = "0";
		if(d == 0 || d == null){
			return "0";
		}
		if(usFlag){
			s = usDF.format(d);
		}else{
			s = df.format(d);
		}
		
		return s;
	}
	
	public static String parseLong(Long l) {
		String s = "";
		if (l == null) {
			s = " ";
		} else {
			DecimalFormat df = new DecimalFormat("###,###");
			s = df.format(l);
		}
		return s;
	}
	
	/**
	 * mm:ss
	 * @param durations
	 * @return mm:ss
	 */
	public static String getMinutesByDuration(Long durations){
		String minutes = "";
		Long reverseDurations = Math.abs(durations);
		if(reverseDurations == null || reverseDurations == 0){
			minutes = "0";
		}
		if(reverseDurations%60 != 0){
			if(reverseDurations%60<10){
				minutes = IntegerFormat.format(reverseDurations/60)+":0"+Integer.parseInt(reverseDurations%60+"");
			}else{
				minutes = IntegerFormat.format(reverseDurations/60)+":"+reverseDurations%60;
			}
		}else{
			minutes =IntegerFormat.format(reverseDurations/60)+":00";
		}
		if(reverseDurations.equals(durations)){
			return minutes;
		}else{
			return "-"+minutes;
		}
	}
	
	/**
	 * 两个通话时长之差
	 * @param endDurationStr 
	 * @param startDurationStr
	 * @return mm:ss
	 */
	public static String getMinutesByDurationStr(String endDurationStr,String startDurationStr){
		endDurationStr = endDurationStr.replace(" ", "");
		startDurationStr = startDurationStr.replace(" ", "");
		Long endDurations   = getDurations(endDurationStr);
		Long startDurations = getDurations(startDurationStr);
		return getMinutesByDurationStr(endDurations, startDurations);
	}
	
	/**
	 * 两个通话时长之差
	 * @param endDurationStr 
	 * @param startDurationStr
	 * @return mm:ss
	 */
	public static String getMinutesByDurationStr(String endDurationStr,Long startDurations){
		String subMinutes   = "0";
		Long endDurations   = getDurations(endDurationStr);
		return getMinutesByDurationStr(endDurations, startDurations);
	}
	
	/**
	 * 两个通话时长之差
	 * @param endDurationStr 
	 * @param startDurationStr
	 * @return mm:ss
	 */
	public static String getMinutesByDurationStr(Long endDurations,Long startDurations){
		String subMinutes   = "0";
		Long subDurations   = endDurations-startDurations;
		subMinutes          = getMinutesByDuration(subDurations);
		return subMinutes;
	}
	
	/**
	 * 根据 mm:ss返回Long型的时长
	 * @param durationStr
	 * @return
	 */
	public static Long getDurations(String durationStr){
		durationStr = durationStr.trim();
		if(durationStr != null && !durationStr.isEmpty() && !durationStr.equals("0")){
			durationStr = durationStr.replace(",", "");
			Long durations = Long.parseLong(durationStr.split(":")[0])*60+Long.parseLong(durationStr.split(":")[1]);
			return durations;
		}else{
			return 0l;
		}
	}
	public static void main(String[] args) {
		System.out.println(getMinutesByDuration(120l));
		System.out.println(getMinutesByDuration(268l));
		System.out.println(getMinutesByDurationStr("4:48","2:00"));
	}
}
