
package com.ebay.marketplace.services;

import java.util.ArrayList;
import java.util.List;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlAnyElement;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;
import org.w3c.dom.Element;


/**
 * 
 * 			Type defining the <b>soldReportFilter</b> container, which allows the user to control whether (and when) the buyers' shipping addresses are returned in Merchant Data's <b>SoldReport</b> response. 
 * 			<br/><br/>
 * 			The <b>soldReportFilter</b> container is only applicable if the <b>downloadJobType</b> value is set to 'SoldReport'. 
 * 		
 * 
 * <p>Java class for SoldReportFilter complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="SoldReportFilter">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="includeShippingAddress" type="{http://www.ebay.com/marketplace/services}IncludeShippingAddressType"/>
 *         &lt;any processContents='lax' maxOccurs="unbounded" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "SoldReportFilter", propOrder = {
    "includeShippingAddress",
    "any"
})
public class SoldReportFilter {

    @XmlElement(required = true)
    protected IncludeShippingAddressType includeShippingAddress;
    @XmlAnyElement(lax = true)
    protected List<Object> any;

    /**
     * Gets the value of the includeShippingAddress property.
     * 
     * @return
     *     possible object is
     *     {@link IncludeShippingAddressType }
     *     
     */
    public IncludeShippingAddressType getIncludeShippingAddress() {
        return includeShippingAddress;
    }

    /**
     * Sets the value of the includeShippingAddress property.
     * 
     * @param value
     *     allowed object is
     *     {@link IncludeShippingAddressType }
     *     
     */
    public void setIncludeShippingAddress(IncludeShippingAddressType value) {
        this.includeShippingAddress = value;
    }

    /**
     * Gets the value of the any property.
     * 
     * <p>
     * This accessor method returns a reference to the live list,
     * not a snapshot. Therefore any modification you make to the
     * returned list will be present inside the JAXB object.
     * This is why there is not a <CODE>set</CODE> method for the any property.
     * 
     * <p>
     * For example, to add a new item, do as follows:
     * <pre>
     *    getAny().add(newItem);
     * </pre>
     * 
     * 
     * <p>
     * Objects of the following type(s) are allowed in the list
     * {@link Element }
     * {@link Object }
     * 
     * 
     */
    public List<Object> getAny() {
        if (any == null) {
            any = new ArrayList<Object>();
        }
        return this.any;
    }

}
