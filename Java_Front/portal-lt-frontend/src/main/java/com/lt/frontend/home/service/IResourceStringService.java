package com.lt.frontend.home.service;

import java.util.List;

import javax.servlet.http.HttpServletRequest;

import com.lt.dao.model.ResourceString;

public interface IResourceStringService {
	List<ResourceString> selectByLanguage(Short id);

	public void getResource(HttpServletRequest request);
	
	public void initResource();
}
