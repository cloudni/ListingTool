package com.lt.platform.util.http;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.Set;

import org.apache.commons.httpclient.HttpClient;
import org.apache.commons.httpclient.HttpException;
import org.apache.commons.httpclient.HttpMethod;
import org.apache.commons.httpclient.NameValuePair;
import org.apache.commons.httpclient.methods.GetMethod;
import org.apache.commons.httpclient.methods.PostMethod;
import org.apache.commons.lang.StringUtils;


/**
 * 请求第三方接口
 * @author wolf-yansl
 *
 */
public class HttpClientUtil {
	
	public static final String HTTP_GET="GET";
	public static final String HTTP_POST="POST";
	
	/**
	 * get请求
	 * @param uri 参数绑定uri后面
	 * @return
	 */
	public static HttpClientResultUtil get(String uri){
		HttpClientResultUtil result = new HttpClientResultUtil();
		
		HttpClient client = new HttpClient();   
	    HttpMethod method=getHttpMethod(uri, HTTP_GET);
	    try {
			int status = client.executeMethod(method);
		    String context = method.getResponseBodyAsString();
		    
		    result.setContext(context);
		    result.setStatus(status);
		} catch (HttpException e) {
			e.printStackTrace();
			result.setExceptionMessage(e.getMessage());
		} catch (IOException e) {
			e.printStackTrace();
			result.setExceptionMessage(e.getMessage());
		}  
	    method.releaseConnection();
	    
	    return result;
	}
	
	/**
	 * post 无参数请求
	 * @param uri
	 * @return
	 */
	public static HttpClientResultUtil post(String uri){
		return post(uri, null);
	}
	
	/**
	 * post 带参数请求
	 * @param uri
	 * @param params
	 * @return
	 */
	public static HttpClientResultUtil post(String uri,Map<String,String> params){
		HttpClientResultUtil result = new HttpClientResultUtil();
		
		HttpClient client = new HttpClient();  
		PostMethod post = (PostMethod) getHttpMethod(uri, HTTP_POST);
		try {
			/**参数设定*/
			List<NameValuePair> nameValues = getHttpRequestParams(params);
			if(nameValues != null && nameValues.size() > 0){
				post.setRequestBody(nameValues.toArray(new NameValuePair[nameValues.size()]));
			}
			
			int status = client.executeMethod(post);
			String context = post.getResponseBodyAsString();
			
			result.setStatus(status);
			result.setContext(context);
			
		} catch (HttpException e) {
			e.printStackTrace();
			result.setExceptionMessage(e.getMessage());
		} catch (IOException e) {
			e.printStackTrace();
			result.setExceptionMessage(e.getMessage());
		}  
		 post.releaseConnection();  
		return result;
	}
	
	/**
	 *  请求方式
	 * @param uri
	 * @param methodType
	 * @return
	 */
	private static HttpMethod getHttpMethod(String uri,String methodType){
		HttpMethod method = null;
		if(StringUtils.isBlank(methodType)){
			method = new GetMethod();
		}else if(methodType.equals(HTTP_GET)){
			method = new GetMethod(uri);
		}else if(methodType.equals(HTTP_POST)){
			method = new PostMethod(uri);
		}
		return method;
	}
	
	/**
	 * 设置请求参数
	 * @param paramsMap
	 */
	private static List<NameValuePair> getHttpRequestParams(Map<String,String> paramsMap){
		List<NameValuePair> nameValues = null;
		
		if(paramsMap != null && paramsMap.size() > 0){
			nameValues = new ArrayList<NameValuePair>();
			
			Set<String> keys = paramsMap.keySet();
			for(String key : keys){
				NameValuePair nameValue = new NameValuePair( key, paramsMap.get(key) );
				nameValues.add(nameValue);
			}
		}
		
		return nameValues;
		
	}
}
