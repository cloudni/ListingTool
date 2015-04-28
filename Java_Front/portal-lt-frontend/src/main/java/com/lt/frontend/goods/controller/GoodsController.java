package com.lt.frontend.goods.controller;

import javax.annotation.Resource;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import com.lt.frontend.goods.service.IGoodsService;
import com.lt.platform.util.Constants;

@Controller
@RequestMapping("goods")
public class GoodsController {
	
	@Resource
	private IGoodsService goodsService;
	
	@RequestMapping("/listGoods")
	public ModelAndView lsitGoods() throws Exception{
		ModelAndView model = new ModelAndView("goods/listGoods");
		return model;
	}
	
	@RequestMapping("/createGoods")
	public ModelAndView createGoods() throws Exception{
		ModelAndView model = new ModelAndView("goods/createGoods");
		return model;
	}
	
	@RequestMapping("/getGoods")
	public ModelAndView getGoods() throws Exception{
		ModelAndView model = new ModelAndView("goods/updateGoods");
		return model;
	}
	
	@RequestMapping("/detailGoods")
	public ModelAndView detailGoods() throws Exception{
		ModelAndView model = new ModelAndView("goods/detailGoods");
		return model;
	}
	
	@RequestMapping("/updateGoods")
	public ModelAndView updateGoods() throws Exception{
		ModelAndView model = new ModelAndView("goods/listGoods");
		return model;
	}
	
	@RequestMapping("/deleteGoods")
	@ResponseBody
	public String deleteGoods() throws Exception{
		return Constants.SUCCESS;
	}
}
