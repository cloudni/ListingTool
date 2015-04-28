package com.lt.backend.category.util;

import java.util.List;

import com.lt.dao.po.EbayCategoryPO;
import com.lt.dao.po.GoogleAdwordsCategoryPO;

public class CategoryJsonUtil
{
	public static final String STR_START = "[";
	public static final String STR_FORMAT= "{\"id\":\"%s\",\"name\":\"%s\",\"isParent\":\"%s\", \"assignFlag\":\"%s\"},";
	public static final String STR_END = "]";
	
	public static String converEbayCategoryListToJson(List<EbayCategoryPO> list) {
		String str = STR_START;
		for(EbayCategoryPO obj: list) {
			str += String.format(STR_FORMAT, obj.getCategoryid(), obj.getCategoryNameCn()+"_" + obj.getCategoryid() + "_" + obj.getCategoryname(),obj.getParentFlag(), obj.getAssignFlag());
		}
		str = str.substring(0, str.length()-1);
		str += STR_END;
		
		return str;
	}
	
	public static String converGoogleCategoryListToJson(List<GoogleAdwordsCategoryPO> list) {
		String str = STR_START;
		
		for(GoogleAdwordsCategoryPO obj: list) {
			str += String.format(STR_FORMAT, obj.getCategoryid(), obj.getCategoryNameCn()+"_" + obj.getCategoryid() + "_" + obj.getCategoryname(),obj.getParentFlag(), obj.getAssignFlag());
			
		}
		str = str.substring(0, str.length()-1);
		str += STR_END;
		
		return str;
	}
}
