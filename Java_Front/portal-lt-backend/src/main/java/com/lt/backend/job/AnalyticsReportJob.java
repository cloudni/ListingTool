/*
 * Copyright (c) 2012 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */
package com.lt.backend.job;

import java.io.IOException;
import java.io.InputStreamReader;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;

import org.apache.log4j.Logger;
import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.springframework.scheduling.quartz.QuartzJobBean;

import com.google.api.client.auth.oauth2.Credential;
import com.google.api.client.extensions.java6.auth.oauth2.AuthorizationCodeInstalledApp;
import com.google.api.client.extensions.jetty.auth.oauth2.LocalServerReceiver;
import com.google.api.client.googleapis.auth.oauth2.GoogleAuthorizationCodeFlow;
import com.google.api.client.googleapis.auth.oauth2.GoogleClientSecrets;
import com.google.api.client.googleapis.javanet.GoogleNetHttpTransport;
import com.google.api.client.googleapis.json.GoogleJsonResponseException;
import com.google.api.client.http.HttpTransport;
import com.google.api.client.json.JsonFactory;
import com.google.api.client.json.jackson2.JacksonFactory;
import com.google.api.client.util.store.DataStoreFactory;
import com.google.api.client.util.store.FileDataStoreFactory;
import com.google.api.services.analytics.Analytics;
import com.google.api.services.analytics.AnalyticsScopes;
import com.google.api.services.analytics.model.GaData;
import com.google.api.services.analytics.model.GaData.ColumnHeaders;
import com.google.api.services.analytics.model.GaData.ProfileInfo;
import com.google.api.services.analytics.model.GaData.Query;
import com.google.gson.Gson;
import com.lt.dao.model.GoogleAnalyticsReportAudienceOverview;
import com.lt.dao.model.GoogleAnalyticsReportPagePath;
import com.lt.platform.util.config.PropertiesUtil;
import com.lt.platform.util.http.HttpClientUtil;
import com.lt.platform.util.security.MD5Util;
import com.lt.platform.util.time.DateFormatUtil;

/**
 * This application demonstrates how to use the Google Analytics Java client library to access all
 * the pieces of data returned by the Google Analytics Core Reporting API v3.
 *
 * <p>
 * To run this, you must supply your Google Analytics TABLE ID. Read the Core Reporting API
 * developer guide to learn how to get this value.
 * </p>
 *
 * @author api.nickm@gmail.com
 */
public class AnalyticsReportJob extends QuartzJobBean {

    private static Logger log = Logger.getLogger(AnalyticsReportJob.class);
    private static final String ANALYTICS_URL = "http://transaction.itemtool.com/portal-lt-backend/common/analytics/";

  /**
   * Be sure to specify the name of your application. If the application name is {@code null} or
   * blank, the application will log a warning. Suggested format is "MyCompany-ProductName/1.0".
   */
  private static final String APPLICATION_NAME = "Itemtool GA/1.0";

  /**
   * Used to identify from which reporting profile to retrieve data. Format is ga:xxx where xxx is
   * your profile ID.
   */
  private static final String TABLE_ID = "ga:104556957";
  private static final Map<String, String> tableMap = new HashMap<String, String>();;

  /** Directory to store user credentials. */
  private static final java.io.File DATA_STORE_DIR =
      new java.io.File(System.getProperty("user.home"), ".store/analytics_sample");

  /**
   * Global instance of the {@link DataStoreFactory}. The best practice is to make it a single
   * globally shared instance across your application.
   */
  private static FileDataStoreFactory DATA_STORE_FACTORY;

  /** Global instance of the HTTP transport. */
  private static HttpTransport HTTP_TRANSPORT;

  /** Global instance of the JSON factory. */
  private static final JsonFactory JSON_FACTORY = new JacksonFactory();
  
  static {
      /*104556957 ebay us noblestyle2014
      104559753   ebay us Beads_lover888
      106917523   ebay us jewelryfindingshop
      106904294   ebay us e-vanc74
      104554960   ebay uk artistexhibition
      104564653   ebay uk wellhonyes
      104743691   ebay us Jewelryfindingshop*/
      tableMap.put("104556957", "View_ID:104556957 View_Name:ebay us noblestyle2014");
      tableMap.put("104559753", "View_ID:104559753 View_Name:ebay us Beads_lover888");
      tableMap.put("106917523", "View_ID:106917523 View_Name:ebay us jewelryfindingshop");
      tableMap.put("106904294", "View_ID:106904294 View_Name:ebay us e-vanc74");
      tableMap.put("104554960", "View_ID:104554960 View_Name:ebay uk artistexhibition");
      tableMap.put("104564653", "View_ID:104556957 View_Name:ebay uk wellhonyes");
      tableMap.put("104743691", "View_ID:104743691 View_Name:ebay us Jewelryfindingshop");
      
  }

  @Override
  protected void executeInternal(JobExecutionContext context) throws JobExecutionException {

      try {
          log.info("analytics job start!");
        HTTP_TRANSPORT = GoogleNetHttpTransport.newTrustedTransport();
        DATA_STORE_FACTORY = new FileDataStoreFactory(DATA_STORE_DIR);
        Analytics analytics = initializeAnalytics();
        Calendar cal = Calendar.getInstance();
        cal.add(Calendar.DATE, -3);
        String date = DateFormatUtil.convertDateToStr(cal.getTime(), "yyyy-MM-dd");
            downloadAudienceOverview(analytics, date);
            downloadPage(analytics, date);
        cal.add(Calendar.DATE, 1);
        date = DateFormatUtil.convertDateToStr(cal.getTime(), "yyyy-MM-dd");
            downloadAudienceOverview(analytics, date);
            downloadPage(analytics, date);
        cal.add(Calendar.DATE, 1);
        date = DateFormatUtil.convertDateToStr(cal.getTime(), "yyyy-MM-dd");
            downloadAudienceOverview(analytics, date);
            downloadPage(analytics, date);
        
      } catch (GoogleJsonResponseException e) {
        log.error("There was a service error: " + e.getDetails().getCode() + " : "
            + e.getDetails().getMessage());
      } catch (Throwable t) {
        t.printStackTrace();
      } finally {
          log.info("analytics job end!");
      }
  }
  
  /**
   * Main demo. This first initializes an Analytics service object. It then queries for the top 25
   * organic search keywords and traffic sources by visits. Finally each important part of the
   * response is printed to the screen.
   *
   * @param args command line args.
   */
  public static void main(String[] args) {
    try {
      HTTP_TRANSPORT = GoogleNetHttpTransport.newTrustedTransport();
      DATA_STORE_FACTORY = new FileDataStoreFactory(DATA_STORE_DIR);
      Analytics analytics = initializeAnalytics();
      for (int i = 20150810; i <= 20150827; i++) {
          String day = i + "";
          //executeDataQuery(analytics, TABLE_ID, date.substring(0,4) + "-" + date.substring(4,6) + "-" + date.substring(6,8));
          String date = day.substring(0,4) + "-" + day.substring(4,6) + "-" + day.substring(6,8);
          downloadAudienceOverview(analytics, date);
          downloadPage(analytics, date);
          
      }

//      GaData gaData = executeDataQuery(analytics, TABLE_ID);
//      printReportInfo(gaData);
//      printProfileInfo(gaData);
//      printQueryInfo(gaData);
//      printPaginationInfo(gaData);
//      printTotalsForAllResults(gaData);
//      printColumnHeaders(gaData);
//      printDataTable(gaData);

    } catch (GoogleJsonResponseException e) {
      System.err.println("There was a service error: " + e.getDetails().getCode() + " : "
          + e.getDetails().getMessage());
    } catch (Throwable t) {
      t.printStackTrace();
    }
  }

  /** Authorizes the installed application to access user's protected data. */
  private static Credential authorize() throws Exception {
    // load client secrets
    GoogleClientSecrets clientSecrets = GoogleClientSecrets.load(
        JSON_FACTORY, new InputStreamReader(
                AnalyticsReportJob.class.getResourceAsStream("/client_secrets.json")));
    if (clientSecrets.getDetails().getClientId().startsWith("Enter")
        || clientSecrets.getDetails().getClientSecret().startsWith("Enter ")) {
      System.out.println(
          "Enter Client ID and Secret from https://code.google.com/apis/console/?api=analytics "
          + "into analytics-cmdline-sample/src/main/resources/client_secrets.json");
      System.exit(1);
    }
    // set up authorization code flow
    GoogleAuthorizationCodeFlow flow = new GoogleAuthorizationCodeFlow.Builder(
        HTTP_TRANSPORT, JSON_FACTORY, clientSecrets,
        Collections.singleton(AnalyticsScopes.ANALYTICS_READONLY)).setDataStoreFactory(
        DATA_STORE_FACTORY).build();
    // authorize
    return new AuthorizationCodeInstalledApp(flow, new LocalServerReceiver()).authorize("user");
  }

  /**
   * Performs all necessary setup steps for running requests against the API.
   *
   * @return an initialized Analytics service object.
   *
   * @throws Exception if an issue occurs with OAuth2Native authorize.
   */
  private static Analytics initializeAnalytics() throws Exception {
    // Authorization.
    Credential credential = authorize();

    // Set up and return Google Analytics API client.
    return new Analytics.Builder(HTTP_TRANSPORT, JSON_FACTORY, credential).setApplicationName(
        APPLICATION_NAME).build();
  }

  /**
   * Returns the top 25 organic search keywords and traffic sources by visits. The Core Reporting
   * API is used to retrieve this data.
   *
   * @param analytics the Analytics service object used to access the API.
   * @param tableId the table ID from which to retrieve data.
   * @return the response from the API.
   * @throws IOException if an API error occured.
   */
  private static GaData executeDataQuery(Analytics analytics, String tableId, String date) throws IOException {
      log.info(String.format("Analytics report download %s start!", date));
      GaData gaData = analytics.data().ga().get(tableId, // Table Id.
              date, // Start date.
              date, // End date.
        "ga:visits") // Metrics.
        //.setDimensions("ga:source,ga:keyword")
        //.setDimensions("ga:country")
        .setMetrics("ga:sessions,ga:users,ga:pageviews,ga:pageviewsPerSession,ga:avgSessionDuration,ga:bounceRate,ga:percentNewSessions")
        //.setSort("-ga:visits,ga:source")
        //.setFilters("ga:medium==organic")
        .setMaxResults(300)
        .execute();

        List<GoogleAnalyticsReportAudienceOverview> list = new ArrayList<GoogleAnalyticsReportAudienceOverview>();
        GoogleAnalyticsReportAudienceOverview ao = null;
        if (gaData.getTotalResults() > 0) {
            for (List<String> row : gaData.getRows())
            {
                ao = new GoogleAnalyticsReportAudienceOverview();
                ao.setSessions(Integer.parseInt(row.get(0)));
                ao.setUsers(Integer.parseInt(row.get(1)));
                ao.setPageviews(Integer.parseInt(row.get(2)));
                ao.setPageviewsPerSession(new BigDecimal(row.get(3)));
                ao.setAvgSessionDuration(new BigDecimal(row.get(4)));
                ao.setBounceRate(new BigDecimal(row.get(4)));
                ao.setPercentNewSessions(new BigDecimal(row.get(6)));
                ao.setDate(DateFormatUtil.convertStrToDate(date, "yyyy-MM-dd"));
                list.add(ao);
                /*for (String value : row)
                {
                    System.out.format("%-32s", value);
                }
                System.out.println();*/
            }
            String url = ANALYTICS_URL + "downloadAnalyticsReportAudienceOverview.shtml";
            Gson gson = new Gson();
            String para = gson.toJson(list);
            Map<String, String> map = new HashMap<String, String>();
            map.put("json", para);
            map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
            HttpClientUtil.post(url, map);
        }
        log.info(String.format("Analytics report download %s end, data size:%d,", date ,list.size()));
        
        return gaData;
  }
  
  public static void downloadAudienceOverview(Analytics analytics, String date) throws IOException {
      List<GoogleAnalyticsReportAudienceOverview> list = new ArrayList<GoogleAnalyticsReportAudienceOverview>();
      for (Entry<String, String> table : tableMap.entrySet()) {
          String tableId = table.getKey();
          log.info(String.format("Analytics report downloadAudienceOverview %s account: %s start!", date, tableId));
          
          GaData gaData = analytics.data().ga().get("ga:" + tableId, // Table Id.
                  date, // Start date.
                  date, // End date.
            "ga:visits") // Metrics.
            .setMetrics("ga:sessions,ga:users,ga:pageviews,ga:pageviewsPerSession,ga:avgSessionDuration,ga:bounceRate,ga:percentNewSessions")
            .setMaxResults(300)
            .execute();
    
            GoogleAnalyticsReportAudienceOverview ao = null;
            if (gaData.getTotalResults() > 0) {
                for (List<String> row : gaData.getRows())
                {
                    ao = new GoogleAnalyticsReportAudienceOverview();
                    ao.setSessions(Integer.parseInt(row.get(0)));
                    ao.setUsers(Integer.parseInt(row.get(1)));
                    ao.setPageviews(Integer.parseInt(row.get(2)));
                    ao.setPageviewsPerSession(new BigDecimal(row.get(3)));
                    ao.setAvgSessionDuration(new BigDecimal(row.get(4)));
                    ao.setBounceRate(new BigDecimal(row.get(5)));
                    ao.setPercentNewSessions(new BigDecimal(row.get(6)));
                    ao.setDate(DateFormatUtil.convertStrToDate(date, "yyyy-MM-dd"));
                    list.add(ao);
                    /*for (String value : row)
                    {
                        System.out.format("%-32s", value);
                    }
                    System.out.println();*/
                }
            }
        }
      
        if (list.size() > 0) {
            String url = ANALYTICS_URL + "downloadAnalyticsReportAudienceOverview.shtml";
            Gson gson = new Gson();
            String para = gson.toJson(list);
            Map<String, String> map = new HashMap<String, String>();
            map.put("json", para);
            map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
            HttpClientUtil.post(url, map);
        }
        log.info(String.format("Analytics report download %s end, data size:%d,", date, list.size()));
    }
  
  public static void downloadPage(Analytics analytics, String date) throws IOException {
      List<GoogleAnalyticsReportPagePath> list = new ArrayList<GoogleAnalyticsReportPagePath>();
      for (Entry<String, String> table : tableMap.entrySet()) {
          String tableId = table.getKey();
          log.info(String.format("Analytics report downloadPage %s account: %s start!", date, tableId));
          GaData gaData = analytics.data().ga().get("ga:" + tableId, // Table Id.
                  date, // Start date.
                  date, // End date.
              "ga:visits") // Metrics.
              //.setDimensions("ga:source,ga:keyword")
              .setDimensions("ga:pagePath")
              //.setMetrics("ga:sessions,ga:bounceRate,ga:sessionDuration,ga:pageviews,ga:pageviewsPerSession,ga:avgSessionDuration,ga:percentNewSessions")
              .setMetrics("ga:sessions,ga:bounceRate,ga:sessionDuration,ga:pageviewsPerSession,ga:avgTimeOnPage,ga:uniquePageviews,ga:entrances,ga:pageviews,ga:exits,ga:avgSessionDuration")
              //.setSort("-ga:visits,ga:source")
              //.setFilters("ga:medium==organic")
              //.setMaxResults(300)
              .execute();
          GoogleAnalyticsReportPagePath pp = null;
          if (gaData.getTotalResults() > 0) {
              for (List<String> row : gaData.getRows())
              {
                  pp = new GoogleAnalyticsReportPagePath();
                  pp.setPage(row.get(0).toString());
                  pp.setProperty(tableMap.get(tableId));
                  pp.setSessions(Integer.parseInt(row.get(1)));
                  pp.setBounceRate(new BigDecimal(row.get(2)));
                  pp.setSessionDuration(new BigDecimal(row.get(3)));
                  pp.setPageviewsPerSession(new BigDecimal(row.get(4)));
                  pp.setAvgTimeOnPage(new BigDecimal(row.get(5)));
                  pp.setUniquePageviews(Integer.parseInt(row.get(6)));
                  pp.setEntrances(Integer.parseInt(row.get(7)));
                  pp.setEntrances(Integer.parseInt(row.get(8)));
                  pp.setExits(Integer.parseInt(row.get(9)));
                  pp.setAvgSessionDuration(new BigDecimal(row.get(10)));
                  pp.setDate(DateFormatUtil.convertStrToDate(date, "yyyy-MM-dd"));
                  list.add(pp);
                  /*for (String value : row)
                  {
                      System.out.format("%-32s", value);
                  }
                  System.out.println();*/
              }
          }
      }
          

      if (list.size() > 0) {
          String url = ANALYTICS_URL + "downloadAnalyticsReportPagePath.shtml";
          Gson gson = new Gson();
          String para = gson.toJson(list);
          Map<String, String> map = new HashMap<String, String>();
          map.put("json", para);
          map.put("key", MD5Util.md5(PropertiesUtil.getContextProperty("remote.key").toString()));
          HttpClientUtil.post(url, map);
      }
      log.info(String.format("Analytics report downloadPage %s end, data size:%d,", date ,list.size()));
   }

  /**
   * Prints general information about this report.
   *
   * @param gaData the data returned from the API.
   */
  public static void printReportInfo(GaData gaData) {
    System.out.println();
    System.out.println("Response:");
    System.out.println("ID:" + gaData.getId());
    System.out.println("Self link: " + gaData.getSelfLink());
    System.out.println("Kind: " + gaData.getKind());
    System.out.println("Contains Sampled Data: " + gaData.getContainsSampledData());
  }

  /**
   * Prints general information about the profile from which this report was accessed.
   *
   * @param gaData the data returned from the API.
   */
  public static void printProfileInfo(GaData gaData) {
    ProfileInfo profileInfo = gaData.getProfileInfo();

    System.out.println("Profile Info");
    System.out.println("Account ID: " + profileInfo.getAccountId());
    System.out.println("Web Property ID: " + profileInfo.getWebPropertyId());
    System.out.println("Internal Web Property ID: " + profileInfo.getInternalWebPropertyId());
    System.out.println("Profile ID: " + profileInfo.getProfileId());
    System.out.println("Profile Name: " + profileInfo.getProfileName());
    System.out.println("Table ID: " + profileInfo.getTableId());
  }

  /**
   * Prints the values of all the parameters that were used to query the API.
   *
   * @param gaData the data returned from the API.
   */
  public static void printQueryInfo(GaData gaData) {
    Query query = gaData.getQuery();

    System.out.println("Query Info:");
    System.out.println("Ids: " + query.getIds());
    System.out.println("Start Date: " + query.getStartDate());
    System.out.println("End Date: " + query.getEndDate());
    System.out.println("Metrics: " + query.getMetrics()); // List
    System.out.println("Dimensions: " + query.getDimensions()); // List
    System.out.println("Sort: " + query.getSort()); // List
    System.out.println("Segment: " + query.getSegment());
    System.out.println("Filters: " + query.getFilters());
    System.out.println("Start Index: " + query.getStartIndex());
    System.out.println("Max Results: " + query.getMaxResults());
  }

  /**
   * Prints common pagination information.
   *
   * @param gaData the data returned from the API.
   */
  public static void printPaginationInfo(GaData gaData) {
    System.out.println("Pagination Info:");
    System.out.println("Previous Link: " + gaData.getPreviousLink());
    System.out.println("Next Link: " + gaData.getNextLink());
    System.out.println("Items Per Page: " + gaData.getItemsPerPage());
    System.out.println("Total Results: " + gaData.getTotalResults());
  }

  /**
   * Prints the total metric value for all rows the query matched.
   *
   * @param gaData the data returned from the API.
   */
  public static void printTotalsForAllResults(GaData gaData) {
    System.out.println("Metric totals over all results:");
    Map<String, String> totalsMap = gaData.getTotalsForAllResults();
    for (Map.Entry<String, String> entry : totalsMap.entrySet()) {
      System.out.println(entry.getKey() + " : " + entry.getValue());
    }
  }

  /**
   * Prints the information for each column. The reporting data from the API is returned as rows of
   * data. The column headers describe the names and types of each column in rows.
   *
   * @param gaData the data returned from the API.
   */
  public static void printColumnHeaders(GaData gaData) {
    System.out.println("Column Headers:");

    for (ColumnHeaders header : gaData.getColumnHeaders()) {
      System.out.println("Column Name: " + header.getName());
      System.out.println("Column Type: " + header.getColumnType());
      System.out.println("Column Data Type: " + header.getDataType());
    }
  }

  /**
   * Prints all the rows of data returned by the API.
   *
   * @param gaData the data returned from the API.
   */
  public static void printDataTable(GaData gaData) {
    if (gaData.getTotalResults() > 0) {
      System.out.println("Data Table:");

      // Print the column names.
      for (ColumnHeaders header : gaData.getColumnHeaders()) {
        System.out.format("%-32s", header.getName());
      }
      System.out.println();

      // Print the rows of data.
      for (List<String> rowValues : gaData.getRows()) {
        for (String value : rowValues) {
          System.out.format("%-32s", value);
        }
        System.out.println();
      }
    } else {
      System.out.println("No data");
    }
  }
}
