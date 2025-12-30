<?php
   /**
    * Template Name: roi_calc_pdf
    */
   
   
require get_template_directory() . '/roi_utils/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Create a new Dompdf instance
$options = new Options();

$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);

// Adjust the font directory path

$pdf = new Dompdf($options);

// Read JSON file
$jsonString = file_get_contents(get_template_directory() . '/roi_utils/data.json');
$data = json_decode($jsonString, true);

// Specify the ID you want to retrieve
$targetId = $_GET['id']; // Replace with the desired ID

// Check if the ID exists in the JSON data
if (isset($data[$targetId])) {
    $myObject = $data[$targetId];

    // Your existing code
    $N1 = 0.75;
    $N2 = 0.65;
    $N3 = 8333;
    $N4 = 20;
    $N5 = 8;
    $N6 = 0.2;
    $N7 = $N1 / 2;
    $N8 = null;
    $N9 = 10000;

    $N14 = 1500;



     
    $N8 = ($myObject['platform'] == 1) ? 0.25 : 0.70;

    $localDeveloperBuildTimeWi = $myObject['averageDeveloperFullBuild'] - ($myObject['averageDeveloperFullBuild'] * $N1);
    $centralizedBuildTimeWi = $myObject['centralizedBuildTake'] - ($myObject['centralizedBuildTake'] * $N1);

    $buildHoursSaved = (((($myObject['averageDeveloperFullBuild'] - $localDeveloperBuildTimeWi) * ($myObject['buildsDeveloperRun'] * $N4)) * $myObject['numOfDevs']) / 60) + (($myObject['centralizedBuildTake'] - $centralizedBuildTimeWi) * ($myObject['CIBuildsPerDay'] * $N4 * $myObject['numOfDevs'])) / 60;

    $monthlyDeveloperHoursSaved = round($buildHoursSaved * $N2);
    $annualDevelopersCostSaving = round($monthlyDeveloperHoursSaved * ($N3 / $N4 / $N5));

    $potentialIncreaseInCIBuildFrequency = round(($myObject['CIBuildsPerDay'] / 100) * (($N1 * 100) - ($N1 * $myObject['increasedTestingPercent'])));
    $fasterBrokenBuildResolutionTime = round((((($myObject['CIBuildsPerDay'] * 240) / 100) * $myObject['fullBuildsBreak']) * ((($myObject['numOfDevs'] / 100) * $myObject['teamParticipatesResolving'])) * $myObject['timePerDeveloperToResolve']) / 60 * 0.5);
    $fasterBrokenBuildResolutionValue = round($fasterBrokenBuildResolutionTime * ($N3 / $N4 / $N5));
    $moreTimeForTesting = round(($monthlyDeveloperHoursSaved / 100) * $myObject['increasedTestingPercent']);
    $moreTestingCostSaving = round(((($myObject['productionDefects'] / 100) * ($myObject['increasedTestingPercent'] * 0.66))) * $N9);
    $fasterCriticalBugFixInAnnualValue = (($myObject['criticalBugs'] * $myObject['costOf24HourDelay']) * $N1);
    $moreFrequentReleasePotential = round(($myObject['releasesPerYear'] / 100) * (($N1 * 100) - ($N1 * $myObject['increasedTestingPercent'])));
    $annualInfraCostSavings = (($myObject['onpremInfraCost'] * $N1) * 0.5);
    $annualCloudCostSavings = (($myObject['softwareDevelopmentCloudSpending'] / 2) * $N8);
    $totalCostSavingWi = $annualDevelopersCostSaving + $fasterBrokenBuildResolutionValue + $moreTestingCostSaving + $annualInfraCostSavings + $annualCloudCostSavings + $fasterCriticalBugFixInAnnualValue;
    $monthsToROI = (((($myObject['numOfDevs'] * $N14)/ $totalCostSavingWi) * 12)  ); 
    $monthsToROIMax = $monthsToROI * 1.2;
    $monthsToROIMin = $monthsToROI * 0.8;


    $wrcexpValu = "on every commit";
    if ($centralizedBuildTimeWi < 15) {
        $wrcexpValu = "on every commit";
    }
    if ($centralizedBuildTimeWi < 300) {
        $wrcexpValu = "At night and during<br/>the day";
    }
    if ($centralizedBuildTimeWi > 300) {
        $wrcexpValu = "At night";
    }
    if ($myObject['assessment'] === "basic") {
        $extraTd ='<td style="width:236px;">
        Faster broken build<br/>resolution in annual hours
        <span class="bold greenColorFont">'.number_format($fasterBrokenBuildResolutionTime).' hours</span>
     </td>';     
 $calcdet = '<div class="page">
 <div class="datawrap" >
    <table class="data1" cellspacing="0" border="0">
       <tr>
          <td colspan="2" style="padding:0 13px;"> 
             <span class="h2">Calculation assumptions</span>
          </td>
          <td  colspan="2"> 
          </td>
       </tr>
    </table>
 </div>
 <div class="datawrap" >
    <table class="data1" cellspacing="13">
       <tr>
          <td class="datatdw">
             <div>Acceleration rate</div>
             <span>75%</span>
          </td>
          <td class="datatdw">
             <div>Developer productivity savings</div>
             <span>65%</span>                        
          </td>
          <td class="datatdw">
             <div>Average Annual salary</div>
             <span>$100,000</span>                        
          </td>
          <td class="datatdw">
             <div>Workdays a month</div>
             <span>20</span>                       
          </td>
       </tr>
       <tr>
          <td class="datatdw">
             <div> Work hours a day</div>
             <span>8</span>
          </td>
          <td class="datatdw">
             <div>% of team that finds or<br/>resolves broken builds</div>
             <span>10%</span>                        
          </td>
          <td class="datatdw">
             <div>Avarage time per developer<br/>to resolve a broken build</div>
             <span>20 minutes</span>                        
          </td>
          <td class="datatdw">
             <div>Defect rate reduction due<br/>to shorter builds</div>
             <span>20%</span>                       
          </td>
       </tr>
       <tr>
          <td class="datatdw">
             <div>% of defects that are critical bugs</div>
             <span>1%</span>
          </td>
          <td class="datatdw">
             <div>% of time saved, spent on<br/>more automated testing</div>
             <span>30%</span>
          </td>
          <td class="">  </td>
          <td class=""> </td>
       </tr>
    </table>
 </div>
 <div class="datawrap" >
    <table class="data2" cellspacing="0" border="0">
       <tr>
          <td  style="padding:50px 0 0 0 ;"> 
             <span class="h2">Result calculation details:</span>
          </td>
       </tr>
       <tr>
          <td class="title">
             Monthly developer hours saved:
          </td>
       </tr>
       <tr>
          <td class="paragraph">Developer productivity gains are estimated by applying a idle developer time savings factor to time saved from reduced build durations.</td>
       </tr>
       <tr>
          <td class="title">Annual developer productivity cost saving:</td>
       </tr>
       <tr>
          <td class="paragraph">This is the value of the productivity hours saved by Incredibuild. </td>
       </tr>
       <tr>
          <td class="title">With Incredibuild you can run CI:</td>
       </tr>
       <tr>
          <td class="paragraph">Builds shorter than 15m enabe build per commit, builds above 15m and below 4h can run several times a day, builds above 4h run once a day and night and 6h long builds run nightly.
          </td>
       </tr>
       <tr>
          <td class="title">Potential Increase in daily CI build frequency:</td>
       </tr>
       <tr>
          <td class="paragraph">Time saved by accelerated builds can allow for more CI daily cycles. We omit the time you chose to spend on testing and distribute the remainder allowing for intermissions between cycles.
          </td>
       </tr>
       <tr>
          <td class="title">Faster broken build resolution in time (annual hours):</td>
       </tr>
       <tr>
          <td class="paragraph">Incredibuild cuts broken builds by 50% through faster iterations and data visualization that clearly shows where and why a build fails..
          </td>
       </tr>
       <tr>
          <td class="title">Annual cost saving due to more testing:</td>
       </tr>
       <tr>
          <td class="paragraph">Additional testing time reduces production bugs, saving costs on fixing escaped bugs.
          </td>
       </tr>
       <tr>
          <td class="title"> </td>
       </tr>
       <tr>
          <td class="paragraph">
          </td>
       </tr>
       <tr>
          <td class="title"> </td>
       </tr>
       <tr>
          <td class="paragraph"> 
          </td>
       </tr>
    </table>
 </div>
</div>';
    }
    if ($myObject['assessment'] === "extended") { 
   $extraTd ='<td style="width:236px;">
   Annual On-prem<br/> 
   infrastructure saving
   <span class="bold greenColorFont">$'.$annualInfraCostSavings.'</span>
</td>';     
 $calcdet = ' <div class="page">
 <div class="datawrap" >
    <table class="data1" cellspacing="0" border="0">
       <tr>
          <td colspan="2" style="padding:0 13px;"> 
             <span class="h2">Calculation assumptions</span>
          </td>
          <td  colspan="2"> 
          </td>
       </tr>
    </table>
 </div>
 <div class="datawrap" >
    <table class="data1" cellspacing="13">
       <tr>
          <td class="datatdw">
             <div>Acceleration rate</div>
             <span>75%</span>
          </td>
          <td class="datatdw">
             <div>Developer productivity savings</div>
             <span>65%</span>                        
          </td>
          <td class="datatdw">
             <div>Average Annual salary</div>
             <span>$100,000</span>                        
          </td>
          <td class="datatdw">
             <div>Workdays a month</div>
             <span>20</span>                       
          </td>
       </tr>
       <tr>
          <td class="datatdw">
             <div> Work hours a day</div>
             <span>8</span>
          </td>
          <td class="datatdw">
             <div>Defect rate reduction</div>
             <span>20%</span>                        
          </td>
          <td class="datatdw">
             <div>Infrastructure spend<br/>reduction</div>
             <span>Acceleration/2</span>                        
          </td>
          <td class="datatdw">
             <div>Cloud savings factor</div>
             <span>70%, 25%(Linux)</span>                       
          </td>
       </tr>
       <tr>
          <td class="datatdw">
             <div> escaped defect (bug) cost</div>
             <span>$10,000</span>
          </td>
          <td class=""> </td>
          <td class="">  </td>
          <td class=""> </td>
       </tr>
    </table>
 </div>
 <div class="datawrap" >
    <table class="data2" cellspacing="0" border="0">
       <tr>
          <td  style="padding:50px 0 0 0 ;"> 
             <span class="h2">Result calculation details:</span>
          </td>
       </tr>
       <tr>
          <td class="title">
             Monthly developer hours saved:
          </td>
       </tr>
       <tr>
          <td class="paragraph">Developer productivity gains are estimated by applying a idle developer time savings factor to time saved from reduced build durations.</td>
       </tr>
       <tr>
          <td class="title">Annual developer productivity cost saving:</td>
       </tr>
       <tr>
          <td class="paragraph">This is the value of the productivity hours saved by Incredibuild. </td>
       </tr>
       <tr>
          <td class="title">With Incredibuild you can run CI:</td>
       </tr>
       <tr>
          <td class="paragraph">Builds shorter than 15m enabe build per commit, builds above 15m and below 4h can run several times a day, builds above 4h run once a day and night and 6h long builds run nightly.
          </td>
       </tr>
       <tr>
          <td class="title">Potential Increase in daily CI build frequency:</td>
       </tr>
       <tr>
          <td class="paragraph">Time saved by accelerated builds can allow for more CI daily cycles. We omit the time you chose to spend on testing and distribute the remainder allowing for intermissions between cycles.
          </td>
       </tr>
       <tr>
          <td class="title">Faster broken build resolution in time (annual hours):</td>
       </tr>
       <tr>
          <td class="paragraph">Incredibuild cuts broken builds by 50% through faster iterations and data visualization that clearly shows where and why a build fails..
          </td>
       </tr>
       <tr>
          <td class="title">Annual cost saving due to more testing:</td>
       </tr>
       <tr>
          <td class="paragraph">Additional testing time reduces production bugs, saving costs on fixing escaped bugs.
          </td>
       </tr>
       <tr>
          <td class="title">Annual Cloud cost savings</td>
       </tr>
       <tr>
          <td class="paragraph">Cost saving due to spot utilization tailored provisioning and autoscaling and smart compatibility layer for (Windows).
          </td>
       </tr>
       <tr>
          <td class="title">Annual Infrastructure (on-prem) cost savings</td>
       </tr>
       <tr>
          <td class="paragraph">Incredibuild saves on the need for additional machines to get compute, as well as optimizing developer time both of which reduce other on prem expenditures such as rental space.
          </td>
       </tr>
    </table>
 </div>
</div>';
    }
 
// Load HTML content
$html = '
<!DOCTYPE html>
<html>
   <head>
      <style>
         @font-face {
         font-family: "Poppins";
         font-weight: normal;
         font-style: normal;
         font-variant: normal;
         src: url("/wp-content/themes/incredibuild/roi_utils/Fonts/Poppins-Regular.ttf") format("truetype");
         }
         @font-face {
         font-family: "Poppins_bold";
         font-weight: normal;
         font-style: normal;
         font-variant: normal;
         src: url("/wp-content/themes/incredibuild/roi_utils/Fonts/Poppins-Bold.ttf") format("truetype");
         }
         @font-face {
         font-family: "Poppins_medium";
         font-weight: normal;
         font-style: normal;
         font-variant: normal;
         src: url("/wp-content/themes/incredibuild/roi_utils/Fonts/Poppins-SemiBold.ttf") format("truetype");
         }
         @font-face {
         font-family: "Gordita_Bold";
         font-weight: normal;
         font-style: normal;
         font-variant: normal;
         src: url("/wp-content/themes/incredibuild/roi_utils/Fonts/Gordita_Bold.ttf") format("truetype");
         }
         @font-face {
         font-family: "Gordita";
         font-weight: normal;
         font-style: normal;
         font-variant: normal;
         src: url("/wp-content/themes/incredibuild/roi_utils/Fonts/Gordita.ttf") format("truetype");
         }
         @page                    {margin:0;}
         body                     {background: #F9F9F9;}
         div.page                 {position: absolute; top: 0px bottom: 0px; left: 0px; right: 0px; width: 100%; height: 100%; overflow: hidden; page-break-before: always; }
         div.page:first-child     {page-break-before: never; }
         .h1                      {margin-bottom: 40px;color: #171E37;font-family: "Gordita_Bold";font-size: 45px;}
         p                        {color:#000;width:459px;font-family:Poppins;font-size:13px;line-height:15px;}
         .pageLogo                {position:relative;top:400px;left:50px;}
         .mainImage               {position:relative;top:200px;left:150px;}
         .bgColorgrad             {width: 563px;height: 159px;flex-shrink: 0;opacity: 0.45;background: linear-gradient(116deg, #1EFFAE 4.14%, #4B0ECD 71.26%);filter: blur(11.500001907348633px);}
         .cntn                    {width: 552px;height: 146px;flex-shrink: 0;border-radius: 6px;background: green;opacity: 0.45;background-image: -webkit-linear-gradient(top, red 0%, blue 100%);}
         .page_1                  {width:690px;height:950px;border-radius:6px;padding:30px;box-sizing: border-box;}
         .halfpage                {background-color: #171E37 ; height:70%; position:absolute; bottom:0; left:0; width:100%;}
         .mainbg                  {position:absolute;left:150px; top:150px;}
         .bottomlogo              {position:absolute;top:715px; left:610px;}
         .bottomlogos             {position:absolute;bottom:20px; right:30px;}
         .bottomtext              {position:absolute;bottom:20px; left:30px;color: #171E37;font-family: Gordita;font-size: 9px;font-style: normal;font-weight: 400;line-height: 150%; }
         .bottomtext a            {margin-left:2px;}
         .estimations_p,.estimations_p td          {color: #171E37;font-family: Poppins; font-size: 12px;font-style: normal; font-weight: 400;line-height: 14px;}
         span.header              {display:inline-block;color: #FFF;text-align: center;font-family: Gordita;font-size: 10px;font-style: normal;font-weight: 900;line-height: 17px;}
         span.par                 {display:block;color:#FFF;font-family: Gordita;font-size: 10px;font-style: normal;font-weight: 400;line-height: 17px;}
         span.number              {display:block;color:#FFF;text-align: center;font-family: Poppins;font-size: 27px;font-style: normal;font-weight: 700;line-height: 35px;}
         span.h2                  {font-family:Poppins_bold;font-size: 23px;font-style: normal;}
         .datawrap                {width:760px;box-sizing:border-box;margin:auto;font-family:Poppins;}
         .data1                   {width:100%;font-family:Poppins;}
         .data1 td.datatd         {position:relative; border-radius: 6px;background: #222A48;height: 43px;padding:15px 10px 15px 10px;   font-family: Poppins;}
         .data1 td.datatd.basic   {background:transparent;}
         .data1 td.datatd div     {font-size: 10px;line-height:10px;position:absolute;top:3px;height:30px;color: #fff;}
         .data1 td.datatd span    {font-family: Poppins_bold;position:absolute;bottom:3px;font-size: 18px;color: #00FFA3;}
         .datatitle               {font-family: Poppins_bold;font-size:18px;line-height:13px;}
         .small                   {font-family: Poppins;font-size:10px;line-height:10px;}
         .barGrey                 {width:80%;;background-color:#CCCCCC;height:20px;border-radius:3px;}
         .barGreen                {width:50%;background-color:#00FFA3;height:20px;border-radius:3px;}
         .bgtable                 {width: 100%;padding:0px 33px;font-family: Poppins;background-repeat: no-repeat;background-position: center center;background-size: 100% 100%;background-image: url(https://www.incredibuild.com/wp-content/themes/incredibuild/roi_utils/images/page2top.png);height: 230px;color:#fff;margin-bottom:-30px;}
         .bgtable td              {position:relative;height:135px;text-align:center;font-size:13px;line-height:11px;padding-top:60px;    vertical-align: top;}
         .bgtable td  span.medium {font-family:Poppins_medium;} 
         .bgtable td  span.bold   {font-family:Poppins_bold;font-size: 27px;display:block;width:100%;position:absolute;bottom:39px;left:0;}
         .data1 td.datatdw        {background-image: url(https://www.incredibuild.com/wp-content/themes/incredibuild/roi_utils/images/boxshadow.png);position:relative; border-radius: 6px;height: 43px;color:color: #171E37;padding:15px 10px 15px 10px;   font-family: Poppins;background-repeat: no-repeat;background-position:top left;background-size: cover;}
         .data1 td.datatdw div    {font-size: 10px;line-height:10px;position:absolute;top:3px;height:30px;}
         .data1 td.datatdw span   {font-family: Poppins_bold;position:absolute;bottom:3px;font-size: 18px;}
         .title                   {padding-top:15px;font-family: Poppins_bold; font-size: 15px; font-style: normal; line-height: 15px;}
         .paragraph               {color:#171E37; font-family:Poppins; font-size: 15px; line-height: 12px;}
         .data2                   {width:730px;margin:auto;}
         .lastpage                {background-image: url(https://www.incredibuild.com/wp-content/uploads/2024/02/aboutBg.png);height: 590px;position:relative;background-color:#fff;background-repeat: no-repeat;background-position: center center;background-size:100% 100%;text-align:center;}
         .lastpage table.frst          {font-family: Poppins; font-size: 15px;color:#fff;text-align:center;width:650px;margin:auto;position:relative;top:70px;}
         .lastpage .scnd {position:relative;top:180px;}
         .concspan                {font-family:Poppins_bold;font-size: 35px;line-height: 35px;}
         .greenColorFont          {color:#00FFA3;}
         .aboutUsContaner         {background-image: url(https://www.incredibuild.com/wp-content/uploads/2024/02/aboutBg.png);color:#fff;color: #FFF;background-size: 815px 100%;font-family: Gordita;font-size: 17px;font-style: normal;font-weight: 400;line-height: 20px;background-repeat: no-repeat;background-position: center center;background-color:red;padding: 50px 50px;}
         .estimations             {color: #171E37;font-family: Gordita;font-size: 9px;font-style: normal;font-weight: 400;line-height: 16px;}
         .greenTitle     {color: #00FFA3;text-align: center;font-family: Poppins;font-size: 22px;font-style: normal;}
         div.basic,span.basic {visibility: hidden;}
         </style>
   </head>
   <body>
   
      <div class="page page_1">
         <p class="h1">ROI Report</p>
         <p>This report estimates business value calculation results based on your data combined with Incredibuild’s decades of experience in various industries. We use an assumed acceleration rate of 75%, which aligns with the industry norm of 30% to 80%. The value metrics herein are grounded in conservative industry benchmarks to ensure the reliability of our calculations. </p>
         <div class="halfpage">
            <img class="mainbg" src="https://www.incredibuild.com/wp-content/themes/incredibuild/roi_utils/images/reportbg.png"/>  
            <img class="bottomlogo" src="https://www.incredibuild.com/wp-content/themes/incredibuild/roi_utils/images/Logo_dark.png"/>
         </div>
      </div>
      <div class="page">
         <div class="datawrap" >
            <table class="data1" cellspacing="0" border="0">
               <tr>
                  <td colspan="2" style="padding:0 13px;"> 
                     <span class="h2">ROI Highlights</span>
                  </td>
                  <td  colspan="2"> 
                  </td>
               </tr>
            </table>
         </div>
         <div class="datawrap" style="  width: 794px;" >
            <table class="bgtable" border="0"  >
               <tr>
                  <td style="width:238px;">
                     <span class="medium">Acceleration</span><br/>*
                     Actual results can reach<br/>
                     90% and above
                     <span class="bold greenColorFont">75%</span>
                  </td>
                  <td style="width:240px;">
                  Annual developer time <br/> 
                     saved due to faster builds
                     <span class="bold greenColorFont">'.$monthlyDeveloperHoursSaved.' hours</span>
                  </td>
           ' . $extraTd . '
               </tr>
            </table>
         </div>
         <div class="datawrap" >
            <table class="data1" cellspacing="13">
               <tr>
                  <td colspan="2"> 
                     <span class="h2">Productivity</span>
                  </td>
                  <td  colspan="2"> 
                  </td>
               </tr>
               <tr>
                  <td class="datatd">
                     <div>Monthly build hours<br/>reduction </div>
                     <span>'. number_format($buildHoursSaved) .' hours</span>
                  </td>
                  <td class="datatd">
                     <div>Monthly developer hours<br/>saved 
                     </div>
                     <span>'.number_format($monthlyDeveloperHoursSaved).' hours</span>                        
                  </td>
                  <td class="datatd">
                     <div>Annual developer<br/>productivity cost saving</div>
                     <span>$'.number_format($annualDevelopersCostSaving).'</span>                        
                  </td>
                  <td class="datatd '. $myObject['assessment'] .'">
                     <div  class="'. $myObject['assessment'] .'">Potential number of<br/>additional annual releases</div>
                     <span  class="'. $myObject['assessment'] .'">'.$moreFrequentReleasePotential.' Releases</span>                       
                  </td>
               </tr>
               <tr>
                  <td colspan="2"> 
                     <span class="h2">Testing and Speed</span>
                  </td>
                  <td  colspan="2"> 
                  </td>
               </tr>
               <tr>
                  <td class="datatd">
                     <div>More time for testing (monthly)</div>
                     <span>'.number_format($moreTimeForTesting).' hours</span>
                  </td>
                  <td class="datatd ">
                     <div>Annual cost saving due<br/>to  more testing  </div>
                     <span>$'.number_format($moreTestingCostSaving).'</span>                        
                  </td>
                  <td class="datatd '. $myObject['assessment'] .'">
                     <div  class="'. $myObject['assessment'] .'">Annual Value of faster<br/>critical bug fixes</div>
                     <span  class="'. $myObject['assessment'] .'">$'.number_format($fasterCriticalBugFixInAnnualValue).'</span>                        
                  </td>
                  <td> </td>
               </tr>
               <tr>
                  <td colspan="2"> 
                     <span class="h2">Broken build resolution</span>
                  </td>
                  <td  colspan="2"> 
                     <span class="h2 '. $myObject['assessment'] .'">Infrastructure and Cloud</span>
                  </td>
               </tr>
               <tr>
                  <td class="datatd">
                     <div>Faster broken build resolution<br/>in time (annual hours) </div>
                     <span>'.number_format($fasterBrokenBuildResolutionTime).' hours</span>                        
                  </td>
                  <td class="datatd">
                     <div>Faster broken build<br/>resolution in annual value</div>
                     <span>$'.number_format($fasterBrokenBuildResolutionValue).'</span>                        
                  </td>
                  <td class="datatd '. $myObject['assessment'] .'">
                     <div class="'. $myObject['assessment'] .'">Annual Infrastructure<br/>(on-prem) cost savings </div>
                     <span class="'. $myObject['assessment'] .'">$'.number_format($annualInfraCostSavings).'</span>                        
                  </td>
                  <td class="datatd '. $myObject['assessment'] .'">
                     <div class="'. $myObject['assessment'] .'">Annual Cloud cost savings </div>
                     <span class="'. $myObject['assessment'] .'">$'.number_format($annualCloudCostSavings).'</span>                        
                  </td>
               </tr>
            </table>
         </div>
         <div class="datawrap" style="width:746px;height:14px;margin:auto;padding-top:20px;padding-bottom:10px;font-size: 12px;line-height: 6px;">
            <span class="box" style="display:inline-block;height:15px;width:15px;border-radius: 2px;background: #D9D9D9;margin-bottom:-3px;"> </span> Before Incredibuild &nbsp;&nbsp;&nbsp;
            <span class="box" style="display:inline-block;height:15px;width:15px;border-radius: 2px;background: #00FFA3;margin-bottom:-3px;"> </span> After Incredibuild
         </div>
         <div class="datawrap" style="border-radius: 5px; border:1px solid #ccc;width:740px;border-radius: 4.099px;margin:auto;padding:0 0;">
            <table style="width:100%;border-collapse: collapse;" border="0"  cellspacing="13">
               <tr>
                  <td style="height:120px;width:50%;">
                     <table border="0" style="width:100%;border-right:1px solid #c3c3c3;padding:20px;">
                        <tr>
                           <td colspan="2" class="datatitle">Local developer build time</td>
                        </tr>
                        <tr>
                           <td width="50" style="font-size:13px;">'. $myObject['averageDeveloperFullBuild'] .' min</td>
                           <td>
                              <div class="barGrey" style="width:100%;"> </div>
                           </td>
                        </tr>
                        <tr>
                           <td width="50" style="font-size:13px;">'. $myObject['averageDeveloperFullBuild']* 0.25 .'  min</td>
                           <td>
                              <div class="barGreen" style="width:25%;"> </div>
                           </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td style="font-size:10px;line-height:8px;border-top:1px solid rgba(0, 0, 0, 0.22);"></td>
                        </tr>
                     </table>
                  </td>
                  <td style="padding:10px;">
                     <table border="0" style="width:100%;padding:20px;">
                        <tr>
                           <td colspan="2" class="datatitle">Ci  build time </td>
                        </tr>
                        <tr>
                           <td width="50" style="font-size:13px;">'. $myObject['centralizedBuildTake'] .' min</td>
                           <td>
                              <div class="barGrey" style="width:100%;"> </div>
                           </td>
                        </tr>
                        <tr>
                           <td width="50" style="font-size:13px;">'. $myObject['centralizedBuildTake'] * 0.25 .' min</td>
                           <td>
                              <div class="barGreen" style="width:25%;"> </div>
                           </td>
                        </tr>
                        
                        <tr>
                           <td></td>
                           <td style="font-size:10px;line-height:8px; border-top:1px solid rgba(0, 0, 0, 0.22);"></td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr style="border-top:1px solid #c3c3c3;margin-top:15px;">
                  <td style="height:120px;">
                     <table border="0" style="width:100%;border-right:1px solid #c3c3c3;padding:20px;">
                        <tr>
                           <td colspan="2" class="datatitle">Potential additional CI cycles</td>
                        </tr>
                        <tr>
                           <td width="50" style="font-size:13px;">'.$myObject['CIBuildsPerDay'].'/day</td>
                           <td>
                              <div class="barGrey" style="width:'. floor($myObject['CIBuildsPerDay'] / ($myObject['CIBuildsPerDay'] + $potentialIncreaseInCIBuildFrequency) * 100 ).'%;"></div>
                           </td>
                        </tr>
                        <tr>
                           <td width="50" style="font-size:13px;">'. ($myObject['CIBuildsPerDay'] + $potentialIncreaseInCIBuildFrequency) .'/day</td>
                           <td>
                              <div class="barGreen" style="width:100%;"> </div>
                           </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td style="font-size:10px;line-height:8px; border-top:1px solid rgba(0, 0, 0, 0.22);"> </td>
                        </tr>
                     </table>
                  </td>
                  <td style="height:120px;">
                     <table style="width:100%;text-align:center;padding:20px;">
                        <tr>
                           <td class="small">With Incredibuild you can run CI </td>
                        </tr>
                        <tr>
                           <td class="datatitle">'.$wrcexpValu.'</td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </div>
      </div>
  
      '. $calcdet .'

     <!-- basic end -->
      <div class="page">
      <div class="datawrap" >
         <table class="data1" cellspacing="0" border="0">
            <tr>
               <td colspan="2" style="padding:0 13px;"> 
                  <span class="h2">Conclusion</span>
               </td>
               <td  colspan="2"> 
               </td>
            </tr>
         </table>
      </div>
   
      <div class="lastpage"  >
         <table class="frst">
            <tr>
               <td style="width:50%;font-size:11px;">
                  <img src="https://www.incredibuild.com/wp-content/themes/incredibuild/roi_utils/images/icon1.png"/><br/>
                  <span class="greenTitle">Savings</span><br/>
                  Total Cost saving with Incredibuild<br/>
                  <span class="concspan">$'.number_format($totalCostSavingWi).'</span>
               </td>
            </tr>
            <tr>
               <td style="padding-top:50px;padding-bottom:50px;">
               <hr>

               </td>
            </tr>
            <tr>
               <td style="width:50%;font-size:11px;">
                  <img src="https://www.incredibuild.com/wp-content/themes/incredibuild/roi_utils/images/icon2.png"/><br/>
                  <span class="greenTitle">ROI</span><br/>
                  Estimated time range to return on investment<br/>
                
                  <span class="concspan">Less than 5 months</span>

                  
                  

               </td>
            </tr>
         </table>
         <div class="datawrap scnd"style="padding-left:35px;" >
            <table class="estimations_p" style="width:647px;">
               <tr>
                  <td  style="border-bottom:1px solid #fff;height:10px;"></td>
               </tr>
               <tr>
                  <td  style="padding-top:10px;font-size:15px;line-height:12px;padding-bottom:30px;">For a more detailed analysis or to modify any of the assumptions in this<br/>report, an Incredibuild acceleration expert will be happy to help.</td>
               </tr>
               <tr>
                  <td>
                     In addition to historical information, this report presents forward-looking estimations, which involve risk and uncertainty because they relate to future circumstances that could cause actual results and developments to differ materially from the plans, goals and expectations comprising this report results. Any forward-looking estimate contained in this report speaks as of the date made. Incredibuild disclaims any and all liability for the information presented hereunder, and undertakes no obligation to revise or update any forward-looking estimation in light of new information or events. Any decisions made based on this report and the forward-looking estimates therein is at your own risk. Due to rounding, numbers presented may not add up precisely to the totals provided and percentages may not precisely reflect the absolute figures. This report does not guarantee actual results.
                  </td>
               </tr>
            </table>
         </div>
      </div>
      <div class="page">
         <div class="datawrap" >
            <table class="data1" cellspacing="0" border="0">
               <tr>
                  <td colspan="2" style="padding:0 13px;"> 
                     <span class="h2">About Incredibuild</span>
                  </td>
                  <td  colspan="2"> 
                  </td>
               </tr>
            </table>
         </div>
         <div class="aboutUsContaner">
            <table>
               <tr>
                  <td>Incredibuild is the leading platform for Development Acceleration.<br/>Our Virtualized Distributed Processing™ and patented Build Cache technologies help you build faster and lower development costs on-prem and in the cloud so your dev teams can iterate more, ﬁx bugs faster, and build great products. Incredibuld also helps you get more out of your current investments in hardware and optimize cloud resources to get more bang for your buck. Incredibuild doesn’t require changes to your existing tools or processes, it’s a lightweight, code-free solution that most teams can get running in hours. Incredibuild is designed to accelerate distributed dev teams, even those working from home and with low bandwidth - right from the ﬁrst sprint. </td>
               </tr>
            </table>
         </div>
         <div class="bottomtext">For more information about Incredibuild you can find <a href="https://www.incredibuild.com/" target="_blank">here</a></div>
         <img class="bottomlogos" src="https://www.incredibuild.com/wp-content/themes/incredibuild/roi_utils/images/logo.png"/>
      </div>
   </body>
</html>
';

// Load HTML to Dompdf
$pdf->loadHtml($html);

// Set paper size (optional)
$pdf->setPaper('A4', 'portrait');

// Render PDF (first pass to get total pages)
$pdf->render();

// Stream the file to the browser
$pdf->stream('output.pdf', array('Attachment' => 0));




} else {
    echo "ID not found in the JSON data.\n";
}





   