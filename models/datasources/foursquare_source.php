<?php

/**
 * CakePHP DataSource for accessing the Foursquare v2 (OAuth2) API.
 *
 * Datasource to access the Foursquare new API
 *
 * @author Andrés Smerkin <info@andressmerkin.com.ar>
 * @link http://www.andressmerkin.com.ar
 * @copyright (c) 2011 Andrés Smerkin
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

App::import('Core', 'HttpSocket');

class FoursquareSource extends DataSource {
    
    private $id = null;
    private $secret = null; 
    private $socket = null;
    private $url = 'https://api.foursquare.com/v2/';

    public $description = 'Foursquare API (Based on OAuth2)';
    
    public function __construct($config) {

        parent::__construct($config);
        $this->socket = new HttpSocket();
        $this->id = $this->config['id'];
        $this->secret = $this->config['secret'];
    }

    public function listSources() {
        
    }


    public function read($model, $queryData = array()) {

        if(!empty($queryData)) {
            $query = implode('/',$queryData['path']).'/';

            if(isset($queryData['id'])) $query .= $queryData['id'];

                //If not oauth_token is set then secret key is configured
                if(!isset($queryData['oauth_token'])) {

                    $parameters = array(
                        'client_id' => $this->id,
                        'client_secret' => $this->secret,
                    );

                } else {
                    $parameters['oauth_token'] = $queryData['oauth_token'];
                }

                debug($this->url.$query);
                return $this->socket->get($this->url.$query, $parameters);
            
        }
        
    }
    
//    public function getVenue($venueId = null) {
//
//        $url = 'https://api.foursquare.com/v2/venues/';
//
//        return $this->__process($this->socket->get($url.$venueId));
//    
//    }
    
    private function __process($json = null) {
    
        if(!$json) return false;
        
        return json_decode($json);
    
    }

    


}
