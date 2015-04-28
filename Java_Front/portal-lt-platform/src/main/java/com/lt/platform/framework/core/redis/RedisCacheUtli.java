package com.lt.platform.framework.core.redis;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Set;

import org.springframework.context.ApplicationContext;
import org.springframework.context.support.ClassPathXmlApplicationContext;
import org.springframework.data.redis.core.RedisTemplate;

/**
 * redis远程远程操作
 * 		存储返回  true 成功  false失败
 * @author  wolf.yansl
 */
public class RedisCacheUtli {
	

	private static RedisTemplate redisTemplate;
	
/*	static{
		redisTemplate = (RedisTemplate)SpringUtil.getBean("redisCache");
	}*/
	
	/**
	 * 字符串数据存储
	 * @param key
	 * @param str
	 * @return
	 */
	public static void setString(String key , String str){
		redisTemplate.opsForValue().set(key, str);
	}
	public static String getString(String key){
		return (String) redisTemplate.opsForValue().get(key);
	}
	
	
	/**
	 * 对象数据存储
	 * @param key
	 * @param obj
	 * @return
	 */
	public static void setObject(String key , Object obj){
		redisTemplate.opsForValue().set(key, obj);
	}
	
	public static Object getObject(String key){
		return redisTemplate.opsForValue().get(key);
	}
	
	/**
	 * 全局删除
	 * @param key
	 */
	public static void delete(String key){
		redisTemplate.delete(key);
	}
	
	/**
	 * List数据存储
	 * @param key
	 * @param listValue
	 * @return
	 */
	public static void setList(String key , List listValue){
		redisTemplate.opsForList().leftPush(key, listValue);
	}
	public static List getList(String key){
		return (List) redisTemplate.opsForList().range(key, 0, -1);
	}
	public static void delList(String key){
		redisTemplate.delete(key);
	}
	
	/**
	 * Map数据存储
	 * @param key
	 * @param mapValue
	 * @return
	 */
	public static void setMap(String key , Map mapValue){
		redisTemplate.opsForHash().putAll(key, mapValue);
	}
	public static Map getMap(String key ){
		return redisTemplate.opsForHash().entries(key);
	}
	public static void delMap(String key ){
		redisTemplate.delete(key);
	}
	
	/**
	 * Set数据存储
	 * @param key
	 * @param setValue
	 * @return
	 */
	public static void setSet(String key , Set setValue){
		redisTemplate.opsForSet().add(key, setValue);
	}
	public static Set getSet(String key ){
		return (Set) redisTemplate.opsForSet().members(key);
	}
	public static void delSet(String key ){
		 redisTemplate.delete(key);
	}
	public static RedisTemplate getRedisTemplate() {
		return redisTemplate;
	}
	public static void setRedisTemplate(RedisTemplate redisTemplate) {
		RedisCacheUtli.redisTemplate = redisTemplate;
	}
	public static void main(String[] args) {
		ApplicationContext factory=new ClassPathXmlApplicationContext("config/springRedis.xml");
		/*System.out.println(factory.getType("redisCache"));*/
		RedisCacheUtli cache = (RedisCacheUtli) factory.getBean("redisCache");
		
		/*测试String*/
		/*cache.setString("demoString1", "demoStringValue1");
		  cache.setString("demoString2", "demoStringValue2");
		System.out.println(cache.getString("demoString1"));*/
		
		/*测试Object
		cache.setObject("demoObject1", new String("demoObject1"));
		cache.setObject("demoObject2", new HashMap<String,String>().put("hashKey", "hashvalue"));
		cache.setObject("demoObject3", new User("uDemo", 100));
		System.out.println(cache.getObject("demoObject1"));
		System.out.println(cache.getObject("demoObject2"));
		System.out.println(cache.getObject("demoObject3"));*/
		
		/*测试List 不能持久保存*/
		/*List list1 = new ArrayList();
		list1.add(1);
		list1.add("String");
		list1.add(new HashMap().put("key", "value"));
		list1.add(new User("ulist",500));
		cache.setList("demoList1", list1);
		System.out.println(cache.getList("demoList1"));*/
		
		/*测试Map*/
		Map map = new HashMap();
		map.put("key1", "ni");
		map.put("key2", new User("map",1000));
		cache.setMap("demoMap1", map);
		System.out.println(cache.getMap("demoMap1"));
		
		
		/*测试Set 不能持久保存*/
		/*Set list1 = new HashSet();
		list1.add(1);
		list1.add("String");
		list1.add(new HashMap().put("key", "value"));
		list1.add(new User("uSET",500));
		cache.setSet("demoSet1", list1);*/
		/*System.out.println(cache.getSet("demoSet1"));*/
	
	}
}
