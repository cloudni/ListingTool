package com.lt.thirdpartylibrary.ebay.lms;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.dom4j.Document;
import org.dom4j.DocumentHelper;
import org.dom4j.Element;
import org.dom4j.io.OutputFormat;
import org.dom4j.io.XMLWriter;
/**
 * 用户生成符合LMS格式的xml文件
 * @author jameschen
 *
 */
public class LMSUtil {
	
	public static final String VERSION="967";
	public static final String LANGUAGE_EN_US = "en_US";
	public static final String WARNING_LEVEL_HIGH = "High";
	private static final Integer MAX_NUMBER = 500;
	
	private static final String FILE_TOP = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	private static final String FILE_ROOT_PRE = "<BulkDataExchangeRequests xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
	private static final String FILE_HEADER = "<Header><Version>967</Version><SiteID>0</SiteID></Header>";
	private static final String FILE_ROOT_SUF = "</BulkDataExchangeRequests>";
	private static final String WRAP= "\r\n";
	private static final String FILE_CONTENT = "<%s xmlns=\"urn:ebay:apis:eBLBaseComponents\">\r\n  <Version>967</Version><ErrorLanguage>en_US</ErrorLanguage><WarningLevel>High</WarningLevel>\r\n  <Item>\r\n   <ItemID>%s</ItemID>\r\n   <Description><![CDATA[%s]]></Description>\r\n   <DescriptionReviseMode>%s</DescriptionReviseMode>\r\n  </Item>\r\n </%s>";
	
	public static final ThreadLocal<Long> threadDataCount = new ThreadLocal<Long>();//文件的总byte数量，文件上限15M，设置压缩前上限20M，压缩率为75%
	public static final ThreadLocal<Integer> threadFileIndex = new ThreadLocal<Integer>();//文件的索引下标
	private static final Long MAX_DATE_COUNT = 20971520L;
	/**
	 * 生成LMS的xml文件
	 * @param siteId
	 * @param requestDir
	 */
	private static void generateDocument(Document document, String requestDir, String requestName, Integer requestIndex) {
		
		XMLWriter xw = null;
		FileWriter fw = null;
		String tempName = requestName +"_temp";
		tempName = requestDir + File.separator + tempName + "_" + requestIndex + ".xml";
		String requestAllName = requestDir + File.separator + requestName + "_" + requestIndex + ".xml";
		try{
			fw = new FileWriter(tempName);
			 //格式化XML  
	        OutputFormat format = OutputFormat.createPrettyPrint(); //设置XML文档输出格式
	        //设置元素是否有子节点都输出  
	        format.setExpandEmptyElements(true);  
	       
	        // format.setSuppressDeclaration(true);
	        //format.setEncoding("UTF-8");//设置XML文档的编码类型
	        format.setIndent(true); //设置是否缩进
	        format.setIndent(" "); //以空格方式实现缩进
	        format.setNewlines(true); //设置是否换行
			xw = new XMLWriter(fw, format);
			xw.write(document);
			xw.flush();
			
	     } catch(IOException e)
	     {
         	e.printStackTrace();
         } finally
         {
        	 if(fw != null)
        	 {
        		 try
        		 {
        			 fw.close();
        		 } catch (Exception e){}
        	 }
        	 
        	 if(xw != null)
        	 {
        		 try 
        		 {
        			 xw.close();
        		 } catch(Exception e){}
        	 }
        	
         }
		
		try{
			BufferedReader in = new BufferedReader(new FileReader(tempName));
			BufferedWriter out = new BufferedWriter(new FileWriter(requestAllName));
			String s = null;
			while((s = in.readLine()) != null)
			{
				if(s.indexOf("<" + requestName) >= 0)
				{
					s = s.replace("<" + requestName, "<" + requestName + " xmlns=\"urn:ebay:apis:eBLBaseComponents\"");
				}
				out.write(s);
				out.newLine();
			}
			out.flush();
			in.close();
			out.close();
			}catch(IOException e){
			e.printStackTrace();
		}
		
		File temp = new File(tempName);
		temp.delete();
	}
	
	/**
	 * 生成头部信息<Header>
	 * @param rootElement
	 */
	private static void createheader(Element rootElement, Integer siteId) {
		Element headerElement = rootElement.addElement("Header");
		Element versionElement = headerElement.addElement("Version");
		versionElement.addText(VERSION);
		Element siteIdElement = headerElement.addElement("SiteID");
		if(siteId == null)
		{
			siteId = 0;
		}
		siteIdElement.addText(siteId + "");
	}
	
	/**
	 * 生成修改单variation商品的node节点，用于种pixel, 
	 * @param rootElement
	 */
	public static void createReviseItemXml(String path, Integer siteId, List<Map<String, String>> paraList)
	{
		createXml(path, siteId, paraList, "ReviseItemRequest");
	}
	
	public static void createReviseItemFile(String path, List<Map<String, String>> paraList)
	{
		createFile(path, paraList, "ReviseItemRequest");
	}
	
	public static void createReviseFixedPriceItemFile(String path, List<Map<String, String>> paraList)
	{
		createFile(path, paraList, "ReviseFixedPriceItemRequest");
	}
	
	public static void createFile(String path, List<Map<String, String>> paraList, String requestName)
	{
		String requestAllName = null;
		for(int i = 0; i < paraList.size(); i ++)
		{
			Map<String, String> paraMap = paraList.get(i);
			
			Long dateByte = threadDataCount.get();
			Integer fileIndex = threadFileIndex.get();
			requestAllName = path + File.separator + requestName + "_" + fileIndex + ".xml";
			if(dateByte == 0)
			{
				writeContents(requestAllName, new String[]{FILE_TOP, FILE_ROOT_PRE, FILE_HEADER});
			}
			
			String content = String.format(FILE_CONTENT, requestName, paraMap.get("ItemID"), paraMap.get("Description"), paraMap.get("DescriptionReviseMode"), requestName);
			writeContents(requestAllName, content);
			
			dateByte = threadDataCount.get();
			fileIndex = threadFileIndex.get();
			//如果超过28M，则不再写入
			if(dateByte >= MAX_DATE_COUNT || i == paraList.size() - 1)
			{
				writeContents(requestAllName, FILE_ROOT_SUF);
				threadDataCount.set(0L);
				threadFileIndex.set(fileIndex + 1);
			}
		}
	}
	
	public static void writeContents(String fileName, String... contents)
	{
		FileWriter fw = null;
		try {
			// 打开一个写文件器，构造函数中的第二个参数true表示以追加形式写文件
			fw = new FileWriter(fileName, true);
			for(String str: contents)
			{
				str = str + WRAP;
				fw.write(str);
				
				Long len = (long) str.getBytes().length;
				
				Long dateByte = threadDataCount.get();
				
				dateByte += len;
				threadDataCount.set(dateByte);
			}
			
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			try {
				fw.close();
			} catch (Exception e){}
		}
	}
	
	/**
	 * 生成修改商品的node节点，用于种pixel,  requestNamez值为"ReviseItemRequest"或者ReviseFixedPriceItemRequest
	 * @param rootElement
	 */
	public static void createXml(String path, Integer siteId, List<Map<String, String>> paraList, String requestName) {
		Document document = null;
		Element rootElement = null;
		for(int i = 0; i < paraList.size(); i ++)
		{
			//1000个放一个xml文件
			if(i % MAX_NUMBER == 0)
			{
				document = DocumentHelper.createDocument();
				rootElement = document.addElement("BulkDataExchangeRequests", "urn:ebay:apis:eBLBaseComponents");
				//生成<Header>标签
				createheader(rootElement, siteId);
			}
			Map<String, String> paraMap = paraList.get(i);
			//修改商品节点
			Element nodeElement = rootElement.addElement(requestName);
			//共通信息
			createNodeBase(nodeElement);
			//商品信息
			Element itemElement = nodeElement.addElement("Item");
			Element itemIDElement = itemElement.addElement("ItemID");
			itemIDElement.addText(paraMap.get("ItemID"));
			Element descriptionElement = itemElement.addElement("Description");
			descriptionElement.addCDATA(paraMap.get("Description"));
			Element descReviseModeElement = itemElement.addElement("DescriptionReviseMode");
			descReviseModeElement.addText(paraMap.get("DescriptionReviseMode"));
			
			if((i + 1) % MAX_NUMBER == 0 || i == paraList.size() - 1)
			{
				//文件名称后缀从1开始
				int fileIndex = (i + 1) % MAX_NUMBER == 0 ? (i + 1) / MAX_NUMBER : (i + 1) / MAX_NUMBER + 1;
				generateDocument(document,  path, requestName, fileIndex);
			}
		}
	}
	
	/**
	 * 生成修改多个商品的node节点，用于种pixel
	 * @param rootElement
	 */
	public static void createReviseFixedPriceItemXml(String path, Integer siteId, List<Map<String, String>> paraList) {
		createXml(path, siteId, paraList, "ReviseFixedPriceItemRequest");
	}
	
	/**
	 * 生成节点的共通信息
	 * @param nodeElement
	 */
	private static void createNodeBase(Element nodeElement)
	{
		Element versionElement = nodeElement.addElement("Version");
		versionElement.addText(VERSION);
		Element errorLanguageElement = nodeElement.addElement("ErrorLanguage");
		errorLanguageElement.addText(LANGUAGE_EN_US);
		Element warningLevelElement = nodeElement.addElement("WarningLevel");
		warningLevelElement.addText(WARNING_LEVEL_HIGH);
	}
	
	public static void main(String[] args) {
		List<Map<String, String>> paraList = new ArrayList<Map<String, String>>();
		Map<String, String> map = new HashMap<String, String>();
		map.put("ItemID", 12321 + "");
		map.put("Description", "weregre");
		map.put("DescriptionReviseMode", "wefewgrew");
		paraList.add(map);
		createReviseItemXml("d:/test", 1, paraList);
	}
}
