<?php

/*
 * How to make this plugin Work
 *
 * 1. Register your App in Foursquare.
 *
 * 2. Add the following code to your main database.php file
 *
 *
        public $foursquare = array(
               'datasource' => 'Foursquare.foursquare',
                'id' => 'your_client_id',
                'secret' => 'your_client_secret',

        );
 *
 *
 * 3. Add the following code to your bootstrap.php file
 *
 *
         $foursquare = array(
            'client_id' => 'YOUR_CLIENT_ID',
            'client_secret' => 'YOUR_CLIENT_SECRET_ID',
            'grant_type' => 'authorization_code', //Leave this as it is
            'redirect_uri' => 'YOUR_REDIRECT_URI',
         );

         Configure::write('Foursquare', $foursquare);
 * 
 */