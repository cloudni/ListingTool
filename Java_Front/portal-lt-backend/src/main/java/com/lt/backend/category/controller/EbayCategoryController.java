//package com.lt.backend.category.controller;
//
//import java.util.List;
//
//import javax.servlet.http.HttpServletRequest;
//
//import org.springframework.beans.factory.annotation.Autowired;
//import org.springframework.stereotype.Controller;
//import org.springframework.web.bind.annotation.RequestMapping;
//import org.springframework.web.bind.annotation.ResponseBody;
//import org.springframework.web.servlet.ModelAndView;
//
//import com.lt.backend.category.service.IEbayCategoryService;
//import com.lt.backend.category.service.IGoogleAdwordsCategoryService;
//import com.lt.backend.category.util.CategoryJsonUtil;
//import com.lt.dao.model.EbayCategory;
//import com.lt.dao.po.EbayCategoryPO;
//import com.lt.dao.po.GoogleAdwordsCategoryPO;
//@Controller
//@RequestMapping("/category/ebay")
//public class EbayCategoryController
//{
//	@Autowired
//	private IGoogleAdwordsCategoryService googleAdwordsCategoryService;
//	@Autowired
//	private IEbayCategoryService ebayCategoryService;
//	
//	/**
//	 * 查询公司交易列表
//	 * @param msg 是否成功提示
//	 * @return
//	 */
//	@RequestMapping("home")
//	public ModelAndView home(HttpServletRequest request){
//		ModelAndView view = new ModelAndView("/system/category/home");
//		return view;
//	}
//	
//	/**
//	 * 根据父级异步查询ebay category集合
//	 * @param parentId
//	 * @param siteId
//	 * @param level
//	 * @return
//	 */
//	@RequestMapping("findEbayCategoryByAjax")
//	@ResponseBody
//	public String findEbayCategoryByAjax(String id, Integer siteId){
//		EbayCategoryPO ebayCategory = new EbayCategoryPO();
//		ebayCategory.setCategoryparentid(id);
//		ebayCategory.setCategorysiteid(siteId);
//		List<EbayCategoryPO> ebayCategoryList = ebayCategoryService.selectByParentId(ebayCategory);
//		
//		return CategoryJsonUtil.converEbayCategoryListToJson(ebayCategoryList);
//	}
//		
//	/**
//	 * 根据父级异步查询google adwords category集合
//	 * @param parentId
//	 * @param siteId
//	 * @param level
//	 * @return
//	 */
//	@RequestMapping("findGoogleAdwordsCategoryByAjax")
//	@ResponseBody
//	public String findGoogleAdwordsCategoryByAjax(Integer id, Integer siteId){
//		GoogleAdwordsCategoryPO googleAdwordsCategory = new GoogleAdwordsCategoryPO();
//		googleAdwordsCategory.setCategoryparentid(id == null? 0: id);
//		googleAdwordsCategory.setEbayCategorysiteid(siteId);
//		List<GoogleAdwordsCategoryPO> googleAdwordsCategoryList = googleAdwordsCategoryService.selectByParentId(googleAdwordsCategory);
//		return CategoryJsonUtil.converGoogleCategoryListToJson(googleAdwordsCategoryList);
//	}
//	
//	/**
//	 * 关联google adwords category
//	 * @param id
//	 * @param siteId
//	 * @return
//	 */
//	@RequestMapping("associatedGoogleCatetory")
//	@ResponseBody
//	public void associatedGoogleCatetory(String ebayId, Integer googleId, Integer siteId){
//		EbayCategory ebayCategory = new  EbayCategory();
//		ebayCategory.setCategoryid(ebayId);
//		ebayCategory.setGoogleAdwordsCategoryId(googleId);
//		ebayCategory.setCategorysiteid(siteId);
//		ebayCategoryService.updateByCategoryIdSelective(ebayCategory);
//	}
//}
