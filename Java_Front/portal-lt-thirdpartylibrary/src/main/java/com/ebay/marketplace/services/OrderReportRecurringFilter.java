
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * 
 * 			Creates a recurring Bulk Data Exchange job for Order Report and assigns it a <b 
 * 			class="con">recurringJobId</b>.
 * 			When creating a recurring job for OrderReport, you must specify the version,
 * 			you must specify a recurrence interval, such
 * 			as daily, weekly, monthly, or a frequency in minutes.
 * 			You may specify the listingType as 'Half' else by default only 'ebay' orders are returned.
 * 			You may specify the createTimeRange or modTimeRange to sepcify the time range for which orders will be returned 
 * 			createTimeRange if provided with modTimeRnage then createTimeRange takes precedence and modTimeRange is ignored.
 * 			else the default range is 30 days from the job start time.
 * 			Be dafault, Orders returned will have includeFinalValueFee = false and all orders with orderStatus = completed, cancelled, active and shipped
 * 			will be returned.
 * 			<br><br>
 * 			Once a recurring job has been created, a separate job ID is created for each
 * 			job that is created/executed. For example, if a job runs every hour, it will
 * 			have a single <b class="con">recurringJobId</b> and each hourly job 
 * 			will have a unique <b class="con">jobId</b> and <b 
 * 			class="con">fileReferenceI</b>d.
 * 		
 * 
 * <p>Java class for OrderReportRecurringFilter complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="OrderReportRecurringFilter">
 *   &lt;complexContent>
 *     &lt;extension base="{http://www.ebay.com/marketplace/services}BaseServiceRequest">
 *       &lt;sequence>
 *         &lt;element name="createTimeRange" type="{http://www.w3.org/2001/XMLSchema}int" minOccurs="0"/>
 *         &lt;element name="modTimeRange" type="{http://www.w3.org/2001/XMLSchema}int" minOccurs="0"/>
 *         &lt;element name="listingType" type="{http://www.ebay.com/marketplace/services}ListingType" minOccurs="0"/>
 *         &lt;element name="version" type="{http://www.w3.org/2001/XMLSchema}int"/>
 *       &lt;/sequence>
 *     &lt;/extension>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "OrderReportRecurringFilter", propOrder = {
    "createTimeRange",
    "modTimeRange",
    "listingType",
    "version"
})
public class OrderReportRecurringFilter
    extends BaseServiceRequest
{

    protected Integer createTimeRange;
    protected Integer modTimeRange;
    protected ListingType listingType;
    protected int version;

    /**
     * Gets the value of the createTimeRange property.
     * 
     * @return
     *     possible object is
     *     {@link Integer }
     *     
     */
    public Integer getCreateTimeRange() {
        return createTimeRange;
    }

    /**
     * Sets the value of the createTimeRange property.
     * 
     * @param value
     *     allowed object is
     *     {@link Integer }
     *     
     */
    public void setCreateTimeRange(Integer value) {
        this.createTimeRange = value;
    }

    /**
     * Gets the value of the modTimeRange property.
     * 
     * @return
     *     possible object is
     *     {@link Integer }
     *     
     */
    public Integer getModTimeRange() {
        return modTimeRange;
    }

    /**
     * Sets the value of the modTimeRange property.
     * 
     * @param value
     *     allowed object is
     *     {@link Integer }
     *     
     */
    public void setModTimeRange(Integer value) {
        this.modTimeRange = value;
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
