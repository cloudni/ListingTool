package com.lt.frontend.home.util;

/**
 * 常量工具类
 * @author zhuss
 *
 */
public class ConstantUtil {
	
	public static String AUDIT_TYPE_LOGIN = "1"; //日志审核记录类型-用户登录
	public static String AUDIT_TYPE_LOGOUT = "2"; //日志审核记录类型-用户注销
	public static String AUDIT_TYPE_ADDUSER = "3"; //日志审核记录类型-新增用户
	public static String AUDIT_TYPE_DELUSER = "4"; //日志审核记录类型-删除用户
	public static String AUDIT_TYPE_UPDATEPWD = "5"; //日志审核记录类型-修改用户密码
	public static String AUDIT_TYPE_UPDATEAUTH= "6"; //日志审核记录类型-修改用户权限角色
	public static String AUDIT_TYPE_ExportREPORT = "7"; //日志审核记录类型-报表导出
	public static String AUDIT_TYPE_LOGINFO = "登录"; //日志信息
	
	public static String WORKFLOW_STATUS_HANDLE = "处理";
	public static String WORKFLOW_STATUS_CREATE = "新建";
	public static String WORKFLOW_STATUS_APPLY = "申请";
	public static String WORKFLOW_STATUS_REAPPLY = "重新申请";
	public static String WORKFLOW_STATUS_BACK = "退单";
	public static String WORKFLOW_STATUS_CG = "草稿";
	public static String WORKFLOW_STATUS_SP = "审批";
	public static String WORKFLOW_STATUS_DSP = "待审批";
	public static String WORKFLOW_STATUS_SPZ = "审批中";
	public static String WORKFLOW_STATUS_COMPLETE = "完成";
	public static String WORKFLOW_STATUS_CLOSE = "关闭";
	public static String WORKFLOW_STATUS_NO = "不同意";
	public static String WORKFLOW_STATUS_YES = "同意";
	
	public static String WORKFLOW_STATUS_START1 = "用户申请";
	public static String WORKFLOW_STATUS_START2 = "经理申请";
	public static String WORKFLOW_STATUS_START3 = "经理审批";
	
	public static String SEARCH_LEAVE_DATE_FORMAT = "dd/MM/yyyy";
	
	public static String SYNC_DATA = "同步上传数据出错,请稍微再试!";
	
	public static String getWorkflowKey(WorkflowKey key){
		return key.toString();
	}
	
	public static enum WorkflowKey {
		leave// 请假流程
		, price// 定价流程
		, stock// 调整库存流程
		, discount// 限时促销流程
		, order// 采购流程
		, pay// 付款流程
		,server //客户服务
		,activity //活动
	}
}
