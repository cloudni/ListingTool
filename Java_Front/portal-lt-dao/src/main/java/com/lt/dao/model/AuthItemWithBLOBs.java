package com.lt.dao.model;

public class AuthItemWithBLOBs extends AuthItem {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_AuthItem.description
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String description;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_AuthItem.bizrule
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String bizrule;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_AuthItem.data
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String data;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_AuthItem.description
     *
     * @return the value of lt_AuthItem.description
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getDescription() {
        return description;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_AuthItem.description
     *
     * @param description the value for lt_AuthItem.description
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setDescription(String description) {
        this.description = description;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_AuthItem.bizrule
     *
     * @return the value of lt_AuthItem.bizrule
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getBizrule() {
        return bizrule;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_AuthItem.bizrule
     *
     * @param bizrule the value for lt_AuthItem.bizrule
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setBizrule(String bizrule) {
        this.bizrule = bizrule;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_AuthItem.data
     *
     * @return the value of lt_AuthItem.data
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getData() {
        return data;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_AuthItem.data
     *
     * @param data the value for lt_AuthItem.data
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setData(String data) {
        this.data = data;
    }
}