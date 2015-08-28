
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlEnum;
import javax.xml.bind.annotation.XmlEnumValue;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for OrderStatusTypes.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * &lt;simpleType name="OrderStatusTypes">
 *   &lt;restriction base="{http://www.w3.org/2001/XMLSchema}token">
 *     &lt;enumeration value="Active"/>
 *     &lt;enumeration value="All"/>
 *     &lt;enumeration value="Completed"/>
 *     &lt;enumeration value="Cancelled"/>
 *     &lt;enumeration value="Shipped"/>
 *   &lt;/restriction>
 * &lt;/simpleType>
 * </pre>
 * 
 */
@XmlType(name = "OrderStatusTypes")
@XmlEnum
public enum OrderStatusTypes {


    /**
     * 
     * 						If this value is used, only active orders are retrieved. Orders in the 'Active' state means that the buyer's payment on the order has not yet cleared. This value is supported for eBay.com and Half.com orders.
     * 					
     * 
     */
    @XmlEnumValue("Active")
    ACTIVE("Active"),

    /**
     * 
     * 						If this value is used, orders in all states are retrieved. This is the default <b>orderStatus</b> value, and is supported for eBay.com and Half.com orders.
     * 					
     * 
     */
    @XmlEnumValue("All")
    ALL("All"),

    /**
     * 
     * 						If this value is used, only completed orders are retrieved. Orders in the 'Completed' state indicates that the buyer's payment on the order has cleared and checkout is complete. This value is supported for eBay.com and Half.com orders.
     * 					
     * 
     */
    @XmlEnumValue("Completed")
    COMPLETED("Completed"),

    /**
     * 
     * 						If this value is used, only cancelled Half.com orders are retrieved. This value is only supported for Half.com orders.
     * 					
     * 
     */
    @XmlEnumValue("Cancelled")
    CANCELLED("Cancelled"),

    /**
     * 
     * 						If this value is used, only Half.com orders that have been shipped by the seller are retrieved. This value is only supported for Half.com orders.
     * 					
     * 
     */
    @XmlEnumValue("Shipped")
    SHIPPED("Shipped");
    private final String value;

    OrderStatusTypes(String v) {
        value = v;
    }

    public String value() {
        return value;
    }

    public static OrderStatusTypes fromValue(String v) {
        for (OrderStatusTypes c: OrderStatusTypes.values()) {
            if (c.value.equals(v)) {
                return c;
            }
        }
        throw new IllegalArgumentException(v);
    }

}
