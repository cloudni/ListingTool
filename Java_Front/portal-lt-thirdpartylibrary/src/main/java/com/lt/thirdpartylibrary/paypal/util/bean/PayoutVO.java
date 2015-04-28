package com.lt.thirdpartylibrary.paypal.util.bean;

public class PayoutVO
{
	private String timeCreated;
	private String timeCompleted;
	private String fee;
	private String transactionId;
	private String transactionStatus;
	
	private String requestString;
	
	private String responseString;
	
	private String firstName;
	
	private String lastName;
	
	/*********************** PayoutSenderBatchHeader start **************/
	/**
		 * Sender-created ID for tracking the batch payout in an accounting system. 30 characters max.
		 */
		private String senderBatchId;

		/**
		 * The subject line text for the email that PayPal sends when a payout item is completed. (The subject line is the same for all recipients.) Maximum of 255 single-byte alphanumeric characters.
		 */
		private String emailSubject;
		
		/*********************** PayoutSenderBatchHeader end **************/

		/*********************** Currency start **************/
		/**
		 * 3 letter currency code
		 */
		private String currency;
		/**
		 * amount upto 2 decimals represented as string
		 */
		private String value;
		
		/*********************** Currency end **************/
		
		/*********************** PayoutItem start **************/
		/**
		 * The type of identification for the payment receiver. If this field is
		 * provided, the payout items without a `recipient_type` will use the
		 * provided value. If this field is not provided, each payout item must
		 * include a value for the `recipient_type`.
		 */
		private String recipientType;

		/**
		 * Note for notifications. The note is provided by the payment sender. This
		 * note can be any string. 4000 characters max.
		 */
		private String note;

		/**
		 * The receiver of the payment. In a call response, the format of this value
		 * corresponds to the `recipient_type` specified in the request. 127
		 * characters max.
		 */
		private String receiver;

		/**
		 * A sender-specific ID number, used in an accounting system for tracking
		 * purposes. 30 characters max.
		 */
		private String senderItemId;
		
		/*********************** PayoutItem end **************/
		
		//getter and setter
		public String getSenderBatchId()
		{
			return senderBatchId;
		}

		public void setSenderBatchId(String senderBatchId)
		{
			this.senderBatchId = senderBatchId;
		}

		public String getEmailSubject()
		{
			return emailSubject;
		}

		public void setEmailSubject(String emailSubject)
		{
			this.emailSubject = emailSubject;
		}

		public String getCurrency()
		{
			return currency;
		}

		public void setCurrency(String currency)
		{
			this.currency = currency;
		}

		public String getValue()
		{
			return value;
		}

		public void setValue(String value)
		{
			this.value = value;
		}

		public String getRecipientType()
		{
			return recipientType;
		}

		public void setRecipientType(String recipientType)
		{
			this.recipientType = recipientType;
		}

		public String getNote()
		{
			return note;
		}

		public void setNote(String note)
		{
			this.note = note;
		}

		public String getReceiver()
		{
			return receiver;
		}

		public void setReceiver(String receiver)
		{
			this.receiver = receiver;
		}

		public String getSenderItemId()
		{
			return senderItemId;
		}

		public void setSenderItemId(String senderItemId)
		{
			this.senderItemId = senderItemId;
		}

		public String getTimeCreated()
		{
			return timeCreated;
		}

		public void setTimeCreated(String timeCreated)
		{
			this.timeCreated = timeCreated;
		}

		public String getTimeCompleted()
		{
			return timeCompleted;
		}

		public void setTimeCompleted(String timeCompleted)
		{
			this.timeCompleted = timeCompleted;
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

		public String getTransactionStatus()
		{
			return transactionStatus;
		}

		public void setTransactionStatus(String transactionStatus)
		{
			this.transactionStatus = transactionStatus;
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
}
