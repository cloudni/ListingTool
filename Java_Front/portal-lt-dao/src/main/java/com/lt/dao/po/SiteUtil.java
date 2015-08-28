package com.lt.dao.po;

import java.util.HashMap;
import java.util.Map;

public class SiteUtil
{
	private static Map<Integer, String> siteMap = new HashMap<Integer, String>();
	static {
		siteMap.put(0, "US");
		siteMap.put(100, "eBayMotors");
		siteMap.put(101, "Italy");
		siteMap.put(123, "Belgium Dutch");
		siteMap.put(146, "Netherlands");
		siteMap.put(15, "Australia");
		siteMap.put(16, "Austria");
		siteMap.put(186, "Spain");
		siteMap.put(193, "Switzerland");
		siteMap.put(2, "Canada");
		siteMap.put(201, "HongKong");
		siteMap.put(203, "India");
		siteMap.put(205, "Ireland");
		siteMap.put(207, "Malaysia");
		siteMap.put(210, "Canada French");
		siteMap.put(211, "Philippines");
		siteMap.put(212, "Poland");
		siteMap.put(216, "Singapore");
		siteMap.put(23, "Belgium French");
		siteMap.put(3, "UK");
		siteMap.put(71, "France");
		siteMap.put(77, "Germany");
	}
	 
	public static String getValue(Integer key) {
		
		return siteMap.get(key);
	}
}
