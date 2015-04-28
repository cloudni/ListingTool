package com.lt.frontend.help.service.impl;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.lt.dao.mapper.NotificationMapper;
import com.lt.dao.model.Notification;
import com.lt.frontend.help.service.INotificationService;

@Service
public class NotificationServiceImpl implements INotificationService {

	@Autowired
	private NotificationMapper notificationMapper;
	
	
	@Override
	public int deleteByPrimaryKey(Integer id)
	{
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int insert(Notification notification)
	{
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int insertSelective(Notification notification)
	{
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public Notification selectByPrimaryKey(Integer id)
	{
		// TODO Auto-generated method stub
		return notificationMapper.selectByPrimaryKey(id);
	}

	@Override
	public int updateByPrimaryKeySelective(Notification notification)
	{
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int updateByPrimaryKeyWithBLOBs(Notification notification)
	{
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int updateByPrimaryKey(Notification notification)
	{
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public List<Notification> selectAll(Notification notification)
	{
		// TODO Auto-generated method stub
		return notificationMapper.selectAll(notification);
	}
	
}
