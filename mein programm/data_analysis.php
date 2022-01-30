<?php
	$countryarray = json_decode(file_get_contents('./backup/countryarrayfinalbackup.json'), true);


    //top Ten
    $Place1 = $countryarray[0];
    $Place2 = $countryarray[1];
    $Place3 = $countryarray[2];
    $Place4 = $countryarray[3];
    $Place5 = $countryarray[4];
    $Place6 = $countryarray[5];
    $Place7 = $countryarray[6];
    $Place8 = $countryarray[7];
    $Place9 = $countryarray[8];
    $Place10 = $countryarray[9];
    
    //Places without mentions
    $withoutmentions = array ();
    for ($i=0; $i<=374; $i++) {
        if ($countryarray[$i]['count'] == 0){
            $withoutmentions[] = $countryarray[$i];
        };
    }

    //without mentions and in group
    $withoutmentionsAndGroupCount = 0;
    foreach ($withoutmentions as $singleWithoutMentions){
        if ($singleWithoutMentions['group']!=''){
            $withoutmentionsAndGroupCount++;
        }
    }

    //Average Mentions
    $average = 0;
    for ($i=0; $i<=374; $i++) {
        $addedValue = $countryarray[$i]['count'];
        
        if ($countryarray[$i]['name']!='Testcounter'){
            $average = $average + $addedValue;
        }
    }
    
    //Without zeros
    $averageBetter = round($average/(374-count($withoutmentions)),2);
    $average = round(($average/ 374),2);
    

    //Above 100 Mentions: (100 "averageBetter")
    $above100 = array ();
    for ($i=0; $i<=374; $i++) {
        if (($countryarray[$i]['count'] > $averageBetter)&&($countryarray[$i]['name']!='Testcounter')){
            $above100[] = $countryarray[$i];
        };
    }

    //Average of at least 100 Mentions
    $average100 = 0;
    $testcounterAbove100 = false;
    foreach ($above100 as $singleAbove100) {
        $addedValue100 = $singleAbove100['count'];
        if ($singleAbove100['name']!='Testcounter'){
            $average100 = $average100 + $addedValue100;
        }else {
            $testcounterAbove100 = true;
        }
    }
    if ($testcounterAbove100){
        $average100 = round($average100/ (count($above100)-1),2);
    } else {
        $average100 = round($average100/ count($above100),2);
    }
    

    //Places that contributed a lot to their group
    $groupcounterTop10 = 0;
    $grouptop10 = array();
    for ($i=0; $i<=374; $i++) {
        if ($countryarray[$i]['group']!= ''){
            $grouptop10[$groupcounterTop10] = $countryarray[$i];
            $groupcounterTop10++;
        };
        
        if ($groupcounterTop10 > 9){
            break;
        }
    }
    
    
    
    
    
    /*
	besttraveltime 
	(if may-august then -> 23) later asked str_contains
	a number is given if 2 or more months are included
	sources: https://wetter-atlas.de/
			 https://wohin-und-wann.de/
			 https://diebestereisezeit.de/
			 https://www.urlaubsguru.de/
			 https://www.exoticca.com
	1=>DEZ-FEB
	2=>MAR-MAY
	3=>JUN-AUG
	4=>SEP-NOV 
	*/

    
    $timeNow = "1";
    $timePast ="4";
    $timeNearFuture ="2";
    $timeFarFutue="3";
    $counterBTT = 0;

    //BTT(Best Travel Time) Now or past-------------------------------------------------------------------------------
    $highNowAndBTTnowORpast= array();
    $lowNowAndBTTnowORpast= array();
    //HIGH
    for ($i=0; $i<=374; $i++) {
        if ((strpos($countryarray[$i]['besttraveltime'],$timeNow))||(strpos($countryarray[$i]['besttraveltime'],$timePast)) && ($countryarray[$i]['group'] == '') ){
            $highNowAndBTTnowORpast[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };
    //LOW
    for ($i=374; $i>=0; $i--) {
        if (((strpos($countryarray[$i]['besttraveltime'],$timeNow))||(strpos($countryarray[$i]['besttraveltime'],$timePast))) && ($countryarray[$i]['group'] == '') && ($countryarray[$i]['count'] != 0)){
            $lowNowAndBTTnowORpast[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };


    //BTT only NOW -----------------------------------------------------------------------------------------------
    $highNowAndBTTNow= array();
    $lowNowAndBTTNow= array();
    //HIGH
    for ($i=0; $i<=374; $i++) {
        
        if (((strpos($countryarray[$i]['besttraveltime'],$timeNow)) == 0) && ((strpos($countryarray[$i]['besttraveltime'],$timeNow)) != '') && ($countryarray[$i]['group'] == '') ) {
            $highNowAndBTTNow[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };
    //LOW
    for ($i=374; $i>=0; $i--) {
        if (((strpos($countryarray[$i]['besttraveltime'],$timeNow)) == 0) && ($countryarray[$i]['group'] == '') && ((strpos($countryarray[$i]['besttraveltime'],$timeNow)) != '') && ($countryarray[$i]['count'] != 0)){
            $lowNowAndBTTNow[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };

    


    //BTT near future--------------------------------------------------------------------------------------------
    $highNowAndBTTnearFuture=array();
    $lowNowAndBTTnearFuture=array();
    //HIGH
    for ($i=0; $i<=374; $i++) {
        if ((strpos($countryarray[$i]['besttraveltime'],$timeNearFuture)  || ((strpos($countryarray[$i]['besttraveltime'],$timeNearFuture)) == 0) && ((strpos($countryarray[$i]['besttraveltime'],$timeNearFuture)) != '')) &&  ($countryarray[$i]['group'] == '') ){
            $highNowAndBTTnearFuture[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };
    //LOW
    for ($i=374; $i>=0; $i--) {
        if (((strpos($countryarray[$i]['besttraveltime'],$timeNearFuture))  || ((strpos($countryarray[$i]['besttraveltime'],$timeNearFuture)) == 0) && ((strpos($countryarray[$i]['besttraveltime'],$timeNearFuture)) != ''))  && ($countryarray[$i]['group'] == '') && ($countryarray[$i]['count'] != 0) ){
            $lowNowAndBTTnearFuture[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };
    
    //BTT far future------------------------------------------------------------------------------------------------------
    $highNowAndBTTfarFuture=array();
    $lowNowAndBTTfarFuture=array();
    //HIGH
    for ($i=0; $i<=374; $i++) {
        if ((strpos($countryarray[$i]['besttraveltime'],$timeFarFutue) && ($countryarray[$i]['group'] == '') || ((strpos($countryarray[$i]['besttraveltime'],$timeFarFutue)) == 0) && ((strpos($countryarray[$i]['besttraveltime'],$timeFarFutue)) != ''))  && (strpos($countryarray[$i]['besttraveltime'],$timeFarFutue) != '')){
            $highNowAndBTTfarFuture[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };
    //LOW
    for ($i=374; $i>=0; $i--) {
        if ((strpos($countryarray[$i]['besttraveltime'],$timeFarFutue)  || ((strpos($countryarray[$i]['besttraveltime'],$timeFarFutue)) == 0) && ((strpos($countryarray[$i]['besttraveltime'],$timeFarFutue)) != ''))   && ($countryarray[$i]['count'] != 0) && ($countryarray[$i]['group'] == '')){
            $lowNowAndBTTfarFuture[] = $countryarray[$i];
            $counterBTT++;
        }

        if ($counterBTT == 30){
            $counterBTT = 0;
            break;
        }
    };
    


    
    



?>




<!DOCTYPE html>
<html>
	<head>
		<title>
			Hashtag Search with the Instagram Graph API
		</title>
		<meta charset="utf-8" />

        <style>
            table {
            font-family: arial, sans-serif;
            font-size: 17px;
            border-collapse: collapse;
            width: 35%;
            padding: 2px;
            }

            td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px;
            }

            tr:nth-child(even) {
            background-color: #dddddd;
            }
        </style>
	</head>
	<body>
        <h1>
            Data Analysis:
        </h1>
        <hr />
        <div> 
            <h3>Top Ten</h3> 
            <ol>
                <li><?php echo nl2br($Place1['name']) ?>: <?php echo nl2br($Place1['count']) ?></li>
                <li><?php echo nl2br($Place2['name']) ?>: <?php echo nl2br($Place2['count']) ?></li>
                <li><?php echo nl2br($Place3['name']) ?>: <?php echo nl2br($Place3['count']) ?></li>
                <li><?php echo nl2br($Place4['name']) ?>: <?php echo nl2br($Place4['count']) ?></li>
                <li><?php echo nl2br($Place5['name']) ?>: <?php echo nl2br($Place5['count']) ?></li>
                <li><?php echo nl2br($Place6['name']) ?>: <?php echo nl2br($Place6['count']) ?></li>
                <li><?php echo nl2br($Place7['name']) ?>: <?php echo nl2br($Place7['count']) ?></li>
                <li><?php echo nl2br($Place8['name']) ?>: <?php echo nl2br($Place8['count']) ?></li>
                <li><?php echo nl2br($Place9['name']) ?>: <?php echo nl2br($Place9['count']) ?></li>
                <li><?php echo nl2br($Place10['name']) ?>: <?php echo nl2br($Place10['count']) ?></li>
            </ol>
        </div>
        </br>
        <div> 
            <h3>Places above "Average without Zero" Ammount of Mentions</h3> 
            <textarea style="width:50%;height:100px"><?php 
                                                            foreach ($above100 as $singleAbove100) {
                                                                echo( $singleAbove100['name'] ); 
                                                            }
                                                      ?>
            </textarea>
            <p>In total above the "Average without Zero": <?php echo count($above100) ?></p>
        </div>
        <div>
            <p>Average count: <?php echo($average) ?></p>
            <p>Average count (without zeros): <?php echo($averageBetter) ?></p>   
            <p>Average count of places with more than "Average without Zero" mentions: <?php echo($average100) ?></p>
        </div>
        </br>
        <div> 
            <h3>Places that did not get any mentions</h3> 
            <textarea style="width:60%;height:100px"><?php 
                                                            foreach ($withoutmentions as $singleNoMentions) {
                                                                echo( $singleNoMentions['name'] ); 
                                                            }
                                                      ?>
            </textarea>
            <p>In total: <?php echo count($withoutmentions) ?></p>
            <p>Of these are in a group: <?php echo ($withoutmentionsAndGroupCount) ?></p>
        </div>
        </br>
        <div> 
            <h3>Places that contributed the most to their group</h3> 
            <ol>
                <li><?php echo nl2br($grouptop10[0]['name']) ?>: <?php echo nl2br($grouptop10[0]['count']) ?> to the group:<?php echo nl2br($grouptop10[0]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[1]['name']) ?>: <?php echo nl2br($grouptop10[1]['count']) ?> to the group:<?php echo nl2br($grouptop10[1]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[2]['name']) ?>: <?php echo nl2br($grouptop10[2]['count']) ?> to the group:<?php echo nl2br($grouptop10[2]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[3]['name']) ?>: <?php echo nl2br($grouptop10[3]['count']) ?> to the group:<?php echo nl2br($grouptop10[3]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[4]['name']) ?>: <?php echo nl2br($grouptop10[4]['count']) ?> to the group:<?php echo nl2br($grouptop10[4]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[5]['name']) ?>: <?php echo nl2br($grouptop10[5]['count']) ?> to the group:<?php echo nl2br($grouptop10[5]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[6]['name']) ?>: <?php echo nl2br($grouptop10[6]['count']) ?> to the group:<?php echo nl2br($grouptop10[6]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[7]['name']) ?>: <?php echo nl2br($grouptop10[7]['count']) ?> to the group:<?php echo nl2br($grouptop10[7]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[8]['name']) ?>: <?php echo nl2br($grouptop10[8]['count']) ?> to the group:<?php echo nl2br($grouptop10[8]['group']) ?></li>
                <li><?php echo nl2br($grouptop10[9]['name']) ?>: <?php echo nl2br($grouptop10[9]['count']) ?> to the group:<?php echo nl2br($grouptop10[9]['group']) ?></li>
            </ol>
        </div>
        </br>
        <!-- BEST TRAVEL TIME ANALYSIS-->
        <hr />
        <h1>Further analysis with besttraveltime (no groups)</h1>
        </br>
        <div> 
            <h2>Best Travel Time now or Past:</h2> 
            <div>
                <h4>High Counts:</h4> 
                <ol>
                    <li><?php echo nl2br($highNowAndBTTnowORpast[0]['name']) ?>: <?php echo nl2br($highNowAndBTTnowORpast[0]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnowORpast[1]['name']) ?>: <?php echo nl2br($highNowAndBTTnowORpast[1]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnowORpast[2]['name']) ?>: <?php echo nl2br($highNowAndBTTnowORpast[2]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnowORpast[3]['name']) ?>: <?php echo nl2br($highNowAndBTTnowORpast[3]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnowORpast[4]['name']) ?>: <?php echo nl2br($highNowAndBTTnowORpast[4]['count']) ?></li>
                </ol>
            </div>
            <div>
                <h4>Low Counts (No zeros):</h4> 
                <ol>
                    <li><?php echo nl2br($lowNowAndBTTnowORpast[0]['name']) ?>: <?php echo nl2br($lowNowAndBTTnowORpast[0]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnowORpast[1]['name']) ?>: <?php echo nl2br($lowNowAndBTTnowORpast[1]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnowORpast[2]['name']) ?>: <?php echo nl2br($lowNowAndBTTnowORpast[2]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnowORpast[3]['name']) ?>: <?php echo nl2br($lowNowAndBTTnowORpast[3]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnowORpast[4]['name']) ?>: <?php echo nl2br($lowNowAndBTTnowORpast[4]['count']) ?></li>
                </ol>
            </div>
        </div>
        </br>
        <div> 
            <h2>Best Travel Time only Now:</h2> 
            <div>
                <h4>High Counts:</h4> 
                <ol>
                    <li><?php echo nl2br($highNowAndBTTNow[0]['name']) ?>: <?php echo nl2br($highNowAndBTTNow[0]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTNow[1]['name']) ?>: <?php echo nl2br($highNowAndBTTNow[1]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTNow[2]['name']) ?>: <?php echo nl2br($highNowAndBTTNow[2]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTNow[3]['name']) ?>: <?php echo nl2br($highNowAndBTTNow[3]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTNow[4]['name']) ?>: <?php echo nl2br($highNowAndBTTNow[4]['count']) ?></li>
                </ol>
            </div>
            <div>
                <h4>Low Counts (No zeros):</h4> 
                <ol>
                    <li><?php echo nl2br($lowNowAndBTTNow[0]['name']) ?>: <?php echo nl2br($lowNowAndBTTNow[0]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTNow[1]['name']) ?>: <?php echo nl2br($lowNowAndBTTNow[1]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTNow[2]['name']) ?>: <?php echo nl2br($lowNowAndBTTNow[2]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTNow[3]['name']) ?>: <?php echo nl2br($lowNowAndBTTNow[3]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTNow[4]['name']) ?>: <?php echo nl2br($lowNowAndBTTNow[4]['count']) ?></li>
                </ol>
            </div>
        </div>
        </br>
        <div> 
            <h2>Best Travel Time in near Future:</h2> 
            <div>
                <h4>High Counts:</h4> 
                <ol>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[0]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[0]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[1]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[1]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[2]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[2]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[3]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[3]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[4]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[4]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[5]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[5]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[6]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[6]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[7]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[7]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[8]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[8]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTnearFuture[9]['name']) ?>: <?php echo nl2br($highNowAndBTTnearFuture[9]['count']) ?></li>
                </ol>
            </div>
            <div>
                <h4>Low Counts (No zeros):</h4> 
                <ol>
                    <li><?php echo nl2br($lowNowAndBTTnearFuture[0]['name']) ?>: <?php echo nl2br($lowNowAndBTTnearFuture[0]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnearFuture[1]['name']) ?>: <?php echo nl2br($lowNowAndBTTnearFuture[1]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnearFuture[2]['name']) ?>: <?php echo nl2br($lowNowAndBTTnearFuture[2]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnearFuture[3]['name']) ?>: <?php echo nl2br($lowNowAndBTTnearFuture[3]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTnearFuture[4]['name']) ?>: <?php echo nl2br($lowNowAndBTTnearFuture[4]['count']) ?></li>
                </ol>
            </div>
        </div>
        </br>
        <div> 
            <h2>Best Travel Time in far Future:</h2> 
            <div>
                <h4>High Counts:</h4> 
                <ol>
                    <li><?php echo nl2br($highNowAndBTTfarFuture[0]['name']) ?>: <?php echo nl2br($highNowAndBTTfarFuture[0]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTfarFuture[1]['name']) ?>: <?php echo nl2br($highNowAndBTTfarFuture[1]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTfarFuture[2]['name']) ?>: <?php echo nl2br($highNowAndBTTfarFuture[2]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTfarFuture[3]['name']) ?>: <?php echo nl2br($highNowAndBTTfarFuture[3]['count']) ?></li>
                    <li><?php echo nl2br($highNowAndBTTfarFuture[4]['name']) ?>: <?php echo nl2br($highNowAndBTTfarFuture[4]['count']) ?></li>
                </ol>
            </div>
            <div>
                <h4>Low Counts (No zeros):</h4> 
                <ol>
                    <li><?php echo nl2br($lowNowAndBTTfarFuture[0]['name']) ?>: <?php echo nl2br($lowNowAndBTTfarFuture[0]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTfarFuture[1]['name']) ?>: <?php echo nl2br($lowNowAndBTTfarFuture[1]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTfarFuture[2]['name']) ?>: <?php echo nl2br($lowNowAndBTTfarFuture[2]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTfarFuture[3]['name']) ?>: <?php echo nl2br($lowNowAndBTTfarFuture[3]['count']) ?></li>
                    <li><?php echo nl2br($lowNowAndBTTfarFuture[4]['name']) ?>: <?php echo nl2br($lowNowAndBTTfarFuture[4]['count']) ?></li>
                </ol>
            </div>
        </div>
        </br>
        <hr />
        <h1>Combining besttraveltime lists (Top 30)</h1>
        </br>
        <div> 
            <h2>Best Travel Time in near Future and Far Future:</h2> 
            <ol>
                <?php 
                    foreach ($highNowAndBTTnearFuture as $singleNearFuture) {
                        foreach ($highNowAndBTTfarFuture as $singleFarFuture){
                            if($singleNearFuture['name']==$singleFarFuture['name']){
                                echo('<li>');
                                echo($singleNearFuture['name']).': '. ($singleNearFuture['count']);
                                echo('</li>');
                            }
                        }
                    }
                ?>
            </ol>
        </div>
        <div> 
            <h2>Best Travel Time now and in near Future: </h2> 
            <ol>
                <?php 
                    foreach ($highNowAndBTTnearFuture as $singleNearFuture) {
                        foreach ($highNowAndBTTNow as $singleNow){
                            if($singleNearFuture['name']==$singleNow['name']){
                                echo('<li>');
                                echo($singleNearFuture['name']).': '. ($singleNearFuture['count']);
                                echo('</li>');
                            }
                        }
                    }
                ?>
            </ol>
        </div>
        <div> 
            <h2>Best Travel Time in near Future and not now: </h2> 
            <ol>
                <?php 
                    foreach ($highNowAndBTTnearFuture as $singleNearFuture) {
                        $checkiftrue = false;
                        foreach ($highNowAndBTTNow as $singleNow){
                            if($singleNearFuture['name'] == $singleNow['name']){
                                $checkiftrue = true;
                                break;
                            } else{
                                $checkiftrue == false;
                            }
                        }
                        if($checkiftrue == false){
                            echo('<li>');
                            echo($singleNearFuture['name']).': '. ($singleNearFuture['count']);
                            echo('</li>');
                        }
                    }
                ?>
            </ol>
        </div>
        <div> 
            <h2>Best Travel Time now and not in near Future: </h2> 
            <ol>
                <?php 
                    foreach ($highNowAndBTTNow as $singleNow) {
                        $checkiftrue = false;
                        foreach ($highNowAndBTTnearFuture as $singleNearFuture){
                            if($singleNearFuture['name'] == $singleNow['name']){
                                $checkiftrue = true;
                                break;
                            } else{
                                $checkiftrue == false;
                            }
                        }
                        if($checkiftrue == false){
                            echo('<li>');
                            echo($singleNow['name']).': '. ($singleNow['count']);
                            echo('</li>');
                        }
                    }
                ?>
            </ol>
        </div>
        </br>
        <hr />
        <div>
            <h1> Raw data:</h1> 
            <table>
                <tr>
                    <th> Ranking </th>
                    <th> Hashtag </th>
                    <th> Count </th>
                    <th> Best travel time </th>
                    <th> Group </th>
                </tr>
                <?php
                    /*echo('<pre>');
                    print_r($countryarray);
                    echo('</pre>');
                    die;*/
                    $placeCount = 1;
                    foreach ($countryarray as $singleCountry){
                        echo('<tr>');
                        echo('<td>'.$placeCount.'. </td>');
                        echo('<td>'.$singleCountry['name'].'</td>');
                        echo('<td>'.$singleCountry['count'].'</td>');
                        echo('<td>'.$singleCountry['besttraveltime'].'</td>');
                        echo('<td>'.$singleCountry['group'].'</td>');
                        echo('</tr>');
                        $placeCount++;
                    }
                ?>
            </table>         
        </div>
        
        
        
    


		

	</body>
</html>