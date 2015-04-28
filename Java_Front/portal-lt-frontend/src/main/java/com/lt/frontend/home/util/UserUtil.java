package com.lt.frontend.home.util;

import java.util.HashMap;
import java.util.Map;

import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import com.lt.platform.util.model.UserInfoModel;

/**
 * 用户工具类 主要包括缓存存储删除等操作
 * @author zhuss
 *
 */
public class UserUtil {

	/**
     * 设置用户到session
     *
     * @param session
     * @param user
     */
    public static void saveUserToSession(HttpSession session, UserInfoModel user) {
        session.setAttribute("loginUser", user);
    }

    /**
     * 
     *从Session删除信息
     * @param session
     * @return
     */
    public static void removeSessionByKey(HttpSession session,String key) {
    	session.removeAttribute(key);
    }
    
    /**
     * 从Session获取当前用户信息
     *
     * @param session
     * @return
     */
    public static UserInfoModel getUserFromSession(HttpSession session) {
    	Object attribute = session.getAttribute("loginUser");
        return attribute == null ? null : (UserInfoModel) attribute;
    }
    
    /**
     * 根据登录用户名获取UserId
     * @param session
     * @return
     */
    public static String getUserId(HttpSession session){
    	return getUserFromSession(session).getUsrPk();
    }
    
    /**
     * 设置cookie
     * @param response
     * @param name  cookie名字
     * @param value cookie值
     * @param maxAge cookie生命周期  以秒为单位
     */
    public static void addCookie(HttpServletResponse response,String name,String value,int maxAge){
        Cookie cookie = new Cookie(name,value);
        cookie.setPath("/");
        if(maxAge>0)  cookie.setMaxAge(maxAge);
        response.addCookie(cookie);
    }
    
    /**
     * 根据名字获取cookie
     * @param request
     * @param name cookie名字
     * @return
     */
    public static Cookie getCookieByName(HttpServletRequest request,String name){
        Map<String,Cookie> cookieMap = ReadCookieMap(request);
        if(cookieMap.containsKey(name)){
            Cookie cookie = (Cookie)cookieMap.get(name);
            return cookie;
        }else{
            return null;
        }   
    }
    
    /**
     * 将cookie封装到Map里面
     * @param request
     * @return
     */
    private static Map<String,Cookie> ReadCookieMap(HttpServletRequest request){  
        Map<String,Cookie> cookieMap = new HashMap<String,Cookie>();
        Cookie[] cookies = request.getCookies();
        if(null!=cookies){
            for(Cookie cookie : cookies){
                cookieMap.put(cookie.getName(), cookie);
            }
        }
        return cookieMap;
    }
    
    /** 
     * 清空cookie 
     */  
	public static void clearCookie(HttpServletRequest request,
			HttpServletResponse response) {
		Cookie[] cookies = request.getCookies();
		for (int i = 0; i < cookies.length; i++) {
			Cookie cookie = new Cookie(cookies[i].getName(), null);
			cookie.setMaxAge(0);
			 cookie.setPath("/");
			response.addCookie(cookie);
		}

	}
}
