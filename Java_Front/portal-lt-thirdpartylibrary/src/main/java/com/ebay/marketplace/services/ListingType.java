
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlEnum;
import javax.xml.bind.annotation.XmlEnumValue;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for ListingType.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * <p>
 * <pre>
 * &lt;simpleType name="ListingType">
 *   &lt;restriction base="{http://www.w3.org/2001/XMLSchema}token">
 *     &lt;enumeration value="Half"/>
 *   &lt;/restriction>
 * &lt;/simpleType>
 * </pre>
 * 
 */
@XmlType(name = "ListingType")
@XmlEnum
public enum ListingType {


    /**
     * 
     * 					This value is used if the seller wants to retrieve Half.com orders.
     * 				
     * 
     */
    @XmlEnumValue("Half")
    HALF("Half");
    private final String value;

    ListingType(String v) {
        value = v;
    }

    public String value() {
        return value;
    }

    public static ListingType fromValue(String v) {
        for (ListingType c: ListingType.values()) {
            if (c.value.equals(v)) {
                return c;
            }
        }
        throw new IllegalArgumentException(v);
    }

}
