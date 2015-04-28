package com.lt.frontend.home.util.bean;

//1. 定义枚举类型
public enum Language 
{
   // 利用构造函数传参
	LANGUAGE_CN ((short)1), LANGUAGE_EN ((short)2);

   // 定义私有变量
   private short code ;

   // 构造函数，枚举类型只能为私有
   private Language(short code) 
   {
       this.code = code;
   }

   @Override
   public String toString() 
   {
       return String.valueOf (this.code);
   }
   
   public short getCode() {
	   return code;
   }
}
