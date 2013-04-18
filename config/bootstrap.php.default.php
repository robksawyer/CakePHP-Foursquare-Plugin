<?php
$foursquare = array(
	'client_id' => 'CLIENT_ID',
	'client_secret' => 'CLIENT_SECRET',
	'grant_type' => 'authorization_code', //Leave this as it is
	'redirect_uri' => 'http://redirecturl.com',
);

Configure::write('Foursquare', $foursquare);
?>