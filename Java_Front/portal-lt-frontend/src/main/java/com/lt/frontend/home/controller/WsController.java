package com.lt.frontend.home.controller;

import java.io.IOException;
import java.util.List;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;

import javax.websocket.ClientEndpoint;
import javax.websocket.EndpointConfig;
import javax.websocket.OnClose;
import javax.websocket.OnMessage;
import javax.websocket.OnOpen;
import javax.websocket.Session;
import javax.websocket.server.ServerEndpoint;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

//@ServerEndpoint("/websocket/echoAnnotation")
public class WsController
{
//	private static Map<String, Session> sessionMap = new ConcurrentHashMap<String, Session>();
//	
//	public static final String USER_ID = "userId";
//	
//	private static Logger logger = LoggerFactory
//			.getLogger(WsController.class);
//	
//	public static Session getSession(String userId) {
//		return sessionMap.get(userId);
//	}
//	
//	@OnOpen
//    public void open(Session session, EndpointConfig config) {  
//		Map<String, List<String>> map = session.getRequestParameterMap();
//		List<String> list = map.get(USER_ID);
//		if(list == null || list.size() == 0) {
//			logger.error("when connect ws the userid is must not null");
//		} else {
//			String str = list.get(0);
//			sessionMap.put(str, session);
//			logger.info("ws session put sessionMap success, userid:" + str);
//		}
//    }  
//
//    @OnMessage
//    public void echoTextMessage(Session session, String msg, boolean last) {
//        try {
//            if (session.isOpen()) {
//                session.getBasicRemote().sendText(msg, last);
//            }
//        } catch (IOException e) {
//            try {
//                session.close();
//            } catch (IOException e1) {
//                // Ignore
//            }
//        }
//    }
//    

}
