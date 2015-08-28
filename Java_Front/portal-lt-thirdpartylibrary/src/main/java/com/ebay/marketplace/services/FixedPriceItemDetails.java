
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * 
 * 			Type defining the <b>fixedPriceItemDetails</b> container, which is used to specify whether or not variation-level data is returned in the <b>ActiveInventoryReport</b> response.
 * 		
 * 
 * <p>Java class for FixedPriceItemDetails complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="FixedPriceItemDetails">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="includeVariations" type="{http://www.w3.org/2001/XMLSchema}boolean" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "FixedPriceItemDetails", propOrder = {
    "includeVariations"
})
public class FixedPriceItemDetails {

    protected Boolean includeVariations;

    /**
     * Gets the value of the includeVariations property.
     * 
     * @return
     *     possible object is
     *     {@link Boolean }
     *     
     */
    public Boolean isIncludeVariations() {
        return includeVariations;
    }

    /**
     * Sets the value of the includeVariations property.
     * 
     * @param value
     *     allowed object is
     *     {@link Boolean }
     *     
     */
    public void setIncludeVariations(Boolean value) {
        this.includeVariations = value;
    }

}
