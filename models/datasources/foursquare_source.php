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
    /*
     * The format of $queryData shoud be the following
     *
     * 'resource', 'general', 'aspect', 'action', 'id'
     *
     *  These are the four elements in which the API is divided. 
     */
        if(!empty($queryData)) {

            if(!isset($queryData['options']))
                $queryData['options'] = array();

            /*
             * Here the endpoint is the table that was configured Model::useTable
             */
            $query = $model->useTable;

            if(isset($queryData['general'])) {
                $query .= '/'.$queryData['general'];
                unset ($queryData['id']);
                unset ($queryData['aspect']);
                unset ($queryData['action']);
            }

            if(isset($queryData['id']))
                $query .='/'. $queryData['id'];
             

            if(isset($queryData['aspect'])) {
                $query .= '/'.$queryData['aspect'];
                unset ($queryData['action']);
            }
            
            if(isset($queryData['action']))
                $query .= '/'.$queryData['action'];


                //If not oauth_token is set then secret key is configured
                if(!isset($queryData['oauth_token'])) {

                    $parameters = array(
                        'client_id' => $this->id,
                        'client_secret' => $this->secret,
                    );
                } else {
                    $parameters['oauth_token'] = $queryData['oauth_token'];
                }

                /**
                 * @todo improve this block of code
                 */
                if(!empty($queryData['options'])) {
                    foreach($queryData['options'] as $key => $value) {
                        $parameters[$key] = $value;
                    }
                }

                debug($this->url.$query);

                $result = $this->socket->get($this->url.$query, $parameters);
                
                return json_decode($result, true);
            
        }
        
    }

    public function create($model, $fields = array(), $values = array()) {

        /*
         * This function is used to create new elements (Checkins, venues, etc). 
         */

         $url = $this->url.$model->useTable.'/';

         $data = combine($fields, $values);

         $socket = new HttpSocket();

         $result = $socket->post($url, $data);


        
    }
    
}
