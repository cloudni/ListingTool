package com.lt.dao.mapper;

import com.lt.dao.model.EbayPrefetchDatetime;

public interface EbayPrefetchDatetimeMapper {
    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_prefetch_datetime
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int deleteByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_prefetch_datetime
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insert(EbayPrefetchDatetime record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_prefetch_datetime
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int insertSelective(EbayPrefetchDatetime record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_prefetch_datetime
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    EbayPrefetchDatetime selectByPrimaryKey(Integer id);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_prefetch_datetime
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKeySelective(EbayPrefetchDatetime record);

    /**
     * This method was generated by MyBatis Generator.
     * This method corresponds to the database table lt_ebay_prefetch_datetime
     *
     * @mbggenerated Tue Mar 17 14:35:43 GMT+08:00 2015
     */
    int updateByPrimaryKey(EbayPrefetchDatetime record);
}