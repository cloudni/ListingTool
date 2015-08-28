
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
 * 			Type defining the <b>jobProfile</b> container that is returned in Bulk Data Exchange API's "get" calls. The <b>jobProfile</b> container consists of unique identifiers for a job, as well as data that indicates the current status of the job.
 * 			<br><br>
 * 			The job profile returns data about the state of the Bulk Data Exchange job, but does not return information about the status of the processing for any data file that is sent with the job request or returned with the job response.
 * 		
 * 
 * <p>Java class for JobProfile complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="JobProfile">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="jobId" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         &lt;element name="jobType" type="{http://www.w3.org/2001/XMLSchema}token"/>
 *         &lt;element name="jobStatus" type="{http://www.ebay.com/marketplace/services}JobStatus"/>
 *         &lt;element name="creationTime" type="{http://www.w3.org/2001/XMLSchema}dateTime"/>
 *         &lt;element name="completionTime" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         &lt;element name="errorCount" type="{http://www.w3.org/2001/XMLSchema}int" minOccurs="0"/>
 *         &lt;element name="percentComplete" type="{http://www.w3.org/2001/XMLSchema}double" minOccurs="0"/>
 *         &lt;element name="fileReferenceId" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         &lt;element name="inputFileReferenceId" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         &lt;element name="startTime" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "JobProfile", propOrder = {
    "jobId",
    "jobType",
    "jobStatus",
    "creationTime",
    "completionTime",
    "errorCount",
    "percentComplete",
    "fileReferenceId",
    "inputFileReferenceId",
    "startTime"
})
public class JobProfile {

    @XmlElement(required = true)
    protected String jobId;
    @XmlElement(required = true)
    @XmlJavaTypeAdapter(CollapsedStringAdapter.class)
    @XmlSchemaType(name = "token")
    protected String jobType;
    @XmlElement(required = true)
    protected JobStatus jobStatus;
    @XmlElement(required = true)
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar creationTime;
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar completionTime;
    protected Integer errorCount;
    protected Double percentComplete;
    protected String fileReferenceId;
    protected String inputFileReferenceId;
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar startTime;

    /**
     * Gets the value of the jobId property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getJobId() {
        return jobId;
    }

    /**
     * Sets the value of the jobId property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setJobId(String value) {
        this.jobId = value;
    }

    /**
     * Gets the value of the jobType property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getJobType() {
        return jobType;
    }

    /**
     * Sets the value of the jobType property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setJobType(String value) {
        this.jobType = value;
    }

    /**
     * Gets the value of the jobStatus property.
     * 
     * @return
     *     possible object is
     *     {@link JobStatus }
     *     
     */
    public JobStatus getJobStatus() {
        return jobStatus;
    }

    /**
     * Sets the value of the jobStatus property.
     * 
     * @param value
     *     allowed object is
     *     {@link JobStatus }
     *     
     */
    public void setJobStatus(JobStatus value) {
        this.jobStatus = value;
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
     * Gets the value of the completionTime property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getCompletionTime() {
        return completionTime;
    }

    /**
     * Sets the value of the completionTime property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setCompletionTime(XMLGregorianCalendar value) {
        this.completionTime = value;
    }

    /**
     * Gets the value of the errorCount property.
     * 
     * @return
     *     possible object is
     *     {@link Integer }
     *     
     */
    public Integer getErrorCount() {
        return errorCount;
    }

    /**
     * Sets the value of the errorCount property.
     * 
     * @param value
     *     allowed object is
     *     {@link Integer }
     *     
     */
    public void setErrorCount(Integer value) {
        this.errorCount = value;
    }

    /**
     * Gets the value of the percentComplete property.
     * 
     * @return
     *     possible object is
     *     {@link Double }
     *     
     */
    public Double getPercentComplete() {
        return percentComplete;
    }

    /**
     * Sets the value of the percentComplete property.
     * 
     * @param value
     *     allowed object is
     *     {@link Double }
     *     
     */
    public void setPercentComplete(Double value) {
        this.percentComplete = value;
    }

    /**
     * Gets the value of the fileReferenceId property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getFileReferenceId() {
        return fileReferenceId;
    }

    /**
     * Sets the value of the fileReferenceId property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setFileReferenceId(String value) {
        this.fileReferenceId = value;
    }

    /**
     * Gets the value of the inputFileReferenceId property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getInputFileReferenceId() {
        return inputFileReferenceId;
    }

    /**
     * Sets the value of the inputFileReferenceId property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setInputFileReferenceId(String value) {
        this.inputFileReferenceId = value;
    }

    /**
     * Gets the value of the startTime property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getStartTime() {
        return startTime;
    }

    /**
     * Sets the value of the startTime property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setStartTime(XMLGregorianCalendar value) {
        this.startTime = value;
    }

}
