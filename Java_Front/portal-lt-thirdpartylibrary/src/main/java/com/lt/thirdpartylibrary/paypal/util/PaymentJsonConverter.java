package com.lt.thirdpartylibrary.paypal.util;

import com.google.gson.Gson;
import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;

public class PaymentJsonConverter
{
	public static String getPaymentFee(String paymentString) {
		Gson gson = new Gson();
		JsonElement element = gson.fromJson(paymentString, JsonElement.class);
		JsonObject object = element.getAsJsonObject();
		JsonArray array = object.getAsJsonArray("transactions");
		element = array.get(0);
		object = element.getAsJsonObject();
		array = object.getAsJsonArray("related_resources");
		element = array.get(0);
		object = element.getAsJsonObject();
		object = object.getAsJsonObject("sale");
		object = object.getAsJsonObject("transaction_fee");
		String transactionFee = object.get("value").getAsString();
		return transactionFee;
	}
	
	//public static String getPayoutResponse(String pay)
	
	public static void main(String[] args)
	{
		String str = "{\"id\":\"PAY-40F44554GK1937941KUFXZVY\",\"create_time\":\"2015-03-20T01:50:15Z\",\"update_time\":\"2015-03-20T01:50:35Z\",\"state\":\"approved\",\"intent\":\"sale\",\"payer\":{\"payment_method\":\"paypal\",\"payer_info\":{\"email\":\"cghbs22-buyer@gmail.com\",\"first_name\":\"test\",\"last_name\":\"buyer\",\"payer_id\":\"AK9CFE3Z44FHQ\",\"shipping_address\":{\"line1\":\"1 Main St\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\",\"recipient_name\":\"test buyer\"}}},\"transactions\":[{\"amount\":{\"total\":\"0.10\",\"currency\":\"USD\",\"details\":{\"subtotal\":\"0.10\"}},\"description\":\"This is payment transaction in advance\",\"item_list\":{\"items\":[{\"name\":\"customer payment in advance\",\"price\":\"0.10\",\"currency\":\"USD\",\"quantity\":\"1\"}],\"shipping_address\":{\"recipient_name\":\"test buyer\",\"line1\":\"1 Main St\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}},\"related_resources\":[{\"sale\":{\"id\":\"1NN9164325808841R\",\"create_time\":\"2015-03-20T01:50:15Z\",\"update_time\":\"2015-03-20T01:50:35Z\",\"amount\":{\"total\":\"0.10\",\"currency\":\"USD\"},\"payment_mode\":\"INSTANT_TRANSFER\",\"state\":\"completed\",\"protection_eligibility\":\"ELIGIBLE\",\"protection_eligibility_type\":\"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\"parent_payment\":\"PAY-40F44554GK1937941KUFXZVY\",\"transaction_fee\":{\"value\":\"0.10\",\"currency\":\"USD\"},\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v1/payments/sale/1NN9164325808841R\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v1/payments/sale/1NN9164325808841R/refund\",\"rel\":\"refund\",\"method\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v1/payments/payment/PAY-40F44554GK1937941KUFXZVY\",\"rel\":\"parent_payment\",\"method\":\"GET\"}]}}]}],\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v1/payments/payment/PAY-40F44554GK1937941KUFXZVY\",\"rel\":\"self\",\"method\":\"GET\"}]}";
		getPaymentFee(str);
	}
}
