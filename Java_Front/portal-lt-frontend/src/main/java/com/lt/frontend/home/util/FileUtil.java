/**   
 * @Title: FileUtil.java 
 * @Package com.kerrykidz.system.util 
 * @Description: 
 * Copyright: Copyright (c) 2014 
 * Company:wuwh team by iss
 * @author: zhuss   
 * @date: 2014年9月15日 下午5:05:05 
 * @version: V1.0
 *
 */
package com.lt.frontend.home.util;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileInputStream;

import javax.servlet.http.HttpServletResponse;

public class FileUtil {
	
	/**
	 * 根据路径创建文件夹
	 * @param path
	 * @date: 2014年9月16日
	 */
	public static void createFile(String path){
		File fp = new File(path);  
        // 创建目录  
        if (!fp.exists()) {  
            fp.mkdirs();// 目录不存在的情况下，创建目录。  
        }  
	}
	
	/**
	 * 下载文件
	 * @param filePath
	 * @param response
	 * @return
	 * @throws Exception
	 * @date: 2014年9月16日
	 */
	public static boolean downLoadFile(String filePath,
			HttpServletResponse response)
			throws Exception {
		File file = new File(filePath); // 根据文件路径获得File文件
		String fileName = file.getName();
		String fileType = fileName.substring(fileName.lastIndexOf(".")+1);
		if ("pdf".equalsIgnoreCase(fileType)) {
			response.setContentType("application/pdf;charset=UTF-8");
		} else if ("xls".equalsIgnoreCase(fileType) || "xlsx".equalsIgnoreCase(fileType)) {
			response.setContentType("application/vnd.ms-excel");
		} else if ("doc".equalsIgnoreCase(fileType)) {
			response.setContentType("application/msword;charset=UTF-8");
		}
		// 文件名
		response.setHeader("Content-Disposition", "attachment;filename=\""
				+ new String(fileName.getBytes("UTF-8"), "ISO8859-1") + "\"");
		response.setContentLength((int) file.length());
		byte[] buffer = new byte[4096];// 缓冲区
		BufferedOutputStream output = null;
		BufferedInputStream input = null;
		try {
			output = new BufferedOutputStream(response.getOutputStream());
			input = new BufferedInputStream(new FileInputStream(file));
			int n = -1;
			while ((n = input.read(buffer, 0, 4096)) > -1) {
				output.write(buffer, 0, n);
			}
			output.flush(); 
			response.flushBuffer();
		} catch (Exception e) {
			e.printStackTrace();
			// 异常自己捕捉
			return false;
		} finally {
			// 关闭流，不可少
			if (input != null)
				input.close();
			if (output != null)
				output.close();
		}
		return true;
	}
}
