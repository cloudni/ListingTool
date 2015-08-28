package com.lt.thirdpartylibrary.ebay.item;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.ebay.sdk.call.GetItemCall;
import com.ebay.sdk.call.GetMyeBaySellingCall;
import com.ebay.sdk.call.ReviseFixedPriceItemCall;
import com.ebay.sdk.call.ReviseItemCall;
import com.ebay.sdk.util.eBayUtil;
import com.ebay.soap.eBLBaseComponents.DescriptionReviseModeCodeType;
import com.ebay.soap.eBLBaseComponents.DetailLevelCodeType;
import com.ebay.soap.eBLBaseComponents.FeeType;
import com.ebay.soap.eBLBaseComponents.FeesType;
import com.ebay.soap.eBLBaseComponents.ItemListCustomizationType;
import com.ebay.soap.eBLBaseComponents.ItemType;
import com.ebay.soap.eBLBaseComponents.PaginationType;
import com.lt.thirdpartylibrary.ebay.base.EbayApiUtil;

public class ItemClient {
	private static Logger logger = LoggerFactory.getLogger(ItemClient.class);
	
	/**
	 * 修改单属性商品
	 * @param itemId
	 * @param desc
	 * @param descMode
	 * @param developer
	 * @param application
	 * @param certificate
	 * @param token
	 * @return
	 */
	public static boolean reviseItem(String itemId, String desc, int descMode, EbayApiUtil util) {
		try {
			logger.info("call revise item. itemId=" + itemId);
			ReviseItemCall api = new ReviseItemCall(util.getApiContext());
			ItemType item = new ItemType();
			item.setItemID(itemId);
			item.setDescription(desc);
			if(descMode == 1) {
				item.setDescriptionReviseMode(DescriptionReviseModeCodeType.APPEND);
			} else if(descMode == 2) {
				item.setDescriptionReviseMode(DescriptionReviseModeCodeType.REPLACE);
			}
			
			api.setItemToBeRevised(item);

		    FeesType fees = api.reviseItem();
		   
		    FeeType ft = eBayUtil.findFeeByName(fees.getFee(), "ListingFee");
		    logger.info("call revise item success. itemId=" + itemId);
		} catch (Exception ex) {
			 String msg = ex.getClass().getName() + " : " + ex.getMessage();
			 logger.error(msg);
			 return Boolean.FALSE;
		}
		return Boolean.TRUE;
	}
	
	/**
	 * 修改多属性商品
	 * @param itemId
	 * @param desc
	 * @param descMode
	 * @param util
	 * @return
	 */
	public static boolean reviseFixedPriceItem(String itemId, String desc, int descMode, EbayApiUtil util) {
		try {
			logger.info("call revise fixed price item. itemId=" + itemId);
			ReviseFixedPriceItemCall api = new ReviseFixedPriceItemCall(util.getApiContext());
			ItemType item = new ItemType();
			item.setItemID(itemId);
			item.setDescription(desc);
			if(descMode == 1) {
				item.setDescriptionReviseMode(DescriptionReviseModeCodeType.APPEND);
			} else if(descMode == 2) {
				item.setDescriptionReviseMode(DescriptionReviseModeCodeType.REPLACE);
			}
			
			api.setItemToBeRevised(item);

		    FeesType fees = api.reviseFixedPriceItem();
		    
		    FeeType ft = eBayUtil.findFeeByName(fees.getFee(), "ListingFee");
		    logger.info("call revise fixed price item success. itemId=" + itemId);
		} catch (Exception ex) {
			 String msg = ex.getClass().getName() + " : " + ex.getMessage();
			 logger.error("call revise fixed price item error\n" + msg);
			 return Boolean.FALSE;
		}
		return Boolean.TRUE;
	}
	
	/**
	 * 获取当前在售产品
	 * @param util
	 * @param pageNumber
	 * @param entriesPerPage
	 * @return
	 */
	public static GetMyeBaySellingCall getMyeBayActiveSelling(EbayApiUtil util, Integer pageNumber, Integer entriesPerPage) {
		GetMyeBaySellingCall api = null;
		try {
			api = new GetMyeBaySellingCall(util.getApiContext());

			ItemListCustomizationType itemListType = new ItemListCustomizationType();
			itemListType.setInclude(Boolean.TRUE);
			PaginationType page = new PaginationType();
			page.setPageNumber(pageNumber);
			page.setEntriesPerPage(entriesPerPage);
			itemListType.setPagination(page);

			api.setActiveList(itemListType);
			api.getMyeBaySelling();
		} catch (Exception ex) {
			String msg = ex.getClass().getName() + " : " + ex.getMessage();
			logger.error("call getMyeBayActiveSelling error\n" + msg);
			return null;
		}
		return api;
	}
	
	public static ItemType getItem(EbayApiUtil util, String itemId) {
		ItemType item = null;
		try {
			GetItemCall api = new GetItemCall(util.getApiContext());

			api.addDetailLevel(DetailLevelCodeType.ITEM_RETURN_DESCRIPTION);
			
			item = api.getItem(itemId);
			
		} catch (Exception ex) {
			String msg = ex.getClass().getName() + " : " + ex.getMessage();
			logger.error("call getItem error\n" + msg);
			return null;
		}
		return item;
	}
}
