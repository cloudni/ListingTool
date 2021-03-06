package com.lt.dao.model;

public class GoogleCategory {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_category.id
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_category.category_id
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    private Integer categoryId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_category.category_desc
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    private String categoryDesc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_category.type
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    private String type;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_category.enabled
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    private Boolean enabled;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_category.id
     *
     * @return the value of lt_google_category.id
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_category.id
     *
     * @param id the value for lt_google_category.id
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_category.category_id
     *
     * @return the value of lt_google_category.category_id
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public Integer getCategoryId() {
        return categoryId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_category.category_id
     *
     * @param categoryId the value for lt_google_category.category_id
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public void setCategoryId(Integer categoryId) {
        this.categoryId = categoryId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_category.category_desc
     *
     * @return the value of lt_google_category.category_desc
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public String getCategoryDesc() {
        return categoryDesc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_category.category_desc
     *
     * @param categoryDesc the value for lt_google_category.category_desc
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public void setCategoryDesc(String categoryDesc) {
        this.categoryDesc = categoryDesc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_category.type
     *
     * @return the value of lt_google_category.type
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public String getType() {
        return type;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_category.type
     *
     * @param type the value for lt_google_category.type
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public void setType(String type) {
        this.type = type;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_category.enabled
     *
     * @return the value of lt_google_category.enabled
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public Boolean getEnabled() {
        return enabled;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_category.enabled
     *
     * @param enabled the value for lt_google_category.enabled
     *
     * @mbggenerated Tue Apr 07 16:42:10 CST 2015
     */
    public void setEnabled(Boolean enabled) {
        this.enabled = enabled;
    }
}