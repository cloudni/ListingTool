package com.lt.frontend.common.controller;

import java.util.Map;

import javax.servlet.http.HttpServletRequest;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;

@Controller
@RequestMapping("/adwords")
public class CommonController
{

	@RequestMapping("ad")
	public String ad() throws Exception
	{
		return "adwords/ad";
	}

    @RequestMapping("preview")
    public String preview() throws Exception
    {
        return "adwords/preview";
    }
    
    @RequestMapping("showUpload")
    public String showUpload(HttpServletRequest request) throws Exception
    {
        Map map = request.getParameterMap();
        return "adwords/ajax_upload";
    }
    
    @RequestMapping("upload")
    @ResponseBody
    public String upload(MultipartFile file) throws Exception
    {
        return file.getOriginalFilename();
    }
}
