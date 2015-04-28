package com.lt.frontend.help.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import com.lt.dao.model.Notification;
import com.lt.frontend.help.service.INotificationService;

@Controller
@RequestMapping("notification")
public class NotificationController
{

	@Autowired
	private INotificationService notificationService;
	
	@RequestMapping("listNotification")
	public ModelAndView listNotification() throws Exception
	{
		ModelAndView model = new ModelAndView("notification/listNotification");
		List<Notification> notificationList=notificationService.selectAll(null);
		model.addObject("notificationList", notificationList);
		return model;
	}
	
	@RequestMapping("getNotification")
	public ModelAndView getUser(Notification notification) throws Exception
	{
		notification=notificationService.selectByPrimaryKey(notification.getId());
		ModelAndView model = new ModelAndView("notification/detailNotification");
		model.addObject("notification", notification);
		return model;
	}
}
