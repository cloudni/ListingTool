package com.lt.backend.system.util;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.Reader;
import java.util.zip.ZipFile;

public class StreamUtils
{
	public static String readFile(String fileName)
	{
		FileReader fr = null;
		BufferedReader br = null;
		String str = "";
		
		try
		{
			fr = new FileReader(fileName);
			br = new BufferedReader(fr);
			
			String s = null;
			while((s = br.readLine()) != null)
			{
				str += s + "\n";
			}
		} catch (FileNotFoundException e)
		{
			e.printStackTrace();
		} catch (IOException e)
		{
			e.printStackTrace();
		} finally {
			closeReader(fr);
			closeReader(br);
		}
		str = str.substring(0, str.lastIndexOf("\n"));
		return str;	
	}
	
	public static void closeZipFile(ZipFile zfile)
	{
		if( zfile != null)
		{
			try {
				zfile.close();
			} catch(Exception e){}
		}
	}
	
	public static void closeInputStream(InputStream is)
	{
		if(is != null)
		{
			try {
				is.close();
			} catch (Exception e){}
		}
	}
	
	public static void closeOutputStream(OutputStream os)
	{
		if(os != null)
		{
			try {
				os.close();
			} catch (Exception e){}
		}
	}
	
	public static void closeReader(Reader rd)
	{
		if(rd != null)
		{
			try {
				rd.close();
			} catch (Exception e){}
		}
	}
	
	public static void main(String[] args)
	{
		String str = readFile("D:\\test\\ReviseFixedPriceItemRequest_1.xml");
		System.out.println("1");
	}
}
