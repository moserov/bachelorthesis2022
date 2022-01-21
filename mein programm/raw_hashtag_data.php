<?php
    //Credentials
	include 'definition.php';
    //.JSON file with countrydata
    $countryarray = json_decode(file_get_contents('countryarrayfinalcopy.json'), true);
    


    //API call
	function makeApiCall( $endpoint, $type, $params ) {
		$ch = curl_init();

		if ( 'POST' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );
		} elseif ( 'GET' == $type ) {
			curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
		}

		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $response, true );
	}

    //Analyze Top Post array
    function analyzeTopPage ($topHashtagSearchArray, $topCountrySearchArray){
        
        for ($i=0; $i<=24; $i++) {
            if(isset($topHashtagSearchArray[$i])){
                $analyzearray = $topHashtagSearchArray[$i];
                for($j=0; $j<=371; $j++){
                    if((isset($analyzearray['caption']))AND(isset($topCountrySearchArray[$j]['name']))){
                        if(strpos(strtolower(($analyzearray['caption'])),$topCountrySearchArray[$j]['name'])){
                            if($topCountrySearchArray[$j]['group'] != ''){
                                $groupvar = $topCountrySearchArray[$j]['group'];
                                for ($k=0; $k<=371; $k++){
                                    if(isset($topCountrySearchArray[$k]['name'])){
                                        if($groupvar == $topCountrySearchArray[$k]['name']){
                                            $topCountrySearchArray[$k]['count']++;
                                        }
                                    }
                                }
                            }else{
                                $topCountrySearchArray[$j]['count']++;     
                            }
                        }
                    }
                }
            }
        }
        return ($topCountrySearchArray);
    }
    
    //Analyze Recent Post Array
    function analyzeRecentPages ($recentHashtagSearchArray, $recentCountrySearchArray){
        for ($i=0; $i<=243; $i++) {
            if(isset($recentHashtagSearchArray[$i])){
                $analyzearray = $recentHashtagSearchArray[$i];
                for($j=0; $j<=371; $j++){
                    if((isset($analyzearray['caption']))AND(isset($recentCountrySearchArray[$j]['name']))){
                        if(strpos($analyzearray['caption'],$recentCountrySearchArray[$j]['name'])){
                            if($recentCountrySearchArray[$j]['group'] != ''){
                                $groupvar = $recentCountrySearchArray[$j]['group'];
                                for ($k=0; $k<=371; $k++){
                                    if(isset($recentCountrySearchArray[$k]['name'])){
                                        if($groupvar == $recentCountrySearchArray[$k]['name']){
                                            $recentCountrySearchArray[$k]['count']++;
                                        }
                                    }
                                }
                            }else{
                                $recentCountrySearchArray[$j]['count']++;     
                            }
                        }
                    }
                }
            }
        }
        return ($recentCountrySearchArray);
    }




    //hashtag credentials
	$hashtag = 'travel';
	$hashtagId = '17843819167049166';

    $hashtag2 = 'holiday';
	$hashtag2Id = '17841563128094293';

    $hashtag3 = 'vacation';
	$hashtag3Id = '17843613766000411';


	// ENDPOINT_BASE = https://graph.facebook.com/v12.0/
	$hashtagSearchEndpoingFormat = ENDPOINT_BASE . 'ig_hashtag_search?user_id={user-id}&q={hashtag-name}&fields=id,name';

	//When we have the ID
	$hashtagDataEndpointFormat = ENDPOINT_BASE . '{hashtag-id}?fields=id,name';
	$hashtagTopMediaEndpointFormat = ENDPOINT_BASE . '{ig-hashtag-id}/top_media?user_id={user-id}&fields=id,caption,children,comments_count,like_count,media_type,media_url,permalink';
	$hashtagRecentEndpointFormat = ENDPOINT_BASE . '{ig-hashtag-id}/recent_media?user_id={user-id}&fields=id,caption,children,comments_count,like_count,media_type,media_url,permalink';




    // -------------------------------------------------------------1----------------------------------------------------------
	// get hashtag1 data by id
	$hashtagDataEndpoint = ENDPOINT_BASE . $hashtagId;
	$hashtagDataParams = array(
		'fields' => 'id,name',
		'access_token' => $accessToken
	);
	$hashtagData = makeApiCall( $hashtagDataEndpoint, 'GET', $hashtagDataParams );

	// top media for hashtag 1
	$hashtagTopMediaEndpoint = ENDPOINT_BASE . $hashtagId . '/top_media';
	$hashtagTopMediaParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtagTopPage1Data = makeApiCall( $hashtagTopMediaEndpoint, 'GET', $hashtagTopMediaParams );
    $hashtagTopPage1 = $hashtagTopPage1Data['data'];

	// recent media for hashtag 1
	$hashtagRecentEndpoint = ENDPOINT_BASE . $hashtagId . '/recent_media';
	$hashtagRecentParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtagRecent = makeApiCall( $hashtagRecentEndpoint, 'GET', $hashtagRecentParams );
    

    //Get next 9 recent pages
    $secondrecentpage = json_decode(file_get_contents($hashtagRecent['paging']['next']),true);
    $thirdrecentpage = json_decode(file_get_contents($secondrecentpage['paging']['next']),true);
    $fourthrecentpage = json_decode(file_get_contents($thirdrecentpage['paging']['next']),true);
    $fifthrecentpage = json_decode(file_get_contents($fourthrecentpage['paging']['next']),true);
    $sixtrecentpage = json_decode(file_get_contents($fifthrecentpage['paging']['next']),true);
    $seventhrecentpage = json_decode(file_get_contents($sixtrecentpage['paging']['next']),true);
    $eightrecentpage = json_decode(file_get_contents($seventhrecentpage['paging']['next']),true);
    $ninthrecentpage = json_decode(file_get_contents($eightrecentpage['paging']['next']),true);
    $tenthrecentpage = json_decode(file_get_contents($ninthrecentpage['paging']['next']),true);

    //get the data of the arrays
    $datahashtagRecent = $hashtagRecent['data'];
    $secondrecentpagedata = $secondrecentpage['data'];
    $thirdrecentpagedata = $thirdrecentpage['data'];
    $fourthrecentpagedata = $fourthrecentpage['data'];
    $fifthrecentpagedata = $fifthrecentpage['data'];
    $sixtrecentpagedata = $sixtrecentpage['data'];
    $seventhrecentpagedata = $seventhrecentpage['data'];
    $eightrecentpagedata = $eightrecentpage['data'];
    $ninthrecentpagedata = $ninthrecentpage['data'];
    $tenthrecentpagedata = $tenthrecentpage['data'];

    //merging all arrays together
    $allRecentPages1 = array_merge($datahashtagRecent,$secondrecentpagedata,$thirdrecentpagedata,$fourthrecentpagedata,$fifthrecentpagedata,$sixtrecentpagedata,$seventhrecentpagedata,$eightrecentpagedata,$ninthrecentpagedata,$tenthrecentpagedata);
    




    // -------------------------------------------------------------2----------------------------------------------------------
	// get hashtag2 data by id
	$hashtag2DataEndpoint = ENDPOINT_BASE . $hashtag2Id;
	$hashtag2DataParams = array(
		'fields' => 'id,name',
		'access_token' => $accessToken
	);
	$hashtag2Data = makeApiCall( $hashtag2DataEndpoint, 'GET', $hashtag2DataParams );

	// top media for hashtag 2
	$hashtag2TopMediaEndpoint = ENDPOINT_BASE . $hashtag2Id . '/top_media';
	$hashtag2TopMediaParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtagTopPage2Data = makeApiCall( $hashtag2TopMediaEndpoint, 'GET', $hashtag2TopMediaParams );
    $hashtagTopPage2 = $hashtagTopPage2Data['data'];

	// recent media for hashtag 2
	$hashtag2RecentEndpoint = ENDPOINT_BASE . $hashtag2Id . '/recent_media';
	$hashtag2RecentParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtag2Recent = makeApiCall( $hashtag2RecentEndpoint, 'GET', $hashtag2RecentParams );

    //Get next 9 recent pages
    $secondrecentpage2 = json_decode(file_get_contents($hashtag2Recent['paging']['next']),true);
    $thirdrecentpage2 = json_decode(file_get_contents($secondrecentpage2['paging']['next']),true);
    $fourthrecentpage2 = json_decode(file_get_contents($thirdrecentpage2['paging']['next']),true);
    $fifthrecentpage2 = json_decode(file_get_contents($fourthrecentpage2['paging']['next']),true);
    $sixtrecentpage2 = json_decode(file_get_contents($fifthrecentpage2['paging']['next']),true);
    $seventhrecentpage2 = json_decode(file_get_contents($sixtrecentpage2['paging']['next']),true);
    $eightrecentpage2 = json_decode(file_get_contents($seventhrecentpage2['paging']['next']),true);
    $ninthrecentpage2 = json_decode(file_get_contents($eightrecentpage2['paging']['next']),true);
    $tenthrecentpage2 = json_decode(file_get_contents($ninthrecentpage2['paging']['next']),true);

    //get the data of the arrays
    $datahashtagRecent2 = $hashtag2Recent['data'];
    $secondrecentpagedata2 = $secondrecentpage2['data'];
    $thirdrecentpagedata2 = $thirdrecentpage2['data'];
    $fourthrecentpagedata2 = $fourthrecentpage2['data'];
    $fifthrecentpagedata2 = $fifthrecentpage2['data'];
    $sixtrecentpagedata2 = $sixtrecentpage2['data'];
    $seventhrecentpagedata2 = $seventhrecentpage2['data'];
    $eightrecentpagedata2 = $eightrecentpage2['data'];
    $ninthrecentpagedata2 = $ninthrecentpage2['data'];
    $tenthrecentpagedata2 = $tenthrecentpage2['data'];

    //merging all arrays together
    $allRecentPages2 = array_merge($datahashtagRecent2,$secondrecentpagedata2,$thirdrecentpagedata2,$fourthrecentpagedata2,$fifthrecentpagedata2,$sixtrecentpagedata2,$seventhrecentpagedata2,$eightrecentpagedata2,$ninthrecentpagedata2,$tenthrecentpagedata2);
    




    // -------------------------------------------------------------3----------------------------------------------------------
	// get hashtag3 data by id
	$hashtag3DataEndpoint = ENDPOINT_BASE . $hashtag3Id;
	$hashtag3DataParams = array(
		'fields' => 'id,name',
		'access_token' => $accessToken
	);
	$hashtag3Data = makeApiCall( $hashtag3DataEndpoint, 'GET', $hashtag3DataParams );

	// top media for hashtag 3
	$hashtag3TopMediaEndpoint = ENDPOINT_BASE . $hashtag3Id . '/top_media';
	$hashtag3TopMediaParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtagTopPage3Data = makeApiCall( $hashtag3TopMediaEndpoint, 'GET', $hashtag3TopMediaParams );
    $hashtagTopPage3 = $hashtagTopPage3Data['data'];

	// recent media for hashtag 3
	$hashtag3RecentEndpoint = ENDPOINT_BASE . $hashtag3Id . '/recent_media';
	$hashtag3RecentParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtag3Recent = makeApiCall( $hashtag3RecentEndpoint, 'GET', $hashtag3RecentParams );
    
    //Get next 9 recent pages
    $secondrecentpage3 = json_decode(file_get_contents($hashtag3Recent['paging']['next']),true);
    $thirdrecentpage3 = json_decode(file_get_contents($secondrecentpage3['paging']['next']),true);
    $fourthrecentpage3 = json_decode(file_get_contents($thirdrecentpage3['paging']['next']),true);
    $fifthrecentpage3 = json_decode(file_get_contents($fourthrecentpage3['paging']['next']),true);
    $sixtrecentpage3 = json_decode(file_get_contents($fifthrecentpage3['paging']['next']),true);
    $seventhrecentpage3 = json_decode(file_get_contents($sixtrecentpage3['paging']['next']),true);
    $eightrecentpage3 = json_decode(file_get_contents($seventhrecentpage3['paging']['next']),true);
    $ninthrecentpage3 = json_decode(file_get_contents($eightrecentpage3['paging']['next']),true);
    $tenthrecentpage3 = json_decode(file_get_contents($ninthrecentpage3['paging']['next']),true);

    //get the data of the arrays
    $datahashtagRecent3 = $hashtag3Recent['data'];
    $secondrecentpagedata3 = $secondrecentpage3['data'];
    $thirdrecentpagedata3 = $thirdrecentpage3['data'];
    $fourthrecentpagedata3 = $fourthrecentpage3['data'];
    $fifthrecentpagedata3 = $fifthrecentpage3['data'];
    $sixtrecentpagedata3 = $sixtrecentpage3['data'];
    $seventhrecentpagedata3 = $seventhrecentpage3['data'];
    $eightrecentpagedata3 = $eightrecentpage3['data'];
    $ninthrecentpagedata3 = $ninthrecentpage3['data'];
    $tenthrecentpagedata3 = $tenthrecentpage3['data'];

    //merging all arrays together
    $allRecentPages3 = array_merge($datahashtagRecent3,$secondrecentpagedata3,$thirdrecentpagedata3,$fourthrecentpagedata3,$fifthrecentpagedata3,$sixtrecentpagedata3,$seventhrecentpagedata3,$eightrecentpagedata3,$ninthrecentpagedata3,$tenthrecentpagedata3);
    
    //Call Analyze Functions
    //1:
    $countryarray = analyzeTopPage($hashtagTopPage1, $countryarray);
    $countryarray = analyzeRecentPages($allRecentPages1, $countryarray);
    //2:
    $countryarray = analyzeTopPage($hashtagTopPage2, $countryarray);
    $countryarray = analyzeRecentPages($allRecentPages2, $countryarray);
    //3:
    $countryarray = analyzeTopPage($hashtagTopPage3, $countryarray);
    $countryarray = analyzeRecentPages($allRecentPages3, $countryarray);    
    
    
    //UPDATE test counter:
    for ($i=0; $i<=380; $i++) {
        if ($countryarray[$i]['name']=='Testcounter'){
            $countryarray[$i]['count']++;
        }
    }

    //GIVE CURRENT TOP 4:
    $sortedcountryarray = $countryarray;
    $keys = array_column($sortedcountryarray, 'count');
    array_multisort($keys, SORT_DESC, $sortedcountryarray);

    

    //save data in json
    $jsnon_countryarray = json_encode($sortedcountryarray);
	$test_country = 'countryarrayfinalcopy' . '.json';

   file_put_contents($test_country,$jsnon_countryarray);

?>