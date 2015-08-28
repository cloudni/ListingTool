
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * 
 * 			Type defining the <b>auctionItemDetails</b> container, which is used to specify whether or not the total bid count and/or the <b>ReserveMet</b> boolean (indicating whether or not Reserve Price was met by the highest bid) is returned in the <b>ActiveInventoryReport</b> response.
 * 		
 * 
 * <p>Java class for AuctionItemDetails complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="AuctionItemDetails">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="includeBidCount" type="{http://www.w3.org/2001/XMLSchema}boolean" minOccurs="0"/>
 *         &lt;element name="includeReservePriceMet" type="{http://www.w3.org/2001/XMLSchema}boolean" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "AuctionItemDetails", propOrder = {
    "includeBidCount",
    "includeReservePriceMet"
})
public class AuctionItemDetails {

    protected Boolean includeBidCount;
    protected Boolean includeReservePriceMet;

    /**
     * Gets the value of the includeBidCount property.
     * 
     * @return
     *     possible object is
     *     {@link Boolean }
     *     
     */
    public Boolean isIncludeBidCount() {
        return includeBidCount;
    }

    /**
     * Sets the value of the includeBidCount property.
     * 
     * @param value
     *     allowed object is
     *     {@link Boolean }
     *     
     */
    public void setIncludeBidCount(Boolean value) {
        this.includeBidCount = value;
    }

    /**
     * Gets the value of the includeReservePriceMet property.
     * 
     * @return
     *     possible object is
     *     {@link Boolean }
     *     
     */
    public Boolean isIncludeReservePriceMet() {
        return includeReservePriceMet;
    }

    /**
     * Sets the value of the includeReservePriceMet property.
     * 
     * @param value
     *     allowed object is
     *     {@link Boolean }
     *     
     */
    public void setIncludeReservePriceMet(Boolean value) {
        this.includeReservePriceMet = value;
    }

}
