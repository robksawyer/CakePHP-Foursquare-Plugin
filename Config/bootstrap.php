<?php
$foursquare = array(
	'client_id' => getenv('FOURSQUARE_ID'),
	'client_secret' => getenv('FOURSQUARE_SECRET'),
	'grant_type' => 'authorization_code', //Leave this as it is
	'redirect_uri' => getenv('FOURSQUARE_REDIRECT')
);
Configure::write('Foursquare', $foursquare);
?>