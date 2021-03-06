package com.lt.dao.model;

public class Bulletin {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.title
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String title;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.is_new
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Byte isNew;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.is_top
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Byte isTop;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.is_viewable
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Byte isViewable;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer createTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.create_admin_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer createAdminId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer updateTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.update_admin_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer updateAdminId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.owner
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Byte owner;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_bulletin.content
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String content;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.id
     *
     * @return the value of lt_bulletin.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.id
     *
     * @param id the value for lt_bulletin.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.title
     *
     * @return the value of lt_bulletin.title
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getTitle() {
        return title;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.title
     *
     * @param title the value for lt_bulletin.title
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setTitle(String title) {
        this.title = title;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.is_new
     *
     * @return the value of lt_bulletin.is_new
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Byte getIsNew() {
        return isNew;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.is_new
     *
     * @param isNew the value for lt_bulletin.is_new
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setIsNew(Byte isNew) {
        this.isNew = isNew;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.is_top
     *
     * @return the value of lt_bulletin.is_top
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Byte getIsTop() {
        return isTop;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.is_top
     *
     * @param isTop the value for lt_bulletin.is_top
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setIsTop(Byte isTop) {
        this.isTop = isTop;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.is_viewable
     *
     * @return the value of lt_bulletin.is_viewable
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Byte getIsViewable() {
        return isViewable;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.is_viewable
     *
     * @param isViewable the value for lt_bulletin.is_viewable
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setIsViewable(Byte isViewable) {
        this.isViewable = isViewable;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.create_time_utc
     *
     * @return the value of lt_bulletin.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCreateTimeUtc() {
        return createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.create_time_utc
     *
     * @param createTimeUtc the value for lt_bulletin.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCreateTimeUtc(Integer createTimeUtc) {
        this.createTimeUtc = createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.create_admin_id
     *
     * @return the value of lt_bulletin.create_admin_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCreateAdminId() {
        return createAdminId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.create_admin_id
     *
     * @param createAdminId the value for lt_bulletin.create_admin_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCreateAdminId(Integer createAdminId) {
        this.createAdminId = createAdminId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.update_time_utc
     *
     * @return the value of lt_bulletin.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getUpdateTimeUtc() {
        return updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.update_time_utc
     *
     * @param updateTimeUtc the value for lt_bulletin.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setUpdateTimeUtc(Integer updateTimeUtc) {
        this.updateTimeUtc = updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.update_admin_id
     *
     * @return the value of lt_bulletin.update_admin_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getUpdateAdminId() {
        return updateAdminId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.update_admin_id
     *
     * @param updateAdminId the value for lt_bulletin.update_admin_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setUpdateAdminId(Integer updateAdminId) {
        this.updateAdminId = updateAdminId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.owner
     *
     * @return the value of lt_bulletin.owner
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Byte getOwner() {
        return owner;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.owner
     *
     * @param owner the value for lt_bulletin.owner
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setOwner(Byte owner) {
        this.owner = owner;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_bulletin.content
     *
     * @return the value of lt_bulletin.content
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getContent() {
        return content;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_bulletin.content
     *
     * @param content the value for lt_bulletin.content
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setContent(String content) {
        this.content = content;
    }
}