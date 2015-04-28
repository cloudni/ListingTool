package com.lt.dao.model;

import java.math.BigDecimal;
import java.util.Date;

public class TransactionPaypal {
	
	private String token;
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private Integer transactionId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.interface_name
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String interfaceName;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.action_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String actionState;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.payment_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String paymentId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.payment_transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String paymentTransactionId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.payment_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String paymentState;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.platform_account_name
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String platformAccountName;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.platform_account_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String platformAccountState;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.total
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private BigDecimal total;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.fee
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private BigDecimal fee;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.net
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private BigDecimal net;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.created_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String createdTime;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.approved_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String approvedTime;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.completed_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String completedTime;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.id
     *
     * @return the value of lt_transaction_paypal.id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.id
     *
     * @param id the value for lt_transaction_paypal.id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.transaction_id
     *
     * @return the value of lt_transaction_paypal.transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public Integer getTransactionId() {
        return transactionId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.transaction_id
     *
     * @param transactionId the value for lt_transaction_paypal.transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setTransactionId(Integer transactionId) {
        this.transactionId = transactionId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.interface_name
     *
     * @return the value of lt_transaction_paypal.interface_name
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getInterfaceName() {
        return interfaceName;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.interface_name
     *
     * @param interfaceName the value for lt_transaction_paypal.interface_name
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setInterfaceName(String interfaceName) {
        this.interfaceName = interfaceName;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.action_state
     *
     * @return the value of lt_transaction_paypal.action_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getActionState() {
        return actionState;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.action_state
     *
     * @param actionState the value for lt_transaction_paypal.action_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setActionState(String actionState) {
        this.actionState = actionState;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.payment_id
     *
     * @return the value of lt_transaction_paypal.payment_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getPaymentId() {
        return paymentId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.payment_id
     *
     * @param paymentId the value for lt_transaction_paypal.payment_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setPaymentId(String paymentId) {
        this.paymentId = paymentId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.payment_transaction_id
     *
     * @return the value of lt_transaction_paypal.payment_transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getPaymentTransactionId() {
        return paymentTransactionId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.payment_transaction_id
     *
     * @param paymentTransactionId the value for lt_transaction_paypal.payment_transaction_id
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setPaymentTransactionId(String paymentTransactionId) {
        this.paymentTransactionId = paymentTransactionId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.payment_state
     *
     * @return the value of lt_transaction_paypal.payment_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getPaymentState() {
        return paymentState;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.payment_state
     *
     * @param paymentState the value for lt_transaction_paypal.payment_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setPaymentState(String paymentState) {
        this.paymentState = paymentState;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.platform_account_name
     *
     * @return the value of lt_transaction_paypal.platform_account_name
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getPlatformAccountName() {
        return platformAccountName;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.platform_account_name
     *
     * @param platformAccountName the value for lt_transaction_paypal.platform_account_name
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setPlatformAccountName(String platformAccountName) {
        this.platformAccountName = platformAccountName;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.platform_account_state
     *
     * @return the value of lt_transaction_paypal.platform_account_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getPlatformAccountState() {
        return platformAccountState;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.platform_account_state
     *
     * @param platformAccountState the value for lt_transaction_paypal.platform_account_state
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setPlatformAccountState(String platformAccountState) {
        this.platformAccountState = platformAccountState;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.total
     *
     * @return the value of lt_transaction_paypal.total
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public BigDecimal getTotal() {
        return total;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.total
     *
     * @param total the value for lt_transaction_paypal.total
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setTotal(BigDecimal total) {
        this.total = total;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.fee
     *
     * @return the value of lt_transaction_paypal.fee
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public BigDecimal getFee() {
        return fee;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.fee
     *
     * @param fee the value for lt_transaction_paypal.fee
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setFee(BigDecimal fee) {
        this.fee = fee;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.net
     *
     * @return the value of lt_transaction_paypal.net
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public BigDecimal getNet() {
        return net;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.net
     *
     * @param net the value for lt_transaction_paypal.net
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setNet(BigDecimal net) {
        this.net = net;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.created_time
     *
     * @return the value of lt_transaction_paypal.created_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getCreatedTime() {
        return createdTime;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.created_time
     *
     * @param createdTime the value for lt_transaction_paypal.created_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setCreatedTime(String createdTime) {
        this.createdTime = createdTime;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.approved_time
     *
     * @return the value of lt_transaction_paypal.approved_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getApprovedTime() {
        return approvedTime;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.approved_time
     *
     * @param approvedTime the value for lt_transaction_paypal.approved_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setApprovedTime(String approvedTime) {
        this.approvedTime = approvedTime;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.completed_time
     *
     * @return the value of lt_transaction_paypal.completed_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getCompletedTime() {
        return completedTime;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.completed_time
     *
     * @param completedTime the value for lt_transaction_paypal.completed_time
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setCompletedTime(String completedTime) {
        this.completedTime = completedTime;
    }

	public String getToken()
	{
		return token;
	}

	public void setToken(String token)
	{
		this.token = token;
	}
}