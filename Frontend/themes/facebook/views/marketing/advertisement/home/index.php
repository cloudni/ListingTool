<?php
/* @var $this HomeController */

$this->breadcrumbs=array(
    'Marketing',
    'Advertisement'
);
?>

<style>
    .sumDiv{
        float: left; width: 19%; padding-left: 3px;
    }

    .sumDivBorderLeft{
        border-left: 1px solid #d2d3d6;
    }

    .sumDivFontBold{
        font-size: 14px; font-weight: bold;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #fff; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #000; font-weight: normal;">
                    <div class="clearfix">
                        <div class="sumDiv">Clicks</div>
                        <div class="sumDiv sumDivBorderLeft">Impr.</div>
                        <div class="sumDiv sumDivBorderLeft">CTR</div>
                        <div class="sumDiv sumDivBorderLeft">Avg. CPC</div>
                        <div class="sumDiv sumDivBorderLeft">Cost</div>
                    </div>
                    <div class="clearfix">
                        <div class="sumDiv sumDivFontBold">20</div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold">13,456</div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold">1.02%</div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold">$0.45</div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold">$99.00</div>
                    </div>
                </div>
            </div>
            <div>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="position: relative; float: right; top: 5px;">
                <a style="color: #3b5998; font-size: 14px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign");?>">See All</a>
            </div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px; padding: 12px 12px 0px 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <select>
                        <option value="all">All Campaigns</option>
                        <option>Woman Cloth Campaign</option>
                        <option>Pet Supplies Campaign</option>
                        <option>Housing Campaign</option>
                    </select>
                    <div style="display: inline-block; width: 10px; height: 10px; background-color: #058dc7; position: relative; left: 80px; z-index: 1;"></div>
                    <select style="width: 100px;">
                        <option>Clicks</option>
                        <option>Impr.</option>
                        <option>CTR</option>
                        <option>Avg. CPC</option>
                        <option>Avg. CPM</option>
                        <option>Cost</option>
                        <option>Avg. Pos</option>
                    </select>
                    <span>VS.</span>
                    <select style="width: 100px;">
                        <option>Clicks</option>
                        <option>Impr.</option>
                        <option selected>CTR</option>
                        <option>Avg. CPC</option>
                        <option>Avg. CPM</option>
                        <option>Cost</option>
                        <option>Avg. Pos</option>
                    </select>
                    <div style="display: inline-block; width: 10px; height: 10px; background-color: #ed7e17; position: relative; left: -37px; z-index: 1;"></div>
                    <select>
                        <option>Daily</option>
                        <option>Weekly</option>
                        <option>Monthly</option>
                        <option>Quarterly</option>
                    </select>
                </div>
            </div>
            <div>
                <?php
                Yii::import('application.vendor.pChart.*');
                require_once("pChart/pData.class");
                require_once("pChart/pChart.class");
                $mainFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
                $fontFolder = $mainFolder . "protected" . DIRECTORY_SEPARATOR . "vendor" .DIRECTORY_SEPARATOR . "pChart" .DIRECTORY_SEPARATOR . "Fonts";

                // Dataset definition
                $DataSet = new pData;
                //图表数据
                $DataSet->AddPoint(array(1,4,-3,2,-3,3,2,1,0,7,4),"Serie1");
                $DataSet->AddPoint(array(3,3,-4,1,-2,2,1,0,-1,6,3),"Serie2");
                $DataSet->AddPoint(array(4,1,2,-1,-4,-2,3,2,1,2,2),"Serie3");
                $DataSet->AddAllSeries();
                $DataSet->SetAbsciseLabelSerie();
                //数据图例
                $DataSet->SetSerieName("Microsoft","Serie1");
                $DataSet->SetSerieName("IBM","Serie2");
                $DataSet->SetSerieName("Google","Serie3");

                // Initialise the graph
                $Test = new pChart(988,230);
                //设置图表尺寸、样式
                $Test->setFontProperties($fontFolder . DIRECTORY_SEPARATOR . "tahoma.ttf",8);
                $Test->setGraphArea(30,30,958,200);
                $Test->drawFilledRoundedRectangle(7,7,983,225,5,240,240,240);
                $Test->drawRoundedRectangle(5,5,983,225,5,230,230,230);
                $Test->drawGraphArea(255,255,255,TRUE);
                $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
                $Test->drawGrid(4,TRUE,230,230,230,50);

                // Draw the 0 line
                $Test->setFontProperties($fontFolder . DIRECTORY_SEPARATOR . "MankSans.ttf",6);
                $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

                // Draw the bar graph
                //柱状图要使用drawBarGraph()
                $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,80);


                // Finish the graph
                //制作图例、标题、字体等属性
                $Test->setFontProperties($fontFolder . DIRECTORY_SEPARATOR . "MankSans.ttf",10);
                $Test->drawLegend(596,150,$DataSet->GetDataDescription(),255,255,255);
                $Test->setFontProperties($fontFolder . DIRECTORY_SEPARATOR . "MankSans.ttf",10);
                $Test->drawTitle(50,22,"Performance Graph",50,50,50,585);

                //生成图表
                $imageFile = '1428505639.png';//time().".png";
                $path = $mainFolder . "tmp" . DIRECTORY_SEPARATOR;
                //$Test->Render($path . $imageFile);
                echo '<img src="/tmp/'.$imageFile.'">';
                ?>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">All Enabled AD Campaigns</h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left">Campaign</th>
                    <th align="left">Status</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Avg. CPM</th>
                    <th align="right">Cost</th>
                    <th align="right">Budget</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="#">Campaign #1</a></td>
                        <td>Eligible</td>
                        <td>100</td>
                        <td>13,491</td>
                        <td>1.23%</td>
                        <td>$0.42</td>
                        <td>$0.23</td>
                        <td>$50.00</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td><a href="#">Campaign #2</a></td>
                        <td>Paused</td>
                        <td>66</td>
                        <td>8,914</td>
                        <td>2.45%</td>
                        <td>$0.71</td>
                        <td>$0.34</td>
                        <td>$60.00</td>
                        <td>$60.00</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">All Enabled AD Groups</h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left">Ad Group</th>
                    <th align="left">Status</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Avg. CPM</th>
                    <th align="right">Cost</th>
                    <th align="right">Avg. Pos</th>
                    <th align="right">Max. CPC</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="#">AD Group #1</a></td>
                        <td>Eligible</td>
                        <td>166</td>
                        <td>3,459</td>
                        <td>3.2%</td>
                        <td>$1.02</td>
                        <td>$0.56</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    <tr>
                        <td><a href="#">AD Group #2</a></td>
                        <td>Paused</td>
                        <td>48</td>
                        <td>9,845</td>
                        <td>0.25%</td>
                        <td>$0.26</td>
                        <td>$2.5</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    <tr>
                        <td><a href="#">AD Group #3</a></td>
                        <td>Eligible</td>
                        <td>49</td>
                        <td>6,128</td>
                        <td>2.89%</td>
                        <td>$2.5</td>
                        <td>$2.5</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">All Enabled Keywords</h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left">Ad Group</th>
                    <th align="left">Status</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Avg. CPM</th>
                    <th align="right">Cost</th>
                    <th align="right">Avg. Pos</th>
                    <th align="right">Max. CPC</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="#">AD Group #1</a></td>
                        <td>Eligible</td>
                        <td>166</td>
                        <td>3,459</td>
                        <td>3.2%</td>
                        <td>$1.02</td>
                        <td>$0.56</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    <tr>
                        <td><a href="#">AD Group #2</a></td>
                        <td>Paused</td>
                        <td>48</td>
                        <td>9,845</td>
                        <td>0.25%</td>
                        <td>$0.26</td>
                        <td>$2.5</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    <tr>
                        <td><a href="#">AD Group #3</a></td>
                        <td>Eligible</td>
                        <td>49</td>
                        <td>6,128</td>
                        <td>2.89%</td>
                        <td>$2.5</td>
                        <td>$2.5</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">Good Quality But Law Traffic Keywords</h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left">Ad Group</th>
                    <th align="left">Status</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Avg. CPM</th>
                    <th align="right">Cost</th>
                    <th align="right">Avg. Pos</th>
                    <th align="right">Max. CPC</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="#">AD Group #1</a></td>
                        <td>Eligible</td>
                        <td>166</td>
                        <td>3,459</td>
                        <td>3.2%</td>
                        <td>$1.02</td>
                        <td>$0.56</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    <tr>
                        <td><a href="#">AD Group #2</a></td>
                        <td>Paused</td>
                        <td>48</td>
                        <td>9,845</td>
                        <td>0.25%</td>
                        <td>$0.26</td>
                        <td>$2.5</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    <tr>
                        <td><a href="#">AD Group #3</a></td>
                        <td>Eligible</td>
                        <td>49</td>
                        <td>6,128</td>
                        <td>2.89%</td>
                        <td>$2.5</td>
                        <td>$2.5</td>
                        <td>$20.00</td>
                        <td>1.0</td>
                        <td>$1.0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>