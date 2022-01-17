<?php
	include 'definition.php';
    $countryarray = json_decode(file_get_contents('testcountry.json'), true);

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
	$hashtagTopMedia = makeApiCall( $hashtagTopMediaEndpoint, 'GET', $hashtagTopMediaParams );
	$topPost = $hashtagTopMedia['data'][0];

	// recent media for hashtag 1
	$hashtagRecentEndpoint = ENDPOINT_BASE . $hashtagId . '/recent_media';
	$hashtagRecentParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtagRecent = makeApiCall( $hashtagRecentEndpoint, 'GET', $hashtagRecentParams );
	$recentPost = $hashtagRecent['data'][0];

    //firstpage
    $nexttoppage = json_decode(file_get_contents($hashtagTopMedia['paging']['next']),true);
    $secondtoppage = json_decode(file_get_contents($nexttoppage['paging']['next']),true);

    $nexttestpage = $nexttoppage['data'];
    $seconttestpage = $secondtoppage['data'];
    $togetherarray = array_merge($nexttestpage,$seconttestpage);
    
    echo '<pre>';
    print_r($togetherarray);
    echo '</pre>';


    //ALGORITHM
    for ($i=0; $i<=22; $i++) {
        $analyzearray = $hashtagTopMedia['data'][$i];
        for($j=0; $j<=19; $j++){
            if((isset($analyzearray['caption']))AND(isset($countryarray[$j]['name']))){
                if(strpos($analyzearray['caption'],$countryarray[$j]['name'])){
                    if($countryarray[$j]['group'] != ''){
                        $groupvar = $countryarray[$j]['group'];
                        for ($k=0; $k<=19; $k++){
                            if(isset($countryarray[$k]['name'])){
                                if($groupvar == $countryarray[$k]['name']){
                                    $countryarray[$k]['count']++;
                                }
                            }
                        }
                    }else{
                        $countryarray[$j]['count']++;     
                    }
                }
            }

        }
            
    };
    echo '<pre>';
    print_r($countryarray);
    echo '</pre>';

    $jsnon_countryarray = json_encode($countryarray);
	$test_country = 'testcountry' . '.json';

	if (file_put_contents($test_country,$jsnon_countryarray)){
		echo $test_country . 'file created';
	}else{
		echo 'error';
	};


 


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
	$hashtag2TopMedia = makeApiCall( $hashtag2TopMediaEndpoint, 'GET', $hashtag2TopMediaParams );
	$topPost2 = $hashtag2TopMedia['data'][0];

	// recent media for hashtag 2
	$hashtag2RecentEndpoint = ENDPOINT_BASE . $hashtag2Id . '/recent_media';
	$hashtag2RecentParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtag2Recent = makeApiCall( $hashtag2RecentEndpoint, 'GET', $hashtag2RecentParams );
	$recentPost2 = $hashtag2Recent['data'][0];





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
	$hashtag3TopMedia = makeApiCall( $hashtag3TopMediaEndpoint, 'GET', $hashtag3TopMediaParams );
	$topPost3 = $hashtag3TopMedia['data'][0];

	// recent media for hashtag 3
	$hashtag3RecentEndpoint = ENDPOINT_BASE . $hashtag3Id . '/recent_media';
	$hashtag3RecentParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,caption,children,comments_count,like_count,media_type,media_url,permalink,timestamp',
		'access_token' => $accessToken
	);
	$hashtag3Recent = makeApiCall( $hashtag3RecentEndpoint, 'GET', $hashtag3RecentParams );
	$recentPost3 = $hashtag3Recent['data'][0];
?>




<!DOCTYPE html>
<html>
	<head>
		<title>
			Hashtag Search with the Instagram Graph API
		</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1>
			Hashtag Search with the Instagram Graph API
		</h1>
		<hr />

        <!-- ----------------Hashtag 1--------------------- -->
        <div>
            <h2>
                Hashtag <a target="_blank" href="https://www.instagram.com/explore/tags/<?php echo $hashtag; ?>">#<?php echo $hashtag; ?> (id <?php echo $hashtagData['id']; ?>)</a>
            <h2>
            <hr />
            <h3>
                Top Post for #<?php echo $hashtagData['name']; ?>
            </h3>
            <div>
                <div>
                    <?php if ( 'IMAGE' == $topPost['media_type'] || 'CAROUSEL_ALBUM' == $topPost['media_type'] ) : ?>
                        <img style="height:320px" src="<?php echo $topPost['media_url']; ?>" />
                    <?php else : ?>
                        <video height="240" width="320" controls>
                            <source src="<?php echo $topPost['media_url']; ?>" />
                        </video>
                    <?php endif; ?>
                </div>
                <div>
                    <b>Caption: <?php echo nl2br( $topPost['caption'] ); ?></b>
                    Post ID: <?php echo nl2br( $topPost['id'] ); ?>
                    Media Type: <?php echo nl2br( $topPost['media_type'] ); ?>
                    Media URL: <?php echo nl2br( $topPost['media_url'] ); ?>
                    Timestamp: <?php echo nl2br( $topPost['timestamp'] ); ?>
                    Link: <a target="_blank" href="<?php echo $topPost['permalink']; ?>"><?php echo $topPost['permalink']; ?></a>
                </div>
            </div>
            <div>
                <hr />
                <h2>
                    Hashtag Counter Test <?php echo $counter; ?>
                </h2>
                <h3>
                    Hashtag Data Endpoint: <?php echo $hashtagDataEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:100px"><?php print_r( $hashtagData ); ?></textarea>
                <hr />
                <h3>
                    Hashtag Top Media Endpoint: <?php echo $hashtagTopMediaEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:300px"><?php print_r( $hashtagTopMedia ); ?></textarea>
                <hr />
                <h3>
                    Hashtag Recent Media Endpoint: <?php echo $hashtagRecentEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:300px"><?php print_r( $hashtagRecent ); ?></textarea>
                <hr />
                <br/>
                <br/>
            </div>
        </div>

        <!-- ----------------Hashtag 2--------------------- -->
        <div>
            <h2>
                Hashtag 2 <a target="_blank" href="https://www.instagram.com/explore/tags/<?php echo $hashtag2; ?>">#<?php echo $hashtag2; ?> (id <?php echo $hashtag2Data['id']; ?>)</a>
            <h2>
            <hr />
            <h3>
                Top Post for #<?php echo $hashtag2Data['name']; ?>
            </h3>
            <div>
                <div>
                    <?php if ( 'IMAGE' == $topPost2['media_type'] || 'CAROUSEL_ALBUM' == $topPost2['media_type'] ) : ?>
                        <img style="height:320px" src="<?php echo $topPost2['media_url']; ?>" />
                    <?php else : ?>
                        <video height="240" width="320" controls>
                            <source src="<?php echo $topPost2['media_url']; ?>" />
                        </video>
                    <?php endif; ?>
                </div>
                <div>
                    <b>Caption: <?php echo nl2br( $topPost2['caption'] ); ?></b>
                    Post ID: <?php echo nl2br( $topPost2['id'] ); ?>
                    Media Type: <?php echo nl2br( $topPost2['media_type'] ); ?>
                    Media URL: <?php echo nl2br( $topPost2['media_url'] ); ?>
                    Timestamp: <?php echo nl2br( $topPost2['timestamp'] ); ?>
                    Link: <a target="_blank" href="<?php echo $topPost2['permalink']; ?>"><?php echo $topPost2['permalink']; ?></a>
                </div>
            </div>
            <div>
                <hr />
                <h3>
                    Hashtag 2 Data Endpoint: <?php echo $hashtag2DataEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:100px"><?php print_r( $hashtag2Data ); ?></textarea>
                <hr />
                <h3>
                    Hashtag 2 Top Media Endpoint: <?php echo $hashtag2TopMediaEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:300px"><?php print_r( $hashtag2TopMedia ); ?></textarea>
                <hr />
                <h3>
                    Hashtag 2 Recent Media Endpoint: <?php echo $hashtag2RecentEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:300px"><?php print_r( $hashtag2Recent ); ?></textarea>
                <hr />
                <br/>
                <br/>
            </div>
        </div>


        <!-- ----------------Hashtag 2--------------------- -->
        <div>
            <h2>
                Hashtag 3 <a target="_blank" href="https://www.instagram.com/explore/tags/<?php echo $hashtag3; ?>">#<?php echo $hashtag3; ?> (id <?php echo $hashtag3Data['id']; ?>)</a>
            <h2>
            <hr />
            <h3>
                Top Post for #<?php echo $hashtag3Data['name']; ?>
            </h3>
            <div>
                <div>
                    <?php if ( 'IMAGE' == $topPost3['media_type'] || 'CAROUSEL_ALBUM' == $topPost3['media_type'] ) : ?>
                        <img style="height:320px" src="<?php echo $topPost3['media_url']; ?>" />
                    <?php else : ?>
                        <video height="240" width="320" controls>
                            <source src="<?php echo $topPost3['media_url']; ?>" />
                        </video>
                    <?php endif; ?>
                </div>
                <div>
                    <b>Caption: <?php echo nl2br( $topPost3['caption'] ); ?></b>
                    Post ID: <?php echo nl2br( $topPost3['id'] ); ?>
                    Media Type: <?php echo nl2br( $topPost3['media_type'] ); ?>
                    Media URL: <?php echo nl2br( $topPost3['media_url'] ); ?>
                    Timestamp: <?php echo nl2br( $topPost3['timestamp'] ); ?>
                    Link: <a target="_blank" href="<?php echo $topPost3['permalink']; ?>"><?php echo $topPost3['permalink']; ?></a>
                </div>
            </div>
            <div>
                <hr />
                <h3>
                    Hashtag 3 Data Endpoint: <?php echo $hashtag3DataEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:100px"><?php print_r( $hashtag3Data ); ?></textarea>
                <hr />
                <h3>
                    Hashtag 3 Top Media Endpoint: <?php echo $hashtag3TopMediaEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:300px"><?php print_r( $hashtag3TopMedia ); ?></textarea>
                <hr />
                <h3>
                    Hashtag 3 Recent Media Endpoint: <?php echo $hashtag3RecentEndpoint; ?>
                </h3>
                    <textarea style="width:100%;height:300px"><?php print_r( $hashtag3Recent ); ?></textarea>
                <hr />
                <br/>
                <br/>
            </div>
        </div>

	</body>
</html>