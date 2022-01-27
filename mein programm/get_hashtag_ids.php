<?php
	include 'definition.php';

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

    //defining the hashtags
	$hashtag = 'travel';
    $hashtag1 = 'holiday';
    $hashtag2 = 'vacation';


	
	$hashtagSearchEndpoingFormat = ENDPOINT_BASE . 'ig_hashtag_search?user_id={user-id}&q={hashtag-name}&fields=id,name';
	
	// get hashtag id by name
	$hashtagSearchEndpoint = ENDPOINT_BASE . 'ig_hashtag_search';
	$hashtagSearchParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,name',
		'q' => $hashtag,
		'access_token' => $accessToken
	);
	$hashtagSearch = makeApiCall( $hashtagSearchEndpoint, 'GET', $hashtagSearchParams );
    $firsthashtag = $hashtagSearch['data'][0];


    // get hashtag1 id by name
	$hashtag1SearchEndpoint = ENDPOINT_BASE . 'ig_hashtag_search';
	$hashtag1SearchParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,name',
		'q' => $hashtag1,
		'access_token' => $accessToken
	);
	$hashtag1Search = makeApiCall( $hashtag1SearchEndpoint, 'GET', $hashtag1SearchParams );
    $secondhashtag = $hashtag1Search['data'][0];


    // get hashtag2 id by name
	$hashtag2SearchEndpoint = ENDPOINT_BASE . 'ig_hashtag_search';
	$hashtag2SearchParams = array(
		'user_id' => $instagramAccountId,
		'fields' => 'id,name',
		'q' => $hashtag2,
		'access_token' => $accessToken
	);
	$hashtag2Search = makeApiCall( $hashtag2SearchEndpoint, 'GET', $hashtag2SearchParams );
    $thirdhashtag = $hashtag2Search['data'][0];

	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Hashtag ID Search with the Instagram Graph API
		</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1>
			Getting the ID for certain hashtags
		</h1>
		<h2>
			<?php echo ($hashtagSearchEndpoint) ?>
</h2>
		<hr />
        <div>
            <h3>
                Hashtag 1: <?php echo $hashtag; ?>
            </h3>
            ID: <?php echo ($firsthashtag['id']); ?>
        </div>
        <hr />
        <div>
            <h3>
                Hashtag 2: <?php echo $hashtag1; ?>
            </h3>
            ID: <?php echo ($secondhashtag['id']); ?>
        </div>
        <hr />
        <div>
            <h3>
                Hashtag 3: <?php echo $hashtag2; ?>
            </h3>
            ID: <?php echo ($thirdhashtag['id']); ?>
        </div>
		<hr />
        <br/>
        <div>
            <h3>
                Hashtag 1: 
		    </h3>
		    <textarea style="width:100%;height:200px"><?php print_r( $hashtagSearch ); ?></textarea>
            <h3>
                Hashtag 2: 
		    </h3>
		    <textarea style="width:100%;height:200px"><?php print_r( $hashtag1Search ); ?></textarea>
            <h3>
                Hashtag 3: 
		    </h3>
		    <textarea style="width:100%;height:200px"><?php print_r( $hashtag2Search ); ?></textarea>
        </div>
	</body>
</html>