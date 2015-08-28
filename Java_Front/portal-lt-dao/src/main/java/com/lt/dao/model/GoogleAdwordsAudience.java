package com.lt.dao.model;

import com.lt.platform.framework.core.model.MyBatisSuperModel;

public class GoogleAdwordsAudience extends MyBatisSuperModel {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.pk_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Long pkId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Long id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.is_read_only
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Boolean isReadOnly;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.name
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String name;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.description
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String description;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.status
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String status;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.integration_code
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String integrationCode;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.access_reason
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String accessReason;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.account_user_list_status
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String accountUserListStatus;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.membership_life_span
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Long membershipLifeSpan;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.size
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Long size;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.size_range
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String sizeRange;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.size_for_search
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Long sizeForSearch;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.size_range_for_search
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String sizeRangeForSearch;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.list_type
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String listType;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.user_list_type
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String userListType;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.is_run
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Boolean isRun;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.create_time_utc
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Integer createTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.create_user_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Integer createUserId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.update_time_utc
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Integer updateTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.update_user_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private Integer updateUserId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_google_adwords_audience.rule
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    private String rule;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.pk_id
     *
     * @return the value of lt_google_adwords_audience.pk_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Long getPkId() {
        return pkId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.pk_id
     *
     * @param pkId the value for lt_google_adwords_audience.pk_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setPkId(Long pkId) {
        this.pkId = pkId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.id
     *
     * @return the value of lt_google_adwords_audience.id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Long getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.id
     *
     * @param id the value for lt_google_adwords_audience.id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setId(Long id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.is_read_only
     *
     * @return the value of lt_google_adwords_audience.is_read_only
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Boolean getIsReadOnly() {
        return isReadOnly;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.is_read_only
     *
     * @param isReadOnly the value for lt_google_adwords_audience.is_read_only
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setIsReadOnly(Boolean isReadOnly) {
        this.isReadOnly = isReadOnly;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.name
     *
     * @return the value of lt_google_adwords_audience.name
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getName() {
        return name;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.name
     *
     * @param name the value for lt_google_adwords_audience.name
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setName(String name) {
        this.name = name;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.description
     *
     * @return the value of lt_google_adwords_audience.description
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getDescription() {
        return description;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.description
     *
     * @param description the value for lt_google_adwords_audience.description
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setDescription(String description) {
        this.description = description;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.status
     *
     * @return the value of lt_google_adwords_audience.status
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getStatus() {
        return status;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.status
     *
     * @param status the value for lt_google_adwords_audience.status
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setStatus(String status) {
        this.status = status;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.integration_code
     *
     * @return the value of lt_google_adwords_audience.integration_code
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getIntegrationCode() {
        return integrationCode;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.integration_code
     *
     * @param integrationCode the value for lt_google_adwords_audience.integration_code
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setIntegrationCode(String integrationCode) {
        this.integrationCode = integrationCode;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.access_reason
     *
     * @return the value of lt_google_adwords_audience.access_reason
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getAccessReason() {
        return accessReason;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.access_reason
     *
     * @param accessReason the value for lt_google_adwords_audience.access_reason
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setAccessReason(String accessReason) {
        this.accessReason = accessReason;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.account_user_list_status
     *
     * @return the value of lt_google_adwords_audience.account_user_list_status
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getAccountUserListStatus() {
        return accountUserListStatus;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.account_user_list_status
     *
     * @param accountUserListStatus the value for lt_google_adwords_audience.account_user_list_status
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setAccountUserListStatus(String accountUserListStatus) {
        this.accountUserListStatus = accountUserListStatus;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.membership_life_span
     *
     * @return the value of lt_google_adwords_audience.membership_life_span
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Long getMembershipLifeSpan() {
        return membershipLifeSpan;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.membership_life_span
     *
     * @param membershipLifeSpan the value for lt_google_adwords_audience.membership_life_span
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setMembershipLifeSpan(Long membershipLifeSpan) {
        this.membershipLifeSpan = membershipLifeSpan;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.size
     *
     * @return the value of lt_google_adwords_audience.size
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Long getSize() {
        return size;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.size
     *
     * @param size the value for lt_google_adwords_audience.size
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setSize(Long size) {
        this.size = size;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.size_range
     *
     * @return the value of lt_google_adwords_audience.size_range
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getSizeRange() {
        return sizeRange;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.size_range
     *
     * @param sizeRange the value for lt_google_adwords_audience.size_range
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setSizeRange(String sizeRange) {
        this.sizeRange = sizeRange;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.size_for_search
     *
     * @return the value of lt_google_adwords_audience.size_for_search
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Long getSizeForSearch() {
        return sizeForSearch;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.size_for_search
     *
     * @param sizeForSearch the value for lt_google_adwords_audience.size_for_search
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setSizeForSearch(Long sizeForSearch) {
        this.sizeForSearch = sizeForSearch;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.size_range_for_search
     *
     * @return the value of lt_google_adwords_audience.size_range_for_search
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getSizeRangeForSearch() {
        return sizeRangeForSearch;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.size_range_for_search
     *
     * @param sizeRangeForSearch the value for lt_google_adwords_audience.size_range_for_search
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setSizeRangeForSearch(String sizeRangeForSearch) {
        this.sizeRangeForSearch = sizeRangeForSearch;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.list_type
     *
     * @return the value of lt_google_adwords_audience.list_type
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getListType() {
        return listType;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.list_type
     *
     * @param listType the value for lt_google_adwords_audience.list_type
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setListType(String listType) {
        this.listType = listType;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.user_list_type
     *
     * @return the value of lt_google_adwords_audience.user_list_type
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getUserListType() {
        return userListType;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.user_list_type
     *
     * @param userListType the value for lt_google_adwords_audience.user_list_type
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setUserListType(String userListType) {
        this.userListType = userListType;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.is_run
     *
     * @return the value of lt_google_adwords_audience.is_run
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Boolean getIsRun() {
        return isRun;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.is_run
     *
     * @param isRun the value for lt_google_adwords_audience.is_run
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setIsRun(Boolean isRun) {
        this.isRun = isRun;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.create_time_utc
     *
     * @return the value of lt_google_adwords_audience.create_time_utc
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Integer getCreateTimeUtc() {
        return createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.create_time_utc
     *
     * @param createTimeUtc the value for lt_google_adwords_audience.create_time_utc
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setCreateTimeUtc(Integer createTimeUtc) {
        this.createTimeUtc = createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.create_user_id
     *
     * @return the value of lt_google_adwords_audience.create_user_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Integer getCreateUserId() {
        return createUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.create_user_id
     *
     * @param createUserId the value for lt_google_adwords_audience.create_user_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setCreateUserId(Integer createUserId) {
        this.createUserId = createUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.update_time_utc
     *
     * @return the value of lt_google_adwords_audience.update_time_utc
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Integer getUpdateTimeUtc() {
        return updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.update_time_utc
     *
     * @param updateTimeUtc the value for lt_google_adwords_audience.update_time_utc
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setUpdateTimeUtc(Integer updateTimeUtc) {
        this.updateTimeUtc = updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.update_user_id
     *
     * @return the value of lt_google_adwords_audience.update_user_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public Integer getUpdateUserId() {
        return updateUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.update_user_id
     *
     * @param updateUserId the value for lt_google_adwords_audience.update_user_id
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setUpdateUserId(Integer updateUserId) {
        this.updateUserId = updateUserId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_google_adwords_audience.rule
     *
     * @return the value of lt_google_adwords_audience.rule
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public String getRule() {
        return rule;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_google_adwords_audience.rule
     *
     * @param rule the value for lt_google_adwords_audience.rule
     *
     * @mbggenerated Tue Jun 09 13:54:27 CST 2015
     */
    public void setRule(String rule) {
        this.rule = rule;
    }
}