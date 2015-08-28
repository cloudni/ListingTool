package com.lt.dao.model;

import java.math.BigDecimal;

import com.lt.platform.framework.core.model.MyBatisSuperModel;

public class Transaction extends MyBatisSuperModel  implements Cloneable{
	private String contents;
	private Integer refId;
	private String refObject;
	private String refDate;
	
	private Boolean enabled;
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.company_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer companyId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.type
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer paymentTransactionType;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.transaction_type
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer type;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.status
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer status;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.payment_transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String paymentTransactionId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.total
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private BigDecimal total;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.fee
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private BigDecimal fee;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.net
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private BigDecimal net;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.create_time_utc
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer createTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.create_admin_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer createUserId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.update_time_utc
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer updateTimeUtc;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction.update_admin_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer updateUserId;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.id
     *
     * @return the value of lt_transaction.id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.id
     *
     * @param id the value for lt_transaction.id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.company_id
     *
     * @return the value of lt_transaction.company_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public Integer getCompanyId() {
        return companyId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.company_id
     *
     * @param companyId the value for lt_transaction.company_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setCompanyId(Integer companyId) {
        this.companyId = companyId;
    }

	public Integer getPaymentTransactionType()
	{
		return paymentTransactionType;
	}

	public void setPaymentTransactionType(Integer paymentTransactionType)
	{
		this.paymentTransactionType = paymentTransactionType;
	}

	public Integer getType()
	{
		return type;
	}

	public void setType(Integer type)
	{
		this.type = type;
	}

    public Integer getStatus()
	{
		return status;
	}

	public void setStatus(Integer status)
	{
		this.status = status;
	}

	/**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.payment_transaction_id
     *
     * @return the value of lt_transaction.payment_transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getPaymentTransactionId() {
        return paymentTransactionId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.payment_transaction_id
     *
     * @param paymentTransactionId the value for lt_transaction.payment_transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setPaymentTransactionId(String paymentTransactionId) {
        this.paymentTransactionId = paymentTransactionId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.total
     *
     * @return the value of lt_transaction.total
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public BigDecimal getTotal() {
        return total;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.total
     *
     * @param total the value for lt_transaction.total
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setTotal(BigDecimal total) {
        this.total = total;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.fee
     *
     * @return the value of lt_transaction.fee
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public BigDecimal getFee() {
        return fee;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.fee
     *
     * @param fee the value for lt_transaction.fee
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setFee(BigDecimal fee) {
        this.fee = fee;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.net
     *
     * @return the value of lt_transaction.net
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public BigDecimal getNet() {
        return net;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.net
     *
     * @param net the value for lt_transaction.net
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setNet(BigDecimal net) {
        this.net = net;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.create_time_utc
     *
     * @return the value of lt_transaction.create_time_utc
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public Integer getCreateTimeUtc() {
        return createTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.create_time_utc
     *
     * @param createTimeUtc the value for lt_transaction.create_time_utc
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setCreateTimeUtc(Integer createTimeUtc) {
        this.createTimeUtc = createTimeUtc;
    }

    public Integer getCreateUserId()
	{
		return createUserId;
	}

	public void setCreateUserId(Integer createUserId)
	{
		this.createUserId = createUserId;
	}

	/**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction.update_time_utc
     *
     * @return the value of lt_transaction.update_time_utc
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public Integer getUpdateTimeUtc() {
        return updateTimeUtc;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction.update_time_utc
     *
     * @param updateTimeUtc the value for lt_transaction.update_time_utc
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setUpdateTimeUtc(Integer updateTimeUtc) {
        this.updateTimeUtc = updateTimeUtc;
    }

	public Integer getUpdateUserId()
	{
		return updateUserId;
	}

	public void setUpdateUserId(Integer updateUserId)
	{
		this.updateUserId = updateUserId;
	}

	public String getContents()
	{
		return contents;
	}

	public void setContents(String contents)
	{
		this.contents = contents;
	}

	public Boolean getEnabled()
	{
		return enabled;
	}

	public void setEnabled(Boolean enabled)
	{
		this.enabled = enabled;
	}

	public Integer getRefId()
	{
		return refId;
	}

	public void setRefId(Integer refId)
	{
		this.refId = refId;
	}

	public String getRefObject()
	{
		return refObject;
	}

	public void setRefObject(String refObject)
	{
		this.refObject = refObject;
	}
	
	public String getRefDate()
	{
		return refDate;
	}

	public void setRefDate(String refDate)
	{
		this.refDate = refDate;
	}

	@Override
	public Transaction clone()
	{
		Transaction o = null;
		try
		{
			o = (Transaction) super.clone();// Object 中的clone()识别出你要复制的是哪一个对象。
		} catch (CloneNotSupportedException e)
		{
			e.printStackTrace();
		}
		return o;
	}
}