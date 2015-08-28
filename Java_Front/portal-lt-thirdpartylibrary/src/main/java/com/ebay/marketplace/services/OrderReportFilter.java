
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlSchemaType;
import javax.xml.bind.annotation.XmlType;
import javax.xml.datatype.XMLGregorianCalendar;


/**
 * 
 * 			Type defining the <b>orderReportFilter</b> container, which allows the user 
 * 			to set time, order status, or order type (eBay or Half.com) filters, and to specify whether or not to include Final Value Fees for each order line item in Merchant Data's <b>OrderReport</b> response. 
 * 			<br/><br/>
 * 			The <b>orderReportFilter</b> container is only applicable if the <b>downloadJobType</b> value is set to 'OrderReport'.  
 * 		
 * 
 * <p>Java class for OrderReportFilter complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="OrderReportFilter">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="createTimeFrom" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         &lt;element name="createTimeTo" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         &lt;element name="modTimeFrom" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         &lt;element name="modTimeTo" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         &lt;element name="includeFinalValueFee" type="{http://www.w3.org/2001/XMLSchema}boolean" minOccurs="0"/>
 *         &lt;element name="listingType" type="{http://www.ebay.com/marketplace/services}ListingType" minOccurs="0"/>
 *         &lt;element name="orderStatus" type="{http://www.ebay.com/marketplace/services}OrderStatusTypes" minOccurs="0"/>
 *         &lt;element name="version" type="{http://www.w3.org/2001/XMLSchema}int"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "OrderReportFilter", propOrder = {
    "createTimeFrom",
    "createTimeTo",
    "modTimeFrom",
    "modTimeTo",
    "includeFinalValueFee",
    "listingType",
    "orderStatus",
    "version"
})
public class OrderReportFilter {

    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar createTimeFrom;
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar createTimeTo;
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar modTimeFrom;
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar modTimeTo;
    protected Boolean includeFinalValueFee;
    protected ListingType listingType;
    protected OrderStatusTypes orderStatus;
    protected int version;

    /**
     * Gets the value of the createTimeFrom property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getCreateTimeFrom() {
        return createTimeFrom;
    }

    /**
     * Sets the value of the createTimeFrom property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setCreateTimeFrom(XMLGregorianCalendar value) {
        this.createTimeFrom = value;
    }

    /**
     * Gets the value of the createTimeTo property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getCreateTimeTo() {
        return createTimeTo;
    }

    /**
     * Sets the value of the createTimeTo property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setCreateTimeTo(XMLGregorianCalendar value) {
        this.createTimeTo = value;
    }

    /**
     * Gets the value of the modTimeFrom property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getModTimeFrom() {
        return modTimeFrom;
    }

    /**
     * Sets the value of the modTimeFrom property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setModTimeFrom(XMLGregorianCalendar value) {
        this.modTimeFrom = value;
    }

    /**
     * Gets the value of the modTimeTo property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getModTimeTo() {
        return modTimeTo;
    }

    /**
     * Sets the value of the modTimeTo property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setModTimeTo(XMLGregorianCalendar value) {
        this.modTimeTo = value;
    }

    /**
     * Gets the value of the includeFinalValueFee property.
     * 
     * @return
     *     possible object is
     *     {@link Boolean }
     *     
     */
    public Boolean isIncludeFinalValueFee() {
        return includeFinalValueFee;
    }

    /**
     * Sets the value of the includeFinalValueFee property.
     * 
     * @param value
     *     allowed object is
     *     {@link Boolean }
     *     
     */
    public void setIncludeFinalValueFee(Boolean value) {
        this.includeFinalValueFee = value;
    }

    /**
     * Gets the value of the listingType property.
     * 
     * @return
     *     possible object is
     *     {@link ListingType }
     *     
     */
    public ListingType getListingType() {
        return listingType;
    }

    /**
     * Sets the value of the listingType property.
     * 
     * @param value
     *     allowed object is
     *     {@link ListingType }
     *     
     */
    public void setListingType(ListingType value) {
        this.listingType = value;
    }

    /**
     * Gets the value of the orderStatus property.
     * 
     * @return
     *     possible object is
     *     {@link OrderStatusTypes }
     *     
     */
    public OrderStatusTypes getOrderStatus() {
        return orderStatus;
    }

    /**
     * Sets the value of the orderStatus property.
     * 
     * @param value
     *     allowed object is
     *     {@link OrderStatusTypes }
     *     
     */
    public void setOrderStatus(OrderStatusTypes value) {
        this.orderStatus = value;
    }

    /**
     * Gets the value of the version property.
     * 
     */
    public int getVersion() {
        return version;
    }

    /**
     * Sets the value of the version property.
     * 
     */
    public void setVersion(int value) {
        this.version = value;
    }

}
