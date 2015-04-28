package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.GoogleAdwordsBudget;

@Repository
public interface GoogleAdwordsBudgetMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_budget
     *
     * @mbggenerated Mon Apr 27 16:42:45 CST 2015
     */
    int deleteByPrimaryKey(Long budgetId);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_budget
     *
     * @mbggenerated Mon Apr 27 16:42:45 CST 2015
     */
    int insert(GoogleAdwordsBudget record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_budget
     *
     * @mbggenerated Mon Apr 27 16:42:45 CST 2015
     */
    int insertSelective(GoogleAdwordsBudget record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_budget
     *
     * @mbggenerated Mon Apr 27 16:42:45 CST 2015
     */
    GoogleAdwordsBudget selectByPrimaryKey(Long budgetId);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_budget
     *
     * @mbggenerated Mon Apr 27 16:42:45 CST 2015
     */
    int updateByPrimaryKeySelective(GoogleAdwordsBudget record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_google_adwords_budget
     *
     * @mbggenerated Mon Apr 27 16:42:45 CST 2015
     */
    int updateByPrimaryKey(GoogleAdwordsBudget record);
}