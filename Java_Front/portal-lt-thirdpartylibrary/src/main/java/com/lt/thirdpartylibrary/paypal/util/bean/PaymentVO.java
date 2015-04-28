package com.lt.thirdpartylibrary.paypal.util.bean;

import com.paypal.base.rest.PayPalModel;

/**
 * 
 * @author james.chen
 *
 */
public class PaymentVO extends PayPalModel
{
	/**base attribute**/
	/**
	 * for example : "paypal","zhifubao"
	 */
	private String paymentType;
	
	private String urlPre;
	
	private String paymentId;
	
	private String payerId;
	
	private String createTime;
	
	private String updateTime;
	
	private String fee;
	
	private String transactionId;
	
	private String requestString;
	
	private String responseString;
	
	
	/************ be related com.paypal.api.payments.Address********************/
	/************ start ********************/
	
	/**
	 * Line 1 of the Address (eg. number, street, etc). example "52 N Main ST"
	 */
	private String line1;

	/**
	 * Optional line 2 of the Address (eg. suite, apt #, etc.).
	 */
	private String line2;
	
	/**
	 * City name. example "Johnstown"
	 */
	private String city;
	
	/**
	 * 2 letter country code. example "US"
	 */
	private String countryCode;
	
	/**
	 * Zip code or equivalent is usually required for countries that have them.
	 * For list of countries that do not have postal codes please refer to
	 * http://en.wikipedia.org/wiki/Postal_code.
	 * example "43210"
	 */
	private String postalCode;
	
	/**
	 * 2 letter code for US states, and the equivalent for other countries.
	 * example "OH"
	 */
	private String state;
	
	/************ end ********************/
	/************ be related com.paypal.api.payments.Address********************/
	
	/************ be related com.paypal.api.payments.CreditCard********************/
	/************ start ********************/
	
	/**
	 * Card validation code. Only supported when making a Payment but not when saving a credit card for future use.
	 * example 111
	 */
	private Integer cvv2;
	
	/**
	 * 2 digit card expiry month. example 11
	 */
	private Integer expireMonth;
	
	/**
	 * 4 digit card expiry year example 2018
	 */
	private Integer expireYear; 
	
	/**
	 * Card holder's first name. example "Joe"
	 */
	private String firstName;
	
	/**
	 * Card holder's last name. example "Shopper"
	 */
	private String lastName;
	
	/**
	 * Card number. example "5500005555555559"
	 */
	private String number;
	
	/**
	 * Type of the Card (eg. Visa, Mastercard, etc.).
	 */
	private String type;
	
	/************ end ********************/
	/************ be related com.paypal.api.payments.CreditCard********************/
	
	/************ be related com.paypal.api.payments.Details********************/
	/************ start ********************/
	
	/**
	 * Amount being charged for shipping. example "1"
	 */
	private String shipping;

	/**
	 * Sub-total (amount) of items being paid for. example "5"
	 */
	private String subtotal;

	/**
	 * Amount being charged as tax. example "1"
	 */
	private String tax;
	
	/************ end ********************/
	/************ be related com.paypal.api.payments.Details********************/
	
	
	/************ be related com.paypal.api.payments.Amount********************/
	/************ start ********************/
	
	/**
	 * 3 letter currency code example "USD"
	 */
	private String currency;

	/**
	 * Total amount charged from the Payer account (or card) to Payee. In case of a refund, this is the refunded amount to the original Payer from Payee account.
	 * example "7"
	 */
	private String total;

	/************ end ********************/
	/************ be related com.paypal.api.payments.Amount********************/
	
	/************ be related com.paypal.api.payments.Transaction********************/
	/************ start ********************/
	
	private String description;
	
	/************ end ********************/
	/************ be related com.paypal.api.payments.Transaction********************/
	
	/************ be related com.paypal.api.payments.Payer********************/
	/************ start ********************/
	
	/**
	 * Payment method being used - PayPal Wallet payment, Bank Direct Debit  or Direct Credit card.
	 */
	private String paymentMethod;
	
	private String email;
	
	/************ end ********************/
	/************ be related com.paypal.api.payments.Payer********************/
	
	/************ be related com.paypal.api.payments.Payment  start********************/
	/**
	 * Intent of the payment - Sale or Authorization or Order.
	 */
	private String intent;
	
	/************ be related com.paypal.api.payments.Payment  end********************/
	
	/************ be related com.paypal.api.payments.Item  end********************/
	private String quantity;
	private String name;
	private String price;
	
	/************ be related com.paypal.api.payments.Item  end********************/
	
	/*************************   call back  start ****************************************/
	
	/**
	 * Url where the payer would be redirected to after approving the payment.
	 */
	private String returnUrl;

	/**
	 * Url where the payer would be redirected to after canceling the payment.
	 */
	private String cancelUrl;
	
	private String approvalUrl;
	
	/*************************   call back end ****************************************/
	
	public PaymentVO()
	{
		
	}

	//setter and getter
	public String getCity()
	{
		return city;
	}

	public void setCity(String city)
	{
		this.city = city;
	}

	public String getCountryCode()
	{
		return countryCode;
	}

	public void setCountryCode(String countryCode)
	{
		this.countryCode = countryCode;
	}

	public String getPostalCode()
	{
		return postalCode;
	}

	public void setPostalCode(String postalCode)
	{
		this.postalCode = postalCode;
	}

	public String getState()
	{
		return state;
	}

	public void setState(String state)
	{
		this.state = state;
	}

	public Integer getCvv2()
	{
		return cvv2;
	}

	public void setCvv2(Integer cvv2)
	{
		this.cvv2 = cvv2;
	}

	public Integer getExpireMonth()
	{
		return expireMonth;
	}

	public void setExpireMonth(Integer expireMonth)
	{
		this.expireMonth = expireMonth;
	}

	public Integer getExpireYear()
	{
		return expireYear;
	}

	public void setExpireYear(Integer expireYear)
	{
		this.expireYear = expireYear;
	}

	public String getFirstName()
	{
		return firstName;
	}

	public void setFirstName(String firstName)
	{
		this.firstName = firstName;
	}

	public String getLastName()
	{
		return lastName;
	}

	public void setLastName(String lastName)
	{
		this.lastName = lastName;
	}

	public String getNumber()
	{
		return number;
	}

	public void setNumber(String number)
	{
		this.number = number;
	}

	public String getType()
	{
		return type;
	}

	public void setType(String type)
	{
		this.type = type;
	}

	public String getShipping()
	{
		return shipping;
	}

	public void setShipping(String shipping)
	{
		this.shipping = shipping;
	}

	public String getSubtotal()
	{
		return subtotal;
	}

	public void setSubtotal(String subtotal)
	{
		this.subtotal = subtotal;
	}

	public String getTax()
	{
		return tax;
	}

	public void setTax(String tax)
	{
		this.tax = tax;
	}

	public String getCurrency()
	{
		return currency;
	}

	public void setCurrency(String currency)
	{
		this.currency = currency;
	}

	public String getTotal()
	{
		return total;
	}

	public void setTotal(String total)
	{
		this.total = total;
	}

	public String getDescription()
	{
		return description;
	}

	public void setDescription(String description)
	{
		this.description = description;
	}

	public String getPaymentMethod()
	{
		return paymentMethod;
	}

	public void setPaymentMethod(String paymentMethod)
	{
		this.paymentMethod = paymentMethod;
	}

	public String getIntent()
	{
		return intent;
	}

	public void setIntent(String intent)
	{
		this.intent = intent;
	}

	public String getLine1()
	{
		return line1;
	}

	public void setLine1(String line1)
	{
		this.line1 = line1;
	}

	public String getLine2()
	{
		return line2;
	}

	public void setLine2(String line2)
	{
		this.line2 = line2;
	}

	public String getApprovalUrl()
	{
		return approvalUrl;
	}

	public void setApprovalUrl(String approvalUrl)
	{
		this.approvalUrl = approvalUrl;
	}

	public String getQuantity() {
		return quantity;
	}

	public void setQuantity(String quantity) {
		this.quantity = quantity;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getPrice() {
		return price;
	}

	public void setPrice(String price) {
		this.price = price;
	}

	public String getReturnUrl() {
		return returnUrl;
	}

	public void setReturnUrl(String returnUrl) {
		this.returnUrl = returnUrl;
	}

	public String getCancelUrl() {
		return cancelUrl;
	}

	public void setCancelUrl(String cancelUrl) {
		this.cancelUrl = cancelUrl;
	}

	public String getPaymentType()
	{
		return paymentType;
	}

	public void setPaymentType(String paymentType)
	{
		this.paymentType = paymentType;
	}

	public String getUrlPre()
	{
		return urlPre;
	}

	public void setUrlPre(String urlPre)
	{
		this.urlPre = urlPre;
	}

	public String getPaymentId()
	{
		return paymentId;
	}

	public void setPaymentId(String paymentId)
	{
		this.paymentId = paymentId;
	}

	public String getCreateTime()
	{
		return createTime;
	}

	public void setCreateTime(String createTime)
	{
		this.createTime = createTime;
	}

	public String getUpdateTime()
	{
		return updateTime;
	}

	public void setUpdateTime(String updateTime)
	{
		this.updateTime = updateTime;
	}

	public String getPayerId()
	{
		return payerId;
	}

	public void setPayerId(String payerId)
	{
		this.payerId = payerId;
	}

	public String getEmail()
	{
		return email;
	}

	public void setEmail(String email)
	{
		this.email = email;
	}

	public String getFee()
	{
		return fee;
	}

	public void setFee(String fee)
	{
		this.fee = fee;
	}

	public String getTransactionId()
	{
		return transactionId;
	}

	public void setTransactionId(String transactionId)
	{
		this.transactionId = transactionId;
	}

	public String getRequestString()
	{
		return requestString;
	}

	public void setRequestString(String requestString)
	{
		this.requestString = requestString;
	}

	public String getResponseString()
	{
		return responseString;
	}

	public void setResponseString(String responseString)
	{
		this.responseString = responseString;
	}
	
}
