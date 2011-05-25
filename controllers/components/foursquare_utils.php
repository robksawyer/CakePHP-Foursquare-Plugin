<?php

/**
 * Foursquare Utilities Component
 *
 * @author Andrés Smerkin <info@andressmerkin.com.ar>
 * @link http://www.andressmerkin.com.ar
 * @copyright (c) 2011 Andrés Smerkin
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

class FoursquareUtilsComponent extends Object {

    public function getAuthUrl() {

        $url = 'https://es.foursquare.com/oauth2/authenticate';

        $parameters = array(
            'client_id' => Configure::read('Foursquare.client_id'),
            'response_type' => 'code',
            'redirect_uri' => Configure::read('Foursquare.redirect_uri')
        );

        foreach($parameters as $key => $parameter) {
            $queryStrng[] = $key.'='.$parameter;
        }

        $queryString = implode('&', $queryStrng);

        return $url.'?'.$queryString;
        
    }

    /**
     * Gets the token from the Foursquare API
     *
     * Gets the oauth_token from The API based on the code which has to be
     * received from the authorization request.
     *
     * @param String $code Code of the autorization request
     * @return Array Result received
     */
    public function getToken($code = null) {

        $url = 'https://es.foursquare.com/oauth2/access_token';

        $parameters = Configure::read('Foursquare');
        if(isset($parameters['oauth_token'])) unset ($parameters['oauth_token']);

        $parameters['code'] = $code;

        App::import('Core', 'HttpSocket');
        $socket = new HttpSocket();
        $token = $socket->get($url,$parameters);

        return json_decode($token);

    }


    
}


?>
