package com.lt.dao.model;

public class Product {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.sn
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String sn;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.name
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String name;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.folder_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer folderId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.is_real
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Byte isReal;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.is_delete
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Byte isDelete;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.company_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer companyId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer createTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.create_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer createUserId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer updateTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_product.update_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer updateUserId;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.id
     *
     * @return the value of lt_product.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.id
     *
     * @param id the value for lt_product.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.sn
     *
     * @return the value of lt_product.sn
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getSn() {
        return sn;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.sn
     *
     * @param sn the value for lt_product.sn
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setSn(String sn) {
        this.sn = sn;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.name
     *
     * @return the value of lt_product.name
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getName() {
        return name;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.name
     *
     * @param name the value for lt_product.name
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setName(String name) {
        this.name = name;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.folder_id
     *
     * @return the value of lt_product.folder_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getFolderId() {
        return folderId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.folder_id
     *
     * @param folderId the value for lt_product.folder_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setFolderId(Integer folderId) {
        this.folderId = folderId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.is_real
     *
     * @return the value of lt_product.is_real
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Byte getIsReal() {
        return isReal;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.is_real
     *
     * @param isReal the value for lt_product.is_real
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setIsReal(Byte isReal) {
        this.isReal = isReal;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.is_delete
     *
     * @return the value of lt_product.is_delete
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Byte getIsDelete() {
        return isDelete;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.is_delete
     *
     * @param isDelete the value for lt_product.is_delete
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setIsDelete(Byte isDelete) {
        this.isDelete = isDelete;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.company_id
     *
     * @return the value of lt_product.company_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCompanyId() {
        return companyId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.company_id
     *
     * @param companyId the value for lt_product.company_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCompanyId(Integer companyId) {
        this.companyId = companyId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.create_time_utc
     *
     * @return the value of lt_product.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCreateTimeUtc() {
        return createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.create_time_utc
     *
     * @param createTimeUtc the value for lt_product.create_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCreateTimeUtc(Integer createTimeUtc) {
        this.createTimeUtc = createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.create_user_id
     *
     * @return the value of lt_product.create_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getCreateUserId() {
        return createUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.create_user_id
     *
     * @param createUserId the value for lt_product.create_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setCreateUserId(Integer createUserId) {
        this.createUserId = createUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.update_time_utc
     *
     * @return the value of lt_product.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getUpdateTimeUtc() {
        return updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.update_time_utc
     *
     * @param updateTimeUtc the value for lt_product.update_time_utc
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setUpdateTimeUtc(Integer updateTimeUtc) {
        this.updateTimeUtc = updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_product.update_user_id
     *
     * @return the value of lt_product.update_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getUpdateUserId() {
        return updateUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_product.update_user_id
     *
     * @param updateUserId the value for lt_product.update_user_id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setUpdateUserId(Integer updateUserId) {
        this.updateUserId = updateUserId;
    }
}