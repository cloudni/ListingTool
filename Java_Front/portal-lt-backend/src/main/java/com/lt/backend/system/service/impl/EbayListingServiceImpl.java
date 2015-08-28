package com.lt.backend.system.service.impl;

import java.io.File;
import java.io.UnsupportedEncodingException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import org.apache.commons.lang3.ArrayUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.core.task.TaskExecutor;
import org.springframework.stereotype.Service;

import com.lt.backend.system.service.IEbayListingService;
import com.lt.backend.system.util.StreamUtils;
import com.lt.dao.mapper.CompanyMapper;
import com.lt.dao.mapper.EbayListingMapper;
import com.lt.dao.mapper.EbayLmsLogMapper;
import com.lt.dao.mapper.StoreMapper;
import com.lt.dao.mapper.TrackingTagJobMapper;
import com.lt.dao.model.Company;
import com.lt.dao.model.Store;
import com.lt.dao.po.EbayListingPO;
import com.lt.dao.po.StorePO;
import com.lt.dao.po.TrackingTagPO;
import com.lt.platform.util.lang.StringUtil;
import com.lt.thirdpartylibrary.ebay.base.EbayApiUtil;
import com.lt.thirdpartylibrary.ebay.client.LMSClientJobs;
import com.lt.thirdpartylibrary.ebay.item.ItemClient;
import com.lt.thirdpartylibrary.ebay.lms.LMSUtil;
/**
 * 
 * @author jameschen
 *
 */
@Service
public class EbayListingServiceImpl implements IEbayListingService
{
	
	private Logger logger = LoggerFactory.getLogger(getClass());
	
	@Autowired
	private CompanyMapper companyMapper;
	
	@Autowired
	private EbayListingMapper ebayListingMapper;
	
	@Autowired
	private StoreMapper storeMapper;
	
	@Autowired
	private EbayLmsLogMapper ebayLmsLogMapper;
	
	@Autowired
	private TrackingTagJobMapper trackingTagJobMapper;
	
//    @Autowired  
//    @Qualifier("taskExecutor")  
//    private TaskExecutor taskExecutor;  
	
	public static final String VERSION = "967";//当前使用ebay客户端版本
	
	private static final Integer MAX_NUMBER = 4000;
	
	private static final ThreadLocal<String> filePathPreLocal = new ThreadLocal<String>();
	
	private static final ThreadLocal<TrackingTagPO> trackingTagLocal = new ThreadLocal<TrackingTagPO>();
	
	private static final ThreadLocal<String> lmsCurrentDirNameLocal = new ThreadLocal<String>();
	
	private static final ThreadLocal<Store> storeLocal = new ThreadLocal<Store>();
	
	@Override
	public void batchUpdatePixel(String filePathPre, TrackingTagPO trackingTag)  throws Exception
	{
		filePathPreLocal.set(filePathPre);
		trackingTagLocal.set(trackingTag);
		DateFormat dft = new SimpleDateFormat("yyyyMMddHHmmss");
		String lmsCurrentDirName = dft.format(new Date());
		lmsCurrentDirNameLocal.set(lmsCurrentDirName);
		
		List<Company> companyList = companyMapper.selectSelectiveById(trackingTag.getCompanyId());
		for(Company company: companyList)
		{
			//默认不处理company id = 1的公司
			Integer[] arr = new Integer[]{1};
			if(ArrayUtils.contains(arr, company.getId())) {
				continue;
			}
			Integer currentCompanyId = company.getId();
			trackingTag.setCurrentCompanyId(currentCompanyId);
			batchUpdatePixelByStore();
		}
	}
	
	private void batchUpdatePixelByStore() throws Exception {
		TrackingTagPO trackingTag = trackingTagLocal.get();
		List<Store> storeList = storeMapper.selectSelective(trackingTag.getCurrentCompanyId(), trackingTag.getStoreId());
		for(Store store: storeList) {
			
//			Integer[] arr = {4};
//			if(!ArrayUtils.contains(arr, store.getId()))
//			{
//				continue;
//			}
			storeLocal.set(store);
			trackingTag.setCurrentStoreId(store.getId());
			generateXmlByStore();//根据门店，生成xml文件
			
			startExcuteLMSByStore(store);
		}
	}
	
	//一个门店下的不区分siteid，查询出ebaylisting
	private void generateXmlByStore() {
		//查询单个variation的商品，并组装成xml文件
		createReviseItemXml();
		//查询多个variation的商品，并组装成xml文件
		createReviseFixedPriceItemXml();
	}
	
	//查询单个variation的商品，并组装成xml文件
	private void createReviseItemXml() {
		TrackingTagPO trackingTag = trackingTagLocal.get();
		trackingTag.setVariationFlag(TrackingTagPO.VARIATION_FLAG_ONE);
		
		Integer total = ebayListingMapper.countSelective(trackingTag);
		if(total == null) return;
		Integer count = total%MAX_NUMBER == 0 ? total/MAX_NUMBER : total/MAX_NUMBER + 1;//分页数
		
		LMSUtil.threadDataCount.set(0L);
		LMSUtil.threadFileIndex.set(1);
		for(int i = 0; i < count; i ++) {
			trackingTag.setStart(MAX_NUMBER * i);//起始坐标
			trackingTag.setEnd(MAX_NUMBER * (i + 1) - 1);//终点坐标
			List<EbayListingPO> ebayListings = ebayListingMapper.selectSelectiveByPage(trackingTag);
			if(ebayListings == null || ebayListings.isEmpty())
				return;
			
			String filePath = getXmlFilePath("ReviseFixedPriceItem");
			List<Map<String, String>> paraList = getParaMap(ebayListings);
			//LMSUtil.createReviseItemXml(filePath, 0,  paraList);//0为美国站，默认美国站
			LMSUtil.createReviseItemFile(filePath, paraList);
		}
	}
	
	//查询多个variation的商品，并组装成xml文件
	private void createReviseFixedPriceItemXml()
	{
		TrackingTagPO trackingTag = trackingTagLocal.get();
		trackingTag.setVariationFlag(TrackingTagPO.VARIATION_FLAG_MORE);
		Integer total = ebayListingMapper.countSelective(trackingTag);
		if(total == null) return;
		Integer count = total%MAX_NUMBER == 0 ? total/MAX_NUMBER : total/MAX_NUMBER + 1;//分页数
		
		LMSUtil.threadDataCount.set(0L);
		LMSUtil.threadFileIndex.set(1);
		for(int i = 0; i < count; i ++)
		{
			trackingTag.setStart(MAX_NUMBER * i);//起始坐标
			trackingTag.setEnd(MAX_NUMBER * (i + 1) - 1);//终点坐标
			List<EbayListingPO> ebayListings = ebayListingMapper.selectSelectiveByPage(trackingTag);
			if(ebayListings == null || ebayListings.isEmpty())
				return;
			
			String filePath = getXmlFilePath("ReviseFixedPriceItem");
			List<Map<String, String>> paraList = getParaMap(ebayListings);
			//LMSUtil.createReviseFixedPriceItemXml(filePath, 0, paraList);//0为美国站，默认美国站
			LMSUtil.createReviseFixedPriceItemFile(filePath, paraList);
		}
	}
	
	/**
	 * 一个门店下，用lms处理pixel的更新
	 * @param store 门店对象
	 * @param filePathPre 目录存放前缀
	 * @param currentTime 当前时间，用于区分批次的文件夹名称
	 */
	private void startExcuteLMSByStore(Store store) throws Exception
	{
		String filePathPre = filePathPreLocal.get(); 
		TrackingTagPO trackingTag = trackingTagLocal.get();
		String lmsCurrentDirName = lmsCurrentDirNameLocal.get();
		int index = filePathPre.lastIndexOf(File.separator);
		filePathPre = filePathPre.substring(0, index);
		String currentFileName = filePathPre + File.separator + "LMS" + 
				File.separator + lmsCurrentDirName + File.separator 
				+ store.getCompanyId() + File.separator + store.getId();
		File currentStoreFile = new File(currentFileName);
		if(!currentStoreFile.exists())
		{
			logger.debug("currentTime do not file in LMS for update pixel");
			return;
		}
		
		List<String> lmsFileNameList = new ArrayList<String>();
		//查询刚才生成的该批次改门店下所有的LMS文件
		getAllLMSRequestFile(lmsFileNameList, currentStoreFile);
		
		for(String uploadFileName: lmsFileNameList) 
		{
   		 	String downloadFileName = uploadFileName.replace("Request", "Response") + ".gz";
           
//   		 	TrackingTagJob trackingTagJob = new TrackingTagJob();
//   		 	trackingTagJob.setAction(trackingTag.getDescriptionReviseMode());
//   		 	trackingTagJob.setUploadFileName(uploadFileName);
//   		 	trackingTagJob.setDownloadFileName(downloadFileName);
//   		 	trackingTagJob.setStoreId(store.getId());
//   		 	trackingTagJobMapper.insertSelective(trackingTagJob);
   		 	
           	if(StringUtil.isBlank(uploadFileName) || StringUtil.isBlank(downloadFileName) || StringUtil.isBlank(store.getEbayToken()))
           	{
           		logger.error(" LMS upload file parament is not null,detail:{uploadFileName: " 
           				+ uploadFileName + ", downloadFileName: " + downloadFileName + ", userToken: " + store.getEbayToken() + "]");
           		return;
           	}
           	
           	logger.info("LMS Upload Job: uploadFileName=" + uploadFileName + " ; downloadFileName" + downloadFileName);
			if (LMSClientJobs.end2EndUploadJob(uploadFileName, downloadFileName,store.getEbayToken())) {
			     logger.info("\n******\nUploadJobEnd2End finished successfully.");
			 } else {
			     logger.info("UploadJobEnd2End failed.");
			 }
				
            
   	 	}
		
		//获取返回的response对应的gzip压缩包
//		List<String> lmsResponseFileNameList = new ArrayList<String>();
//		getAllLMSResponseFile(lmsResponseFileNameList, currentStoreFile);
//		
//		//解压包，且返回解压目标的目录集合
//		List<String> responseDirNameList = unzipFileAndGetDirName(lmsResponseFileNameList);
//		
//		readXmlResultToDb(responseDirNameList, store, currentTime);
	}
	
	/**
	 * 递归获取当前生成的所有请求的xml文件
	 * @param lmsFileNameList 存放获取的xml文件名称的集合
	 * @param parentFile 父节点
	 */
	private void getAllLMSRequestFile(List<String> lmsFileNameList, File parentFile)
	{
		File[] childrenFileArray = parentFile.listFiles();
		
		for(File children: childrenFileArray)
		{
			if(children.isDirectory())
			{
				getAllLMSRequestFile(lmsFileNameList, children);
			} else
			{
				lmsFileNameList.add(children.getAbsolutePath());
			}
		}
	}
	
	/**
	 * 根据接口类型拼接xml存放路径
	 */
	private String getXmlFilePath(String xmlType)
	{
		String filePathPre = filePathPreLocal.get(); 
		TrackingTagPO trackingTag = trackingTagLocal.get();
		String lmsCurrentDirName = lmsCurrentDirNameLocal.get();
		
		int index = filePathPre.lastIndexOf(File.separator);
		filePathPre = filePathPre.substring(0, index);
		String filePath = filePathPre + File.separator + "LMS" + 
				File.separator + lmsCurrentDirName + File.separator 
				+ trackingTag.getCurrentCompanyId() + File.separator + trackingTag.getCurrentStoreId();
		
		File file  = new File(filePath);
		if(!file.exists())
		{
			file.mkdirs();
		}
		return filePath;
	}
	
	private List<Map<String, String>> getParaMap(List<EbayListingPO> ebayListings)
	{
		String filePathPre = filePathPreLocal.get(); 
		TrackingTagPO trackingTag = trackingTagLocal.get();
		List<Map<String, String>> paraList = new ArrayList<Map<String, String>> ();
		
		for(EbayListingPO ebayListingPo: ebayListings) {
			//TODO 
			String[] ebayListArr = {"371322353226"};
			if(!ArrayUtils.contains(ebayListArr, ebayListingPo.getEbayListingId())) {
				continue;
			}
			
			if(StringUtil.isBlank(ebayListingPo.getListingDesc())) {
				continue;
			}
			
			try {
				ebayListingPo.setListingDesc(new String(ebayListingPo.getListingDesc().getBytes("ISO8859-1"),"UTF-8"));
				//String desc = new String(desc.getBytes("ISO8859-1"),"UTF-8");
			} catch (UnsupportedEncodingException e) {
				e.printStackTrace();
			}
			
			//过滤不需统计的值。如果条件是“匹配”，且matches结果是ture，继续往下走；
			//如果条件是“不匹配”，且matches结果是false，继续往下走；
			//否则，跳出本次循环，开始下一场循环
			if(trackingTag.getSelectFlag() != null && trackingTag.getSelectFlag()) {
				if(trackingTag.getSelectDescFlag() != null) {
					boolean matches = ebayListingPo.getListingDesc().indexOf(trackingTag.getSelectDescRule()) >= 0? true: false;
					if((trackingTag.getSelectDescFlag() && !matches) || (!trackingTag.getSelectDescFlag() && matches)) {
						continue;
					}
				}
			}
			
			Map<String, String> paraMap = new HashMap<String, String>();
			if(TrackingTagPO.DESCRIPT_REVISE_MODE_APPEND.equals(trackingTag.getDescriptionReviseMode()))
			{
				String trackingTagStr = getAppendDesc(ebayListingPo);
				if(StringUtil.isBlank(trackingTagStr)) {
					continue;
				}
				paraMap.put("Description", trackingTagStr);
	        	paraMap.put("DescriptionReviseMode", "Append");
			} else if (TrackingTagPO.DESCRIPT_REVISE_MODE_REPLACE.equals(trackingTag.getDescriptionReviseMode()))
			{
				String desc = getReplaceDesc(ebayListingPo);
				paraMap.put("Description", desc);
		        paraMap.put("DescriptionReviseMode", "Replace");
		       
			} else if(TrackingTagPO.DESCRIPT_REVISE_MODE_APPEND_AND_REPLACE.equals(trackingTag.getDescriptionReviseMode()))
			{
				String resultDesc = getReplaceDesc(ebayListingPo);
				
				String trackingTagStr = getAppendDesc(ebayListingPo);
				
				paraMap.put("Description", resultDesc + trackingTagStr);
		        paraMap.put("DescriptionReviseMode", "Replace");
				/*if(resultDesc.length() != desc.length()) {
					paraMap.put("Description", desc + trackingTagStr);
			        paraMap.put("DescriptionReviseMode", "Replace");
				} else if(StringUtil.isNotBlank(trackingTagStr)) {
					paraMap.put("Description", trackingTagStr);
			        paraMap.put("DescriptionReviseMode", "Append");
				}*/
			} else if(TrackingTagPO.DESCRIPT_REVISE_MODE_COMPARE.equals(trackingTag.getDescriptionReviseMode()))
			{
				//如果原先没有种过tracking code，则补种
				String regex = "transaction.itemtool.com/portal-lt-backend/js/itemtool.min.j";
				boolean matches = ebayListingPo.getListingDesc().indexOf(regex) >= 0? true : false;
				if(!matches) {
					String trackingTagStr = getTrackingTagStr(filePathPre, ebayListingPo);
					if(StringUtil.isBlank(trackingTagStr)) {
						continue;
					}
					paraMap.put("Description", trackingTagStr);
			        paraMap.put("DescriptionReviseMode", "Append");
				} 
				//如果种了trackingTag，则判断trackingTag是不是正确的
				else {
					//精确匹配，比较没有变量的值
					/*String format = StreamUtils.readFile(filePathPre + File.separator + "res" + File.separator + "tracking_tag_format.txt");
					
					String detailFormat = String.format(format, "1", ebayListingPo.getSiteId(), ebayListingPo.getPrimaryLevelTcate(), StringUtil.trimToEmpty(ebayListingPo.getSecondaryLevelTcate()) , ebayListingPo.getCompanyId(), ebayListingPo.getStoreId());
					if(StringUtil.isBlank(ebayListingPo.getSecondaryLevelTcate()))
					{
						detailFormat = detailFormat.replace("secondary_category_id.*:.*.*,\\s*", "");
					}
					Pattern pattern = Pattern.compile(detailFormat);
					Matcher matcher = pattern.matcher(desc);
					//如果精确匹配不成功，则直接将旧的tracking tag替换成新的
					if(!matcher.find())
					{
						String content = StreamUtils.readFile(filePathPre + File.separator + "res" + File.separator + "tracking_tag.txt");
						
						format = format.replace("%s", "[0-9]+");
						content = String.format(content, "1", ebayListingPo.getSiteId(), ebayListingPo.getPrimaryLevelTcate(), StringUtil.trimToEmpty(ebayListingPo.getSecondaryLevelTcate()) , ebayListingPo.getCompanyId(), ebayListingPo.getStoreId());
						if(StringUtil.isBlank(ebayListingPo.getSecondaryLevelTcate()))
						{
							content = content.replace("secondary_category_id.*:.*.*,\\s*", "");
						}
						desc = desc.replaceAll(format, "");
						desc += content;
						paraMap.put("Description", desc);
				        paraMap.put("DescriptionReviseMode", "Replace");
					}*/
				}
			}
			
			if(paraMap.isEmpty()) {
				continue;
			}
			paraMap.put("ItemID", ebayListingPo.getEbayListingId());
	        paraList.add(paraMap);
		}
		return paraList;
	}
	
	private String getAppendDesc(EbayListingPO ebayListingPo)
	{
		TrackingTagPO trackingTag = trackingTagLocal.get();
		String[] descArr = trackingTag.getReplaceTarget();
		String desc = "";
		
		//种trackingTag
		if(StringUtil.isNotBlank(descArr[0]))
		{
			String trackingTagStr = descArr[0];
			desc = getTrackingTagStr(ebayListingPo, trackingTagStr);
		}
		//种ga
		if(descArr.length  >= 2 && StringUtil.isNotBlank(descArr[1]))
		{
			if(StringUtil.isNotBlank(storeLocal.get().getGaTrackId()))
			{
				String gaStr = descArr[1];
				gaStr = String.format(gaStr, storeLocal.get().getGaTrackId());
				desc +=  gaStr;
			}
		}
		
		return desc;
	}
	
	//获取tracking code相关内容
	private String getTrackingTagStr(String filePathPre, EbayListingPO ebayListingPo) {
		String trackingTagStr = StreamUtils.readFile(filePathPre + File.separator + "res" + File.separator + "tracking_tag_1.txt");
		return getTrackingTagStr(ebayListingPo, trackingTagStr);
	}
	
	//获取tracking code相关内容
	private String getTrackingTagStr(EbayListingPO ebayListingPo, String trackingTagStr) {
		if(ebayListingPo.getSiteId() == null) {
			return "";
		}
		
		trackingTagStr = String.format(trackingTagStr, "1", ebayListingPo.getSiteId(), ebayListingPo.getPrimaryLevelTcate(), StringUtil.trimToEmpty(ebayListingPo.getSecondaryLevelTcate()) , ebayListingPo.getCompanyId(), ebayListingPo.getStoreId());
		return trackingTagStr;
	}
	
	//删除相关描述
	private String getReplaceDesc(EbayListingPO ebayListingPo)
	{
		TrackingTagPO trackingTag = trackingTagLocal.get();
		String desc = ebayListingPo.getListingDesc();
        String[] replaceRuleArray = trackingTag.getReplaceRuleArray();
        if(replaceRuleArray != null) {
	        for(String replaceRule: replaceRuleArray) {
	        	if(StringUtil.isNotBlank(replaceRule)) {
	        		desc = desc.replaceAll(replaceRule, "");
	        	}
	        }
        }
        
        return desc;
	}
	
	/**
	 * 解压gzip包
	 * @param lmsResponseFileNameList
	 * @return
	 */
//	private List<String> unzipFileAndGetDirName(List<String> lmsResponseFileNameList)
//	{
//		List<String> responseDirNameList = new ArrayList<String>();
//		for(String responseFileName: lmsResponseFileNameList)
//		{
//			String dirName = responseFileName.substring(0, responseFileName.lastIndexOf("."));
//			
//			ZipFile zfile = null;
//			FileOutputStream fos = null;
//			OutputStream os = null;
//			InputStream is = null;
//			try {
//				zfile=new ZipFile(responseFileName);
//				File outFile = new File(dirName);
//				
//				if(!outFile.exists())
//				{
//					outFile.mkdir();
//				}
//				
//				responseDirNameList.add(dirName);
//				
//		        Enumeration zList=zfile.entries();  
//		        ZipEntry ze=null;  
//		        byte[] buf=new byte[1024];  
//		        while(zList.hasMoreElements()){  
//		            ze=(ZipEntry)zList.nextElement();         
//		          
//		            fos = new FileOutputStream(dirName+ File.separator + ze.getName());
//		            os=new BufferedOutputStream(fos);
//		            is=new BufferedInputStream(zfile.getInputStream(ze));  
//		            int readLen=0;  
//		            while ((readLen=is.read(buf, 0, 1024))!=-1) {  
//		                os.write(buf, 0, readLen);  
//		            }  
//		            is.close();
//		            os.close();
//		        }
//			} catch (Exception e) {
//				logger.error(e.toString(), e);
//			} finally {
//				StreamUtils.closeInputStream(is);
//				StreamUtils.closeOutputStream(os);
//				StreamUtils.closeOutputStream(fos);
//				StreamUtils.closeZipFile(zfile);
//			}
//			
//		}
//		
//		return responseDirNameList;
//	}
	
	//查询执行结果，并插入数据库
//	private void readXmlResultToDb(List<String> responseDirNameList, Store store, String currentTime)
//	{
//		for(String responseDirName: responseDirNameList)
//		{
//			List<EbayLmsLogPO> siteLogList = new ArrayList<EbayLmsLogPO>();
//			String requestFileName = responseDirName.replace("Response", "Request");
//			
//			 SAXReader reader = null;
//			 FileInputStream fis = null;
//			 
//			 //读取request的xml文件
//			 try {
//	        	reader=new SAXReader();  
//	        	File requestFile = new File(requestFileName);
//	        	if(!requestFile.exists())
//	        	{
//	        		logger.error("get lms request file name fail, fileName :" + requestFileName);
//	        		return;
//	        	}
//	        	
//	        	fis = new FileInputStream(requestFile);
//	            Document doc=reader.read(fis);
//	            Element root=doc.getRootElement();
//	            
//				@SuppressWarnings("unchecked")
//				Iterator<Element> it=root.elementIterator();  
//	            Element interfaceEle;  
//	            String siteId = null;
//	            while(it.hasNext()){  
//	            	interfaceEle = (Element)it.next();  
//	                
//	                String interfaceName = interfaceEle.getName();
//	                if("Header".equals(interfaceName))
//	                {
//	                	siteId = interfaceEle.element("SiteID").getText();
//	                	continue;
//	                }
//	                
//	                Element itemEle = interfaceEle.element("Item");
// 	                String itemId = itemEle.element("ItemID").getText();
// 	                //String descriptionReviseMode = itemEle.element("DescriptionReviseMode").getText();
//	                
// 	                EbayLmsLogPO ebayLmsLog = new EbayLmsLogPO();
// 	                ebayLmsLog.setType((byte)1);
//        			ebayLmsLog.setCmdDate(currentTime);
//        			ebayLmsLog.setCompanyId(store.getCompanyId());
//        			ebayLmsLog.setStoreId(store.getId());
//        			ebayLmsLog.setSiteId(Integer.parseInt(siteId));
// 	                ebayLmsLog.setItemId(itemId);
// 	                ebayLmsLog.setInterfaceName(interfaceName);
// 	                siteLogList.add(ebayLmsLog);
//	            }  
//	          } catch (FileNotFoundException e) {  
//	            e.printStackTrace();  
//	        } catch (DocumentException e) {  
//	            e.printStackTrace();  
//	        }  finally {
//	        	StreamUtils.closeInputStream(fis);
//	        }
//			 
//			  //读取response的xml文件
//	          try {
//	        	  reader=new SAXReader();  
//	        	File responseDir = new File(responseDirName);
//	        	if(!responseDir.exists())
//	        	{
//	        		logger.error("get lms response file path fail, filepath :" + responseDirName);
//	        		return;
//	        	}
//	        	
//	        	File[] responseFile = responseDir.listFiles();
//
//	        	if(responseFile == null ||responseFile.length == 0)
//	        	{
//	        		continue;
//	        	}
//	        	
//	        	fis = new FileInputStream(responseFile[0]);
//	            Document doc=reader.read(fis);  
//	            Element root=doc.getRootElement();  
//	            
//				@SuppressWarnings("unchecked")
//				Iterator<Element> it=root.elementIterator();  
//	            Element interfaceEle;  
//	            int index = 0;
//	            while(it.hasNext()){  
//	            	interfaceEle = (Element)it.next();  
//	                
//	                String ack = interfaceEle.element("Ack").getText();
//	                
//	                EbayLmsLogPO ebayLmsLog = siteLogList.get(index);
//	                ebayLmsLog.setAck(ack);
//	                
//	                if(ack != null && !ack.toLowerCase().equals("success"))
//	                {
//	                	Element errorsEle = interfaceEle.element("Errors");
//	                	if(errorsEle != null)
//	                	{
//	                		Element shortMessageEle = errorsEle.element("ShortMessage");
//	                		String shortMessage = shortMessageEle.getText();
//	                		ebayLmsLog.setShortMessage(shortMessage);
//	                	}
//	                }
//	                index ++;
//	            }  
//	          } catch (FileNotFoundException e) {  
//	            e.printStackTrace();  
//	        } catch (DocumentException e) {  
//	            e.printStackTrace();  
//	        } finally {
//	        	StreamUtils.closeInputStream(fis);
//	        }
//	          
//	        //ebayLmsLogMapper.batchInsertSelective(siteLogList);
//	          for(EbayLmsLogPO po: siteLogList)
//	          {
//	        	  ebayLmsLogMapper.insertSelective(po);
//	          }
//		}
//	}
	
	/**
	 * 递归获取LMS返回的gzip压缩包
	 * @param filter
	 * @param lmsResponseFileNameList
	 * @param parentFile
	 */
	/*private void getAllLMSResponseFile(List<String> lmsResponseFileNameList, File parentFile)
	{
		
		File[] childrenResponseFileArray = parentFile.listFiles();
		
		for(File children: childrenResponseFileArray)
		{
			if(children.isDirectory())
			{
				getAllLMSResponseFile(lmsResponseFileNameList, children);
			} else
			{
				String childName = children.getName().toLowerCase();
				if(childName.indexOf("response") >= 0 && childName.indexOf("gz") >= 0)
				{
					lmsResponseFileNameList.add(children.getAbsolutePath());
				}
			}
		}
		
	}*/
	
	public static void main(String[] args)
	{
		List<Integer> list = new ArrayList<Integer>();list.add(1);list.add(2);list.add(3);list.add(4);list.add(5);
		System.out.println(list.subList(0, 4).size());
		/*String str = StreamUtils.readFile("D:/test/test.txt");
		System.out.println(str);
		
//		String str1 = StreamUtils.readFile("D:/test/tracking_tag_format.txt");
//		str1 = String.format(str1, "1", "0", "281", "", "2", "5");
//		
//		str1 = str1.replace("secondary_category_id.*:.*.*,\\s*", "");
		
		//String str1 = "<itemtool>[\\s|\\S]*</itemtool>";//
		//String str1 = "<script type=\"text/javascript\">\\s+var.*itemtool_tag_params.*=.*\\{[\\s\\S]*\\};\\s+</script>";
//		str1 += "\\s+<script type=\"text/javascript\">\\s+var.*google_conversion_id.*=.*[0-9].+;\\s+var.*google_custom_params.*=.*window.itemtool_tag_params;\\s+var.*google_remarketing_only.*=.*true;\\s+</script>";
//		str1 += "\\s+<script type=\"text/javascript\">\\s+document.write\\(\"<sc\".*\\+.*\"ript.*type=\".*\\+.*\"'tex\".*\\+.*\"t/jav\".*\\+.*\"ascript'\".*\\+.*\".*src='//www.googl\".*\\+.*\"eadser\".*\\+.*\"vices.com/pagead/conve\".*\\+.*\"rsion.j\".*\\+.*\"s'>\".*\\+.*\"<\".*\\+.*\"/sc\".*\\+.*\"ript>\"\\);";
//		str1 += "\\s+document.write\\(\"<nos\".*\\+.*\"cript><div.*style='display:inline;'><img.*height='1'.*width='1'.*style='border-style:none;'.*alt=''.*src='//googleads.g.doubleclick.net/pagead/viewthroughconversion/947969982/\\?value=0&amp;guid=ON&amp;script=0'\\\\/><\\\\/div><\\\\/nos\".*\\+.*\"cript>\"\\);\\s+</script>";
		//String str1 = "',\\s*second_category_id.*:.*'.*'";
		String str1 = "transaction.itemtool.com/portal-lt-backend/js/itemtool.min.j";
		System.out.println(str1);
		
		Pattern pattern = Pattern.compile(str1);
	     Matcher matcher = pattern.matcher(str);
	     if(matcher.find()) {
	    	 System.out.println(str.length());
	    	 System.out.println(true);
	     } else {
	    	 System.out.println(false);
	     }*/
//	     while(matcher.find()) {
//	    	 int i = 0;
//	    	 String para = matcher.group(++i);
//	    	 System.out.println("para " + i +": " + para);
//	    	 para = matcher.group(++i);
//	    	 System.out.println("para " + i +": " + para);
//	    	 para = matcher.group(++i);
//	    	 System.out.println("para " + i +": " + para);
//	    	 para = matcher.group(++i);
//	    	 System.out.println("para " + i +": " + para);
//	    	 para = matcher.group(++i);
//	    	 System.out.println("para " + i +": " + para);
//	    	 para = matcher.group(++i);
//	    	 System.out.println("para " + i +": " + para);
//	     } 
	}

    @Override
    public List<EbayListingPO> selectSiteByCompanyAndStore(
            EbayListingPO ebayListingPO)
    {
        return ebayListingMapper.selectSiteByCompanyAndStore(ebayListingPO);
    }

	@Override
	public String batchUpdateDescByStore(Integer storeId, String filePathPre) throws Exception
	{
		logger.info("EbayListingServiceImpl.batchUpdateDescByStore(storeId:" + storeId + ") call");
		
		StorePO store = storeMapper.getStoreAndApiKey(storeId);
		
		if(store == null) {
			String msg = "error:store (id " + storeId + ") is not exist";
			logger.error(msg);
			return msg;
		} else if(store.getIsActive() != null && store.getIsActive() != 1) {
			String msg = "error:store (id " + storeId + ") is not active";
			logger.error(msg);
			return msg;
		}
		
		TrackingTagPO trackingTag = new TrackingTagPO();
		trackingTag.setCurrentStoreId(storeId);
		trackingTag.setVariationFlag(TrackingTagPO.VARIATION_FLAG_ONE);
		Integer total = ebayListingMapper.countSelective(trackingTag);
		if(total != null) {
			int number = 500;
			Integer count = total%number == 0 ? total/number : total/number + 1;//分页数
			
			for(int i = 0; i < count; i ++) {
				TrackingTagPO tag = new TrackingTagPO();
				tag.setCurrentStoreId(storeId);
				tag.setVariationFlag(TrackingTagPO.VARIATION_FLAG_ONE);
				tag.setStart(number * i);//起始坐标
				tag.setEnd(number * (i + 1) - 1);//终点坐标
				
				List<EbayListingPO> ebayListings = ebayListingMapper.selectSelectiveByPage(tag);
				reviseItemByNewThread(filePathPre, store, TrackingTagPO.VARIATION_FLAG_ONE, ebayListings);
			}
		}
		
		TrackingTagPO trackingTagMore = new TrackingTagPO();
		trackingTagMore.setCurrentStoreId(storeId);
		trackingTagMore.setVariationFlag(TrackingTagPO.VARIATION_FLAG_MORE);
		Integer totalMore = ebayListingMapper.countSelective(trackingTagMore);
		if(totalMore != null) {
			int number = 500;
			Integer count = totalMore%number == 0 ? totalMore/number : totalMore/number + 1;//分页数
			
			for(int i = 0; i < count; i ++) {
				TrackingTagPO tag = new TrackingTagPO();
				tag.setCurrentStoreId(storeId);
				tag.setVariationFlag(TrackingTagPO.VARIATION_FLAG_MORE);
				tag.setStart(number * i);//起始坐标
				tag.setEnd(number * (i + 1) - 1);//终点坐标
				
				List<EbayListingPO> ebayListings = ebayListingMapper.selectSelectiveByPage(tag);
				
				reviseItemByNewThread(filePathPre, store, TrackingTagPO.VARIATION_FLAG_MORE, ebayListings);
			}
		}
		return "ok";
	}
	
	private void reviseItemByNewThread(String filePathPre, StorePO store, Integer reviseType, List<EbayListingPO> ebayListings) {
		int index = 50;
		int size = ebayListings.size();
		for(int i = 0; i < size; i = i + index) {
			int toIndex = i + index;
			if(toIndex > size - 1) {
				toIndex = size - 1;
			}
			List<EbayListingPO> childList = ebayListings.subList(i, toIndex);
			//taskExecutor.execute(new ReviseItemThread(filePathPre, store, reviseType, childList));
		}
	}
	
	private class ReviseItemThread implements Runnable
	{
		String filePathPre;
		StorePO store;
		int type;
		List<EbayListingPO> ebayListings;

		public ReviseItemThread(String filePathPre, StorePO store, int type,  List<EbayListingPO> ebayListings)
		{
			this.filePathPre = filePathPre;
			this.store = store;
			this.type = type;
			this.ebayListings = ebayListings;
		}

		@Override
		public void run()
		{
			try
			{
				if(ebayListings == null || ebayListings.isEmpty())
					return;
				
				logger.info("storeId:" + store.getId() + ",ebay listing start id=:" + ebayListings.get(0).getEbayListingId() + " is running start.");
				
				for(EbayListingPO ebayListingPo: ebayListings) {
					//TODO 
//					String[] ebayListArr = {"131537258350"};
//					if(ArrayUtils.contains(ebayListArr, ebayListingPo.getEbayListingId())) {
//						continue;
//					}
					
					/*try {
						ebayListingPo.setListingDesc(new String(ebayListingPo.getListingDesc().getBytes("ISO8859-1"),"UTF-8"));
						//String desc = new String(desc.getBytes("ISO8859-1"),"UTF-8");
					} catch (UnsupportedEncodingException e) {
						e.printStackTrace();
					}*/
					
					String desc = ebayListingPo.getListingDesc();
					if(StringUtil.isBlank(desc)) {
						continue;
					}
					
					//如果原先没有种过tracking code，则补种
					String regex = "transaction.itemtool.com/portal-lt-backend/js/itemtool.min.j";
					boolean matches = desc.indexOf(regex) >= 0? true : false;
					if(!matches) {
						String trackingTagStr = getTrackingTagStr(filePathPre, ebayListingPo);
						if(StringUtil.isBlank(trackingTagStr)) {
							continue;
						}
						
						logger.info("storeId:" + store.getId() + ",ebay listing start id=:" + ebayListings.get(0).getEbayListingId() + ",itemId:" + ebayListingPo.getEbayListingId());
						EbayApiUtil util = new EbayApiUtil(store.getDevId(), store.getAppId(), store.getCertId(), store.getEbayToken());
						if(1 == type) {
							ItemClient.reviseItem(ebayListingPo.getEbayListingId(), trackingTagStr, 1, util);
						} else if(2 == type) {
							ItemClient.reviseFixedPriceItem(ebayListingPo.getEbayListingId(), trackingTagStr, 1, util);
						}
					} 
				}
			} catch (Exception e)
			{
				e.printStackTrace();
			}
			logger.info("storeId:" + store.getId() + ",ebay listing start id=:" + ebayListings.get(0).getEbayListingId() + " is running end.");
		}
	}

}
