<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>
<%@ include file="/common/taglibs.jsp"%>
<!DOCTYPE HTML>
<html><head>
<%@ include file="/common/meta.jsp"%>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide{display:none !important;}ng\:form{display:block;}.ng-animate-block-transitions{transition:0s all!important;-webkit-transition:0s all!important;}.ng-hide-add-active,.ng-hide-remove{display:block!important;}</style>
  <link rel="stylesheet" href="common_styles_v2.css">
  <link rel="stylesheet" href="Hotel_MultiItem_ImageFill_01_common.css">
  <style>
    .layout,
    .content {
      height: 250px;
      width: 300px;
    }

    .headline {
      font-size: 18px;
      height: 32px;
      margin: 0 auto;
      padding: 2px 0;
      text-align: center;
      width: 240px;
    }

    .carousel-bg {
      height: 146px;
      width: 100%;
    }

    .carousel-bg.no-title {
      height: 178px;
      padding-top: 30px;
    }

    .products {
      height: 100%;
      margin: 0 auto;
      width: 250px;
    }

    .product {
      float: left;
      height: 100%;
      width: 50%;
    }

    .product-content {
      margin: 0 auto;
      overflow: hidden;
      text-align: center;
      width: 86%;
    }

    .product-price > div {
      width: 52px;
    }

    .img-btn {
      border: 3px solid rgba(255, 255, 255, .9);
      -webkit-border-radius: 3px;
      border-radius: 3px;
      height: 103px;
      width: 100%;
    }

    .productImage {
      height: 68px;
      position: relative;
      width: 100%;
    }

    .actions {
      height: 29px;
      width: 100%;
    }

    .details {
      height: 30px;
      width: 100%;
    }

    .productName > div,
    .productPrice > div {
      height: 100%;
      width: 100%;
    }

    .productName > div {
      padding-bottom: 2px;
    }

    .arrow {
      top: 95px;
    }

    .arrow.right {
      right: 3px;
    }

    .arrow.left {
      left: 2px;
    }

    .carousel-wrapper {
      height: 100%;
    }

    .footer {
      height: 70px;
      text-align: center;
      width: 100%;
    }

    .logo {
      height: 100%;
      width: 100%;
    }

    .logo-wrapper {
      height: 66px;
      margin: 2px auto;
      width: 75%;
    }

    .logo-wrapper.w-disclaimer {
      height: 53px;
    }

    .carousel-item {
      width: 100%;
    }

    .disclaimer {
      bottom: 1px;
      height: 13px;
      margin: 0 38px;
      position: absolute;
      text-align: center;
      width: 224px;
    }

    .button {
      height: 29px;
      width: 100%;
    }

    .productName {
      line-height: normal;
    }

    .details > div.productName {
      height: 16px;
    }
  </style>
<style>
  .layout {
    background: #ffffff;
    border: 1px solid #cbcbcb;
  }

  .carousel-bg {
    background: #e6e6e6;
    border-bottom: rgb(138,138,138) 3px solid;
  }

  .productName {
    color: #4d4d4d;
    font-size: 18px;
  }

  .product-price-value {
    color: #0073ed;
    font-size: 24px;
  }

  .product-price-prefix {
    color: #0073ed;
    font-size: 12px;
  }

  .headline {
    color: #4d4d4d;
    font-size: 18px;
  }
</style>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript">
	$.ready(function(){
		//preview();
	});
	/* var style = {"headlineText" : "abc", "headlineColor" : "", "headlineBackgroundColor" : "", "headlineSize" : "14"
				, "pricePrefixText" : "", "pricePrefixColor" : "", "pricePrefixSize" : "14"
				, "buttonCaption" : "", "bottonCaptionColor" : "", "bottonColor" : ""}; */
	function preview(style) {
		var style = window.parent.alert(1);
		//alert(window.location.search);		
		//var style = (window.location.search.substr(7));
		$("#headlineText").html(style.headlineText);
		$("#summaryText1").html(style.summaryText1);
		$("#priceText1").html(style.priceText1);
		$("#buttonCaption1").html(style.buttonCaption);
		$("#summaryText2").html(style.summaryText2);
		$("#priceText1").html(style.priceText2);
		$("#buttonCaption2").html(style.buttonCaption);
		
		$("#headlineText").attr("color",style.headlineColor).attr("backgroundcolor",style.headlineBackgroundColor).attr("font-size",style.headlineSize);
		
		$("#summaryText2").html(style.summaryText2);
		$("#priceText1").html(style.priceText2);
		
	}
</script>
</head>
<body onload="" ng-controller="layoutUtils.LayoutController" class="ng-scope">
			<input type="button" value="preview" onclick="preview();">
<div dynamic-style="" style="display:none" class="ng-binding"></div>
<div arrow="" class="arrow right" ng-show="products.length > 2"><canvas width="10" height="16" style="position: absolute; left: 5px; top: 12px; opacity: 0.9;"></canvas></div>
<div arrow="" class="arrow left" ng-show="products.length > 2"><canvas width="10" height="16" style="position: absolute; left: 5px; top: 12px; opacity: 0.9;"></canvas></div>
<div id="ad-container" class="layout square" field-reference="Product_1_url">
  <div class="content" ng-init="maxItems=2;maxLists=3;productLists = buildProductLists(maxItems, maxLists)">
    <div class="headline ng-binding inline-wrapper" ext-text-fit="" minfontsize="11" multiline="false" truncate="true" ng-bind="headline.txt" ng-show="!isEmpty(headline.txt)" valign="middle" style="overflow: hidden; white-space: nowrap;">
    	<span id="headlineText" style="font-size: 18px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">Headline text</span>
    </div>
    <div class="carousel-bg" carousel-bg="" ng-class="{'no-title':isEmpty(headline.txt)}">
      <div class="carousel-wrapper" carousel="" total="productLists.length" timer="5500" duration="25000">
        <div class="carousel transition fast" style="width: 1510px; left: 0px;">
          <div class="carousel-item" style="width: 300px;">
            <div class="products clearfix">
              <!-- ngRepeat: product in productLists[productLists.length - 1] | limitTo: maxItems --><div class="product ng-scope" ng-repeat="product in productLists[productLists.length - 1] | limitTo: maxItems">
                <div class="product-content" data-interaction="urlchange" data-product-index="4">
                  <div class="details">
                    <div class="productName" ng-class="{'no-price':!toBoolean(headline.showPrice) || isEmpty(product.price)}" ng-show="!isEmpty(product.name)">
                      <div uniform-text-size="" class="product-name ng-binding ng-isolate-scope inline-wrapper" ext-text-fit="" minfontsize="9" multiline="true" truncate="true" ng-bind="product.name" valign="bottom" style="overflow: hidden; font-size: 12px;">
                      	<span id="summaryText1" style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: bottom; width: 100%;">Summary</span>
                      </div>
                    </div>
                    <div class="product-price not-alone" ng-show="toBoolean(headline.showPrice) &amp;&amp; !isEmpty(product.price)" ng-class="{'not-alone':!isEmpty(product.name)}">
                      <div uniform-text-size="" class="product-price-prefix ng-binding ng-isolate-scope inline-wrapper" ng-bind="headline.pricePrefix" ng-show="!isEmpty(headline.pricePrefix)" ext-text-fit="" minfontsize="9" multiline="false" truncate="true" valign="middle" title="as low as" style="overflow: hidden; white-space: nowrap; font-size: 12px;">
                      	<span id="prefixPriceText1" style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">as lowâ¦</span>
                      </div>
                      <div uniform-text-size="" class="product-price-value ng-binding ng-isolate-scope inline-wrapper" ext-text-fit="" minfontsize="9" multiline="false" truncate="true" valign="middle" ng-bind="product.price" ng-class="{'no-prefix':isEmpty(headline.pricePrefix)}" title="Sale price" style="overflow: hidden; white-space: nowrap; font-size: 12px;">
                      	<span id="priceText1" style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">Saleâ¦</span>
                      </div>
                    </div>
                  </div>
                  <div class="img-btn">
                    <div>
                      <div id="imageUrl1" class="productImage" observed-image-fit="" data-loc="product.imageUrl" scaletype="fill" aligntype="left" ng-class="{'no-btn':isEmpty(headline.cta)}" style="overflow: hidden;"><img src="https://tpc.googlesyndication.com/pageadimg/imgad?id=CICAgKCNv8zMrwEQrAIY-gEoATIITMxFTlMmKfQ" width="102" height="85" style="position: inherit; left: 0px; top: -8.5px;"></div>
                      <div class="actions" ng-show="!isEmpty(headline.cta)">
                        <span cta="" class="button inline-wrapper" minfontsize="11" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; padding: 0px;">
                        	<div class="cta-bg" style="width: 101.5px; height: 29px; position: absolute; border-bottom-color: rgb(0, 69, 142); border-bottom-width: 3px; border-bottom-style: solid; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; background: rgb(0, 115, 237);"></div>
                        	<div class="cta-bg" style="width: 101.5px; height: 29px; position: absolute; border-bottom-color: rgb(0, 41, 73); border-bottom-width: 3px; border-bottom-style: solid; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; display: none; background: rgb(0, 68, 121);"></div>
                        	<span id="buttonCaption1" style="font-size: 15px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%; color: rgb(255, 255, 255); position: relative; text-shadow: rgb(0, 69, 142) 0px 1px 0px;">Shop now!</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- end ngRepeat: product in productLists[productLists.length - 1] | limitTo: maxItems --><div class="product ng-scope" ng-repeat="product in productLists[productLists.length - 1] | limitTo: maxItems">
                <div class="product-content" data-interaction="urlchange" data-product-index="5">
                  <div class="details">
                    <div class="productName" ng-class="{'no-price':!toBoolean(headline.showPrice) || isEmpty(product.price)}" ng-show="!isEmpty(product.name)">
                      <div uniform-text-size="" class="product-name ng-binding ng-isolate-scope inline-wrapper" ext-text-fit="" minfontsize="9" multiline="true" truncate="true" ng-bind="product.name" valign="bottom" style="overflow: hidden; font-size: 12px;"><span style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: bottom; width: 100%;">Summary</span></div>
                    </div>
                    <div class="product-price not-alone" ng-show="toBoolean(headline.showPrice) &amp;&amp; !isEmpty(product.price)" ng-class="{'not-alone':!isEmpty(product.name)}">
                      <div uniform-text-size="" class="product-price-prefix ng-binding ng-isolate-scope inline-wrapper" ng-bind="headline.pricePrefix" ng-show="!isEmpty(headline.pricePrefix)" ext-text-fit="" minfontsize="9" multiline="false" truncate="true" valign="middle" title="as low as" style="overflow: hidden; white-space: nowrap; font-size: 12px;"><span style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">as lowâ¦</span></div>
                      <div uniform-text-size="" class="product-price-value ng-binding ng-isolate-scope inline-wrapper" ext-text-fit="" minfontsize="9" multiline="false" truncate="true" valign="middle" ng-bind="product.price" ng-class="{'no-prefix':isEmpty(headline.pricePrefix)}" title="Sale price" style="overflow: hidden; white-space: nowrap; font-size: 12px;"><span style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">Saleâ¦</span></div>
                    </div>
                  </div>
                  <div class="img-btn">
                    <div>
                      <div class="productImage" observed-image-fit="" data-loc="product.imageUrl" scaletype="fill" aligntype="left" ng-class="{'no-btn':isEmpty(headline.cta)}" style="overflow: hidden;"><img src="https://tpc.googlesyndication.com/pageadimg/imgad?id=CICAgKCNv8zMrwEQrAIY-gEoATIITMxFTlMmKfQ" width="102" height="85" style="position: inherit; left: 0px; top: -8.5px;"></div>
                      <div class="actions" ng-show="!isEmpty(headline.cta)">
                        <span cta="" class="button inline-wrapper" minfontsize="11" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; padding: 0px;"><div class="cta-bg" style="width: 101.5px; height: 29px; position: absolute; border-bottom-color: rgb(0, 69, 142); border-bottom-width: 3px; border-bottom-style: solid; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; background: rgb(0, 115, 237);"></div><div class="cta-bg" style="width: 101.5px; height: 29px; position: absolute; border-bottom-color: rgb(0, 41, 73); border-bottom-width: 3px; border-bottom-style: solid; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; display: none; background: rgb(0, 68, 121);"></div><span style="font-size: 15px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%; color: rgb(255, 255, 255); position: relative; text-shadow: rgb(0, 69, 142) 0px 1px 0px;">Shop now!111</span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- end ngRepeat: product in productLists[productLists.length - 1] | limitTo: maxItems -->
            </div>
          </div>
          <!-- ngRepeat: list in productLists | limitTo: maxLists --><!-- end ngRepeat: list in productLists | limitTo: maxLists --><!-- end ngRepeat: list in productLists | limitTo: maxLists -->
          
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="logo-wrapper w-disclaimer" ng-show="checkUrl(design.logoImageUrl)" ng-class="{'w-disclaimer': !isEmpty(headline.disclaimer)}" style="padding: 2px;">
        <div class="logo inline-wrapper" logo-fit="" loc="design.logoImageUrl" scaletype="fit" aligntype="left" style="overflow: hidden;"><img src="https://tpc.googlesyndication.com/pageadimg/imgad?id=CICAgKDjpfCijwEQyAEYSigBMgjpNhWiSu1oeA" width="132" height="49" style="position: inherit; left: 0px; top: 0px;"></div>
      </div>
      <div class="disclaimer ng-binding" ng-bind="headline.disclaimer" ext-text-fit="" minfontsize="8" multiline="false" truncate="true" title="Disclaimer" style="overflow: hidden; white-space: nowrap; font-size: 8px;"><span style="font-size: 8px; overflow: inherit; text-overflow: clip; white-space: inherit;">Disclaimerâ¦</span></div>
    </div>
  </div>
</div>


</body></html>