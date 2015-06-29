package com.lt.dao.model;

import com.lt.platform.framework.core.model.MyBatisSuperModel;

public class Department extends MyBatisSuperModel{
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.name
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String name;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.parent_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer parentId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.company_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer companyId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer createTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.create_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer createUserId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer updateTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.update_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer updateUserId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_department.note
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String note;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.id
     *
     * @return the value of lt_department.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.id
     *
     * @param id the value for lt_department.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.name
     *
     * @return the value of lt_department.name
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getName() {
        return name;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.name
     *
     * @param name the value for lt_department.name
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setName(String name) {
        this.name = name;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.parent_id
     *
     * @return the value of lt_department.parent_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getParentId() {
        return parentId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.parent_id
     *
     * @param parentId the value for lt_department.parent_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setParentId(Integer parentId) {
        this.parentId = parentId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.company_id
     *
     * @return the value of lt_department.company_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCompanyId() {
        return companyId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.company_id
     *
     * @param companyId the value for lt_department.company_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCompanyId(Integer companyId) {
        this.companyId = companyId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.create_time_utc
     *
     * @return the value of lt_department.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCreateTimeUtc() {
        return createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.create_time_utc
     *
     * @param createTimeUtc the value for lt_department.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCreateTimeUtc(Integer createTimeUtc) {
        this.createTimeUtc = createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.create_user_id
     *
     * @return the value of lt_department.create_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCreateUserId() {
        return createUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.create_user_id
     *
     * @param createUserId the value for lt_department.create_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCreateUserId(Integer createUserId) {
        this.createUserId = createUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.update_time_utc
     *
     * @return the value of lt_department.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getUpdateTimeUtc() {
        return updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.update_time_utc
     *
     * @param updateTimeUtc the value for lt_department.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setUpdateTimeUtc(Integer updateTimeUtc) {
        this.updateTimeUtc = updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.update_user_id
     *
     * @return the value of lt_department.update_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getUpdateUserId() {
        return updateUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.update_user_id
     *
     * @param updateUserId the value for lt_department.update_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setUpdateUserId(Integer updateUserId) {
        this.updateUserId = updateUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_department.note
     *
     * @return the value of lt_department.note
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getNote() {
        return note;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_department.note
     *
     * @param note the value for lt_department.note
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setNote(String note) {
        this.note = note;
    }
    
    //新增字段
    private String userIds;
    private String removeIds;
    private String higherDepartmentName;//上級部門

	public String getHigherDepartmentName()
	{
		return higherDepartmentName;
	}

	public void setHigherDepartmentName(String higherDepartmentName)
	{
		this.higherDepartmentName = higherDepartmentName;
	}

	public String getUserIds()
	{
		return userIds;
	}

	public void setUserIds(String userIds)
	{
		this.userIds = userIds;
	}

	public String getRemoveIds()
	{
		return removeIds;
	}

	public void setRemoveIds(String removeIds)
	{
		this.removeIds = removeIds;
	}
}