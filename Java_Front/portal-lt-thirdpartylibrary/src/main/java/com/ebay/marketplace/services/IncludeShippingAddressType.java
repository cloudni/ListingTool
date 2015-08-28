
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlEnum;
import javax.xml.bind.annotation.XmlEnumValue;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for IncludeShippingAddressType.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * &lt;simpleType name="IncludeShippingAddressType">
 *   &lt;restriction base="{http://www.w3.org/2001/XMLSchema}token">
 *     &lt;enumeration value="Always"/>
 *     &lt;enumeration value="CheckoutComplete"/>
 *   &lt;/restriction>
 * &lt;/simpleType>
 * </pre>
 * 
 */
@XmlType(name = "IncludeShippingAddressType")
@XmlEnum
public enum IncludeShippingAddressType {


    /**
     * 
     * 					This value indicates that buyers' shipping address information should always be emitted in Merchant Data's <b>SoldReport</b> response.
     * 				
     * 
     */
    @XmlEnumValue("Always")
    ALWAYS("Always"),

    /**
     * 
     * 					This value indicates that buyers' shipping address information should be emitted in Merchant Data's <b>SoldReport</b> response only when payment has been cleared.
     * 				
     * 
     */
    @XmlEnumValue("CheckoutComplete")
    CHECKOUT_COMPLETE("CheckoutComplete");
    private final String value;

    IncludeShippingAddressType(String v) {
        value = v;
    }

    public String value() {
        return value;
    }

    public static IncludeShippingAddressType fromValue(String v) {
        for (IncludeShippingAddressType c: IncludeShippingAddressType.values()) {
            if (c.value.equals(v)) {
                return c;
            }
        }
        throw new IllegalArgumentException(v);
    }

}
