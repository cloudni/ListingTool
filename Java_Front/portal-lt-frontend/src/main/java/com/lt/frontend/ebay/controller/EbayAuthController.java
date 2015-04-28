package com.lt.frontend.ebay.controller;

import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import com.ebay.sdk.ApiContext;
import com.ebay.sdk.ApiException;
import com.ebay.sdk.SdkException;
import com.ebay.sdk.call.FetchTokenCall;
import com.lt.frontend.ebay.bean.EbayToken;
import com.lt.frontend.ebay.service.IEbayStoreService;
import com.ssoclient.utils.SessionUtil;

@Controller
@RequestMapping("/ebay/auth")
public class EbayAuthController
{
	
	@Resource
	private IEbayStoreService storeService;
	
	@RequestMapping("home")
	public ModelAndView home(){
		return new ModelAndView("ebay/auth");
	}
	
	
	@RequestMapping("remote")
	public ModelAndView ebayAuth(HttpServletRequest request,HttpServletResponse response,@RequestParam("storeId")String storeId) throws Exception{
		
		String companyId = SessionUtil.getCompanyId(request) + "";
		Map<String,Object> storeParameters = storeService.findEbayStoreAuthParameters(companyId, storeId);
		if(storeParameters == null  || storeParameters.size() == 0){
			return new ModelAndView("ebay/auth_error");
		}
		/*请求参数获取   数据库中获得*/
		String devId=storeParameters.get("dev_id").toString()/*"8ef71790-043a-49ea-9694-36b9543c27b2"*/;
		String appId=storeParameters.get("app_id").toString();
		String certId=storeParameters.get("cert_id").toString();
		String runame=storeParameters.get("runame").toString();
		
		/*String signInURL =(String) CusotmizedPropertyUtil.getContextProperty("ebaySignInUrl");
	 	String ApiServerUrl = (String) CusotmizedPropertyUtil.getContextProperty("ebayAPIUrl");
		
	 	ApiContext apiContext = EBayUtil.createApiContext(devId, appId, certId, ApiServerUrl );
		ApiLogging apiLogging = new ApiLogging();
		apiContext.setApiLogging(apiLogging);
		request.getSession().setAttribute("apicontext", apiContext );
		
		GetSessionIDCall api = new GetSessionIDCall(apiContext);
		api.setRuName(runame);
		String ruParams="params="+runame +"-Production";
		String sessionID = api.getSessionID();
		String encodedSesssionIDString =URLEncoder.encode(sessionID,"UTF-8");			 
		
		request.getSession().setAttribute("sessionID", sessionID);			 
		return new ModelAndView("redirect:"+response.encodeRedirectURL(signInURL + "&RuName=" + runame + "&SessID=" + encodedSesssionIDString + "&ruparams=" + ruParams));   */  
		
		return null;
	}
	
	/**
	 * 获取  ebay token内容 
	 * @param request
	 * @return
	 * @throws Exception 
	 * @throws SdkException 
	 * @throws ApiException 
	 */
	@RequestMapping("token")
	@ResponseBody
	public EbayToken ebayToken(HttpServletRequest request) throws Exception{
		EbayToken resultToken = new EbayToken();
		HttpSession session = request.getSession();
		
		ApiContext apiContext =(ApiContext) session.getAttribute( "apicontext" )  ;
		String sessionID = (String) session.getAttribute("sessionID");
		
		FetchTokenCall api = new FetchTokenCall(apiContext);
		api.setSessionID(sessionID);
		
		String eBayToken = api.fetchToken();
		String tokenExp = api.getHardExpirationTime().getTime().toString();
		
		resultToken.setSessionID(sessionID);
		resultToken.setToken(eBayToken);
		resultToken.setTokenExp(tokenExp);
		
		return resultToken;
	}
	

}
