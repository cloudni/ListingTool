package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.TransactionDetail;
@Repository
public interface TransactionDetailMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_detail
     *
     * @mbggenerated Sun Apr 26 15:39:33 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_detail
     *
     * @mbggenerated Sun Apr 26 15:39:33 CST 2015
     */
    int insert(TransactionDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_detail
     *
     * @mbggenerated Sun Apr 26 15:39:33 CST 2015
     */
    int insertSelective(TransactionDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_detail
     *
     * @mbggenerated Sun Apr 26 15:39:33 CST 2015
     */
    TransactionDetail selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_detail
     *
     * @mbggenerated Sun Apr 26 15:39:33 CST 2015
     */
    int updateByPrimaryKeySelective(TransactionDetail record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_detail
     *
     * @mbggenerated Sun Apr 26 15:39:33 CST 2015
     */
    int updateByPrimaryKey(TransactionDetail record);
    
    //自定义
    /**
     * 根据关联表查询交易详情
     * @param record
     * @return
     */
	TransactionDetail getDetailByRefObject(TransactionDetail record);
}