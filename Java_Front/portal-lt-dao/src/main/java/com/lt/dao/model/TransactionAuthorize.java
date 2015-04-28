package com.lt.dao.model;

import java.math.BigDecimal;

public class TransactionAuthorize {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_authorize.id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_authorize.company_id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    private Integer companyId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_authorize.amount
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    private BigDecimal amount;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_authorize.ref_id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    private Integer refId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_authorize.ref_object
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    private String refObject;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_authorize.id
     *
     * @return the value of lt_transaction_authorize.id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_authorize.id
     *
     * @param id the value for lt_transaction_authorize.id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_authorize.company_id
     *
     * @return the value of lt_transaction_authorize.company_id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public Integer getCompanyId() {
        return companyId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_authorize.company_id
     *
     * @param companyId the value for lt_transaction_authorize.company_id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public void setCompanyId(Integer companyId) {
        this.companyId = companyId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_authorize.amount
     *
     * @return the value of lt_transaction_authorize.amount
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public BigDecimal getAmount() {
        return amount;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_authorize.amount
     *
     * @param amount the value for lt_transaction_authorize.amount
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public void setAmount(BigDecimal amount) {
        this.amount = amount;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_authorize.ref_id
     *
     * @return the value of lt_transaction_authorize.ref_id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public Integer getRefId() {
        return refId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_authorize.ref_id
     *
     * @param refId the value for lt_transaction_authorize.ref_id
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public void setRefId(Integer refId) {
        this.refId = refId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_authorize.ref_object
     *
     * @return the value of lt_transaction_authorize.ref_object
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public String getRefObject() {
        return refObject;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_authorize.ref_object
     *
     * @param refObject the value for lt_transaction_authorize.ref_object
     *
     * @mbggenerated Tue Apr 14 10:02:33 CST 2015
     */
    public void setRefObject(String refObject) {
        this.refObject = refObject;
    }

	@Override
	public int hashCode()
	{
		final int prime = 31;
		int result = 1;
		result = prime * result
				+ ((companyId == null) ? 0 : companyId.hashCode());
		return result;
	}
	
	public TransactionAuthorize()
	{
		super();
	}

	public TransactionAuthorize(Integer companyId)
	{
		super();
		this.companyId = companyId;
	}

	@Override
	public boolean equals(Object obj)
	{
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		TransactionAuthorize other = (TransactionAuthorize) obj;
		if (companyId == null)
		{
			if (other.companyId != null)
				return false;
		} else if (!companyId.equals(other.companyId))
			return false;
		return true;
	}
}