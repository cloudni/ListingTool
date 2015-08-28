
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * 
 * 			Creates a recurring Bulk Data Exchange job for different LMS Reports and assigns it a <b 
 * 			class="con">recurringJobId</b>.
 * 			When you create a recurring job, you must specify a recurrence interval, such
 * 			as daily, weekly, monthly, or a frequency in minutes.
 * 			<br><br>
 * 			Once a recurring job has been created, a separate job ID is created for each
 * 			job that is created/executed. For example, if a job runs every hour, it will
 * 			have a single <b class="con">recurringJobId</b> and each hourly job 
 * 			will have a unique <b class="con">jobId</b> and <b 
 * 			class="con">fileReferenceI</b>d.
 * 		
 * 
 * <p>Java class for DownloadJobRecurringFilter complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="DownloadJobRecurringFilter">
 *   &lt;complexContent>
 *     &lt;extension base="{http://www.ebay.com/marketplace/services}BaseServiceRequest">
 *       &lt;sequence>
 *         &lt;element name="orderReportRecurringFilter" type="{http://www.ebay.com/marketplace/services}OrderReportRecurringFilter" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/extension>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "DownloadJobRecurringFilter", propOrder = {
    "orderReportRecurringFilter"
})
public class DownloadJobRecurringFilter
    extends BaseServiceRequest
{

    protected OrderReportRecurringFilter orderReportRecurringFilter;

    /**
     * Gets the value of the orderReportRecurringFilter property.
     * 
     * @return
     *     possible object is
     *     {@link OrderReportRecurringFilter }
     *     
     */
    public OrderReportRecurringFilter getOrderReportRecurringFilter() {
        return orderReportRecurringFilter;
    }

    /**
     * Sets the value of the orderReportRecurringFilter property.
     * 
     * @param value
     *     allowed object is
     *     {@link OrderReportRecurringFilter }
     *     
     */
    public void setOrderReportRecurringFilter(OrderReportRecurringFilter value) {
        this.orderReportRecurringFilter = value;
    }

}
