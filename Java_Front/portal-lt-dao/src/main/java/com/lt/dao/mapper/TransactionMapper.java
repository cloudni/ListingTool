package com.lt.dao.mapper;

import java.util.List;

import org.springframework.stereotype.Repository;

import com.lt.dao.model.Transaction;
import com.lt.dao.po.TransactionPO;
import com.lt.platform.framework.core.dao.mapper.MyBatisSuperMapper;
@Repository
public interface TransactionMapper extends MyBatisSuperMapper<Transaction> {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    int insert(Transaction record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    int insertSelective(Transaction record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    TransactionPO selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    int updateByPrimaryKeySelective(Transaction record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_transaction
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    int updateByPrimaryKey(Transaction record);
    
    //自定义方法
    /**
     * 根据企业查询企业交易记录
     * @param record
     * @return
     */
    List<TransactionPO> selectBySelective(TransactionPO record);
    /**
     * 查询当前插入的交易主键id
     * @return
     */
    Integer selectLastestInsertId();
    /**
     * 批量插入transaction
     * @param list
     */
    void batchInsert(List<Transaction> list);
    /**
     * 根据关联的对象查询交易历史
     * @param record
     * @return
     */
    TransactionPO selectByRefObject(TransactionPO record);
}