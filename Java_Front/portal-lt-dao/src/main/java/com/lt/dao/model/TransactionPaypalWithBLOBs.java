package com.lt.dao.model;

public class TransactionPaypalWithBLOBs extends TransactionPaypal {
	private String responseErrorContent;
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.request_content
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String requestContent;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column lt_transaction_paypal.response_content
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    private String responseContent;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.request_content
     *
     * @return the value of lt_transaction_paypal.request_content
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getRequestContent() {
        return requestContent;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.request_content
     *
     * @param requestContent the value for lt_transaction_paypal.request_content
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setRequestContent(String requestContent) {
        this.requestContent = requestContent;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column lt_transaction_paypal.response_content
     *
     * @return the value of lt_transaction_paypal.response_content
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public String getResponseContent() {
        return responseContent;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column lt_transaction_paypal.response_content
     *
     * @param responseContent the value for lt_transaction_paypal.response_content
     *
     * @mbggenerated Wed Mar 25 19:55:16 CST 2015
     */
    public void setResponseContent(String responseContent) {
        this.responseContent = responseContent;
    }

	public String getResponseErrorContent()
	{
		return responseErrorContent;
	}

	public void setResponseErrorContent(String responseErrorContent)
	{
		this.responseErrorContent = responseErrorContent;
	}
}