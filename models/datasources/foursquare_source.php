<?php

App::import('Core', 'HttpSocket');

class FoursquareSource extends DataSource {
//
//    private $accessTokenUrl = 'https://es.foursquare.com/oauth2/access_token';
//    private $authorizeUrl = 'https://es.foursquare.com/oauth2/authorize';
    
    private $id = null;
    private $secret = null; 
    private $socket = null;

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
            if($queryData['elements']['type'] == 'venues') {

                $id = $queryData['elements']['id'];

                $parameters = array(
                    'oauth_token' => $queryData['token']
                );

                $url = 'https://api.foursquare.com/v2/venues/';
                return $this->socket->get($url.$id, $parameters);
            }
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
