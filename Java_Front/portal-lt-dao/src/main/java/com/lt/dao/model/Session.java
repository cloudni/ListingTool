package com.lt.dao.model;

public class Session {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_session.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private String id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_session.expire
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private Integer expire;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_session.data
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    private byte[] data;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_session.id
     *
     * @return the value of lt_session.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public String getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_session.id
     *
     * @param id the value for lt_session.id
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setId(String id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_session.expire
     *
     * @return the value of lt_session.expire
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public Integer getExpire() {
        return expire;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_session.expire
     *
     * @param expire the value for lt_session.expire
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setExpire(Integer expire) {
        this.expire = expire;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_session.data
     *
     * @return the value of lt_session.data
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public byte[] getData() {
        return data;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_session.data
     *
     * @param data the value for lt_session.data
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    public void setData(byte[] data) {
        this.data = data;
    }
}