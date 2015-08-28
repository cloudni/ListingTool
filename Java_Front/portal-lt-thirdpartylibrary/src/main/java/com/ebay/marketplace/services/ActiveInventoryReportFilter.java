
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * 
 * 			Type defining the <b>activeInventoryReportFilter</b> container, which allows the user to control which containers/fields are returned in an <b>ActiveInventoryReport</b> response.
 * 		
 * 
 * <p>Java class for ActiveInventoryReportFilter complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="ActiveInventoryReportFilter">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="includeListingType" type="{http://www.ebay.com/marketplace/services}IncludeListingType" minOccurs="0"/>
 *         &lt;element name="fixedPriceItemDetails" type="{http://www.ebay.com/marketplace/services}FixedPriceItemDetails" minOccurs="0"/>
 *         &lt;element name="auctionItemDetails" type="{http://www.ebay.com/marketplace/services}AuctionItemDetails" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "ActiveInventoryReportFilter", propOrder = {
    "includeListingType",
    "fixedPriceItemDetails",
    "auctionItemDetails"
})
public class ActiveInventoryReportFilter {

    protected IncludeListingType includeListingType;
    protected FixedPriceItemDetails fixedPriceItemDetails;
    protected AuctionItemDetails auctionItemDetails;

    /**
     * Gets the value of the includeListingType property.
     * 
     * @return
     *     possible object is
     *     {@link IncludeListingType }
     *     
     */
    public IncludeListingType getIncludeListingType() {
        return includeListingType;
    }

    /**
     * Sets the value of the includeListingType property.
     * 
     * @param value
     *     allowed object is
     *     {@link IncludeListingType }
     *     
     */
    public void setIncludeListingType(IncludeListingType value) {
        this.includeListingType = value;
    }

    /**
     * Gets the value of the fixedPriceItemDetails property.
     * 
     * @return
     *     possible object is
     *     {@link FixedPriceItemDetails }
     *     
     */
    public FixedPriceItemDetails getFixedPriceItemDetails() {
        return fixedPriceItemDetails;
    }

    /**
     * Sets the value of the fixedPriceItemDetails property.
     * 
     * @param value
     *     allowed object is
     *     {@link FixedPriceItemDetails }
     *     
     */
    public void setFixedPriceItemDetails(FixedPriceItemDetails value) {
        this.fixedPriceItemDetails = value;
    }

    /**
     * Gets the value of the auctionItemDetails property.
     * 
     * @return
     *     possible object is
     *     {@link AuctionItemDetails }
     *     
     */
    public AuctionItemDetails getAuctionItemDetails() {
        return auctionItemDetails;
    }

    /**
     * Sets the value of the auctionItemDetails property.
     * 
     * @param value
     *     allowed object is
     *     {@link AuctionItemDetails }
     *     
     */
    public void setAuctionItemDetails(AuctionItemDetails value) {
        this.auctionItemDetails = value;
    }

}
