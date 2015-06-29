package com.lt.dao.mapper;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.TransactionCreditCard;
@Repository
public interface TransactionCreditCardMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_credit_card
     *
     * @mbggenerated Tue Mar 24 15:09:44 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_credit_card
     *
     * @mbggenerated Tue Mar 24 15:09:44 CST 2015
     */
    int insert(TransactionCreditCard record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_credit_card
     *
     * @mbggenerated Tue Mar 24 15:09:44 CST 2015
     */
    int insertSelective(TransactionCreditCard record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_credit_card
     *
     * @mbggenerated Tue Mar 24 15:09:44 CST 2015
     */
    TransactionCreditCard selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_credit_card
     *
     * @mbggenerated Tue Mar 24 15:09:44 CST 2015
     */
    int updateByPrimaryKeySelective(TransactionCreditCard record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction_credit_card
     *
     * @mbggenerated Tue Mar 24 15:09:44 CST 2015
     */
    int updateByPrimaryKey(TransactionCreditCard record);
}