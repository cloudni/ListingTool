
package com.ebay.marketplace.services;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlType;


/**
 * 
 * 			Type defining the root container of the <b>abortRecurringJobExecution</b> response. The response includes the standard output fields like <b>ack</b>, <b>timestamp</b>, <b>version</b>, and any errors/warnings that are generated by the request to abort the next scheduled recurring job. The <b>ack</b> values of 'Success' or 'Failure' will indicate whether or not the next scheduled recurring job was successfully aborted.
 * 			<br><br>
 * 			To remove a recurring job completely, use <b>deleteRecurringJob</b>. Use
 * 			<b>getRecurringJobExecutionStatus</b> to see the last completed instance of a recurring job.
 * 		
 * 
 * <p>Java class for AbortRecurringJobExecutionResponse complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="AbortRecurringJobExecutionResponse">
 *   &lt;complexContent>
 *     &lt;extension base="{http://www.ebay.com/marketplace/services}BaseServiceResponse">
 *       &lt;sequence>
 *       &lt;/sequence>
 *     &lt;/extension>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "AbortRecurringJobExecutionResponse")
public class AbortRecurringJobExecutionResponse
    extends BaseServiceResponse
{


}