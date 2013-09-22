<?php
$foursquare = array(
	'client_id' => getenv('FOURSQUARE_ID'),
	'client_secret' => getenv('FOURSQUARE_SECRET'),
	'grant_type' => 'authorization_code', //Leave this as it is
	'redirect_uri' => getenv('FOURSQUARE_REDIRECT'),
	'venue_url' => 'https://foursquare.com/v/foursquare-hq'
);
Configure::write('Foursquare', $foursquare);
?>