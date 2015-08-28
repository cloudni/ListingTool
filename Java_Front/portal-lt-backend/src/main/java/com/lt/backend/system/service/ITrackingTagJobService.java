package com.lt.backend.system.service;


public interface ITrackingTagJobService
{
	/**
	 * 执行待执行任务
	 */
	public void excuteJob();
	/**
	 * 终止异常任务
	 */
	public void abortJobs();
}
