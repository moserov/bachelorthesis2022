<?php
	session_start();

	define( 'FACEBOOK_APP_ID', '301944075074469D' );
	define( 'FACEBOOK_APP_SECRET', '5a1bf9f7fae4f071576ac696e31d5d3b' );
	define( 'FACEBOOK_REDIRECT_URI', 'http://localhost/' );
	define( 'ENDPOINT_BASE', 'https://graph.facebook.com/v5.0/' );

	// accessToken
	$accessToken = 'YOUR-ACCESS-TOKEN-HERE';

	// page id
	$pageId = 'YOUR-PAGE-ID';

	// instagram business account id
	$instagramAccountId = 'YOUR-INSTAGRAM-ACCOUNT-ID';