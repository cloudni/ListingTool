
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * 
 * 			Type defining the <b>downloadRequestFilter</b> container, which is parent container of any and all filters used in the <b>startDownloadJob</b> request.
 * 		
 * 
 * <p>Java class for DownloadRequestFilter complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="DownloadRequestFilter">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="feeSettlementReportFilter" type="{http://www.ebay.com/marketplace/services}FeeSettlementReportFilter" minOccurs="0"/>
 *         &lt;element name="getItemInfoReportFilter" type="{http://www.ebay.com/marketplace/services}GetItemInfoReportFilter" minOccurs="0"/>
 *         &lt;element name="siteFilter" type="{http://www.ebay.com/marketplace/services}SiteFilter" minOccurs="0"/>
 *         &lt;element name="activeInventoryReportFilter" type="{http://www.ebay.com/marketplace/services}ActiveInventoryReportFilter" minOccurs="0"/>
 *         &lt;element name="dateFilter" type="{http://www.ebay.com/marketplace/services}DateFilter" minOccurs="0"/>
 *         &lt;element name="soldReportFilter" type="{http://www.ebay.com/marketplace/services}SoldReportFilter" minOccurs="0"/>
 *         &lt;element name="orderReportFilter" type="{http://www.ebay.com/marketplace/services}OrderReportFilter" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "DownloadRequestFilter", propOrder = {
    "feeSettlementReportFilter",
    "getItemInfoReportFilter",
    "siteFilter",
    "activeInventoryReportFilter",
    "dateFilter",
    "soldReportFilter",
    "orderReportFilter"
})
public class DownloadRequestFilter {

    protected FeeSettlementReportFilter feeSettlementReportFilter;
    protected GetItemInfoReportFilter getItemInfoReportFilter;
    protected SiteFilter siteFilter;
    protected ActiveInventoryReportFilter activeInventoryReportFilter;
    protected DateFilter dateFilter;
    protected SoldReportFilter soldReportFilter;
    protected OrderReportFilter orderReportFilter;

    /**
     * Gets the value of the feeSettlementReportFilter property.
     * 
     * @return
     *     possible object is
     *     {@link FeeSettlementReportFilter }
     *     
     */
    public FeeSettlementReportFilter getFeeSettlementReportFilter() {
        return feeSettlementReportFilter;
    }

    /**
     * Sets the value of the feeSettlementReportFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link FeeSettlementReportFilter }
     *     
     */
    public void setFeeSettlementReportFilter(FeeSettlementReportFilter value) {
        this.feeSettlementReportFilter = value;
    }

    /**
     * Gets the value of the getItemInfoReportFilter property.
     * 
     * @return
     *     possible object is
     *     {@link GetItemInfoReportFilter }
     *     
     */
    public GetItemInfoReportFilter getGetItemInfoReportFilter() {
        return getItemInfoReportFilter;
    }

    /**
     * Sets the value of the getItemInfoReportFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link GetItemInfoReportFilter }
     *     
     */
    public void setGetItemInfoReportFilter(GetItemInfoReportFilter value) {
        this.getItemInfoReportFilter = value;
    }

    /**
     * Gets the value of the siteFilter property.
     * 
     * @return
     *     possible object is
     *     {@link SiteFilter }
     *     
     */
    public SiteFilter getSiteFilter() {
        return siteFilter;
    }

    /**
     * Sets the value of the siteFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link SiteFilter }
     *     
     */
    public void setSiteFilter(SiteFilter value) {
        this.siteFilter = value;
    }

    /**
     * Gets the value of the activeInventoryReportFilter property.
     * 
     * @return
     *     possible object is
     *     {@link ActiveInventoryReportFilter }
     *     
     */
    public ActiveInventoryReportFilter getActiveInventoryReportFilter() {
        return activeInventoryReportFilter;
    }

    /**
     * Sets the value of the activeInventoryReportFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link ActiveInventoryReportFilter }
     *     
     */
    public void setActiveInventoryReportFilter(ActiveInventoryReportFilter value) {
        this.activeInventoryReportFilter = value;
    }

    /**
     * Gets the value of the dateFilter property.
     * 
     * @return
     *     possible object is
     *     {@link DateFilter }
     *     
     */
    public DateFilter getDateFilter() {
        return dateFilter;
    }

    /**
     * Sets the value of the dateFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link DateFilter }
     *     
     */
    public void setDateFilter(DateFilter value) {
        this.dateFilter = value;
    }

    /**
     * Gets the value of the soldReportFilter property.
     * 
     * @return
     *     possible object is
     *     {@link SoldReportFilter }
     *     
     */
    public SoldReportFilter getSoldReportFilter() {
        return soldReportFilter;
    }

    /**
     * Sets the value of the soldReportFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link SoldReportFilter }
     *     
     */
    public void setSoldReportFilter(SoldReportFilter value) {
        this.soldReportFilter = value;
    }

    /**
     * Gets the value of the orderReportFilter property.
     * 
     * @return
     *     possible object is
     *     {@link OrderReportFilter }
     *     
     */
    public OrderReportFilter getOrderReportFilter() {
        return orderReportFilter;
    }

    /**
     * Sets the value of the orderReportFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link OrderReportFilter }
     *     
     */
    public void setOrderReportFilter(OrderReportFilter value) {
        this.orderReportFilter = value;
    }

}
