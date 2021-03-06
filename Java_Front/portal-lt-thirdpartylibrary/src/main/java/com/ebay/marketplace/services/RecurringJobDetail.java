
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlSchemaType;
import javax.xml.bind.annotation.XmlType;
import javax.xml.bind.annotation.adapters.CollapsedStringAdapter;
import javax.xml.bind.annotation.adapters.XmlJavaTypeAdapter;
import javax.xml.datatype.XMLGregorianCalendar;


/**
 * 
 * 			Type defining the <b>recurringJobDetail</b> container that is returned for each recurring job defined for the seller. The <b>recurringJobDetail</b> container consists of a unique identifier for the recurring job, the current status of the recurring job ('Active' or 'Suspended), the frequency of the recurring job (daily, weekly, monthly), and the download job type.
 * 		
 * 
 * <p>Java class for RecurringJobDetail complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="RecurringJobDetail">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="recurringJobId" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         &lt;element name="creationTime" type="{http://www.w3.org/2001/XMLSchema}dateTime"/>
 *         &lt;element name="frequencyInMinutes" type="{http://www.w3.org/2001/XMLSchema}int" minOccurs="0"/>
 *         &lt;element name="downloadJobType" type="{http://www.w3.org/2001/XMLSchema}token"/>
 *         &lt;element name="jobStatus" type="{http://www.ebay.com/marketplace/services}RecurringJobStatus"/>
 *         &lt;element name="monthlyRecurrence" type="{http://www.ebay.com/marketplace/services}MonthlyRecurrence" minOccurs="0"/>
 *         &lt;element name="weeklyRecurrence" type="{http://www.ebay.com/marketplace/services}WeeklyRecurrence" minOccurs="0"/>
 *         &lt;element name="dailyRecurrence" type="{http://www.ebay.com/marketplace/services}DailyRecurrence" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "RecurringJobDetail", propOrder = {
    "recurringJobId",
    "creationTime",
    "frequencyInMinutes",
    "downloadJobType",
    "jobStatus",
    "monthlyRecurrence",
    "weeklyRecurrence",
    "dailyRecurrence"
})
public class RecurringJobDetail {

    @XmlElement(required = true)
    protected String recurringJobId;
    @XmlElement(required = true)
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar creationTime;
    protected Integer frequencyInMinutes;
    @XmlElement(required = true)
    @XmlJavaTypeAdapter(CollapsedStringAdapter.class)
    @XmlSchemaType(name = "token")
    protected String downloadJobType;
    @XmlElement(required = true)
    protected RecurringJobStatus jobStatus;
    protected MonthlyRecurrence monthlyRecurrence;
    protected WeeklyRecurrence weeklyRecurrence;
    protected DailyRecurrence dailyRecurrence;

    /**
     * Gets the value of the recurringJobId property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getRecurringJobId() {
        return recurringJobId;
    }

    /**
     * Sets the value of the recurringJobId property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setRecurringJobId(String value) {
        this.recurringJobId = value;
    }

    /**
     * Gets the value of the creationTime property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getCreationTime() {
        return creationTime;
    }

    /**
     * Sets the value of the creationTime property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setCreationTime(XMLGregorianCalendar value) {
        this.creationTime = value;
    }

    /**
     * Gets the value of the frequencyInMinutes property.
     * 
     * @return
     *     possible object is
     *     {@link Integer }
     *     
     */
    public Integer getFrequencyInMinutes() {
        return frequencyInMinutes;
    }

    /**
     * Sets the value of the frequencyInMinutes property.
     * 
     * @param value
     *     allowed object is
     *     {@link Integer }
     *     
     */
    public void setFrequencyInMinutes(Integer value) {
        this.frequencyInMinutes = value;
    }

    /**
     * Gets the value of the downloadJobType property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getDownloadJobType() {
        return downloadJobType;
    }

    /**
     * Sets the value of the downloadJobType property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setDownloadJobType(String value) {
        this.downloadJobType = value;
    }

    /**
     * Gets the value of the jobStatus property.
     * 
     * @return
     *     possible object is
     *     {@link RecurringJobStatus }
     *     
     */
    public RecurringJobStatus getJobStatus() {
        return jobStatus;
    }

    /**
     * Sets the value of the jobStatus property.
     * 
     * @param value
     *     allowed object is
     *     {@link RecurringJobStatus }
     *     
     */
    public void setJobStatus(RecurringJobStatus value) {
        this.jobStatus = value;
    }

    /**
     * Gets the value of the monthlyRecurrence property.
     * 
     * @return
     *     possible object is
     *     {@link MonthlyRecurrence }
     *     
     */
    public MonthlyRecurrence getMonthlyRecurrence() {
        return monthlyRecurrence;
    }

    /**
     * Sets the value of the monthlyRecurrence property.
     * 
     * @param value
     *     allowed object is
     *     {@link MonthlyRecurrence }
     *     
     */
    public void setMonthlyRecurrence(MonthlyRecurrence value) {
        this.monthlyRecurrence = value;
    }

    /**
     * Gets the value of the weeklyRecurrence property.
     * 
     * @return
     *     possible object is
     *     {@link WeeklyRecurrence }
     *     
     */
    public WeeklyRecurrence getWeeklyRecurrence() {
        return weeklyRecurrence;
    }

    /**
     * Sets the value of the weeklyRecurrence property.
     * 
     * @param value
     *     allowed object is
     *     {@link WeeklyRecurrence }
     *     
     */
    public void setWeeklyRecurrence(WeeklyRecurrence value) {
        this.weeklyRecurrence = value;
    }

    /**
     * Gets the value of the dailyRecurrence property.
     * 
     * @return
     *     possible object is
     *     {@link DailyRecurrence }
     *     
     */
    public DailyRecurrence getDailyRecurrence() {
        return dailyRecurrence;
    }

    /**
     * Sets the value of the dailyRecurrence property.
     * 
     * @param value
     *     allowed object is
     *     {@link DailyRecurrence }
     *     
     */
    public void setDailyRecurrence(DailyRecurrence value) {
        this.dailyRecurrence = value;
    }

}
