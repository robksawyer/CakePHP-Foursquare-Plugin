<?php
/**
 * Foursquare Model to interact with the Foursquare Datasource.
 *
 * @author Andrés Smerkin <info@andressmerkin.com.ar>
 * @link http://www.andressmerkin.com.ar
 * @copyright (c) 2011 Andrés Smerkin
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

class Foursquare extends FoursquareAppModel {

    // Setting the Foursquare datasource
    public $useDbConfig = 'foursquare';

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


    /**
     * Gets Infromation from a Venue based on its ID
     *
     * @param integer $id Id of the venue
     * @return array The Venue Result
     */
    public function getVenue($id = null) {

        if(!$id) return false;

        $result = $this->find('all', array(
                'path' => array('venues'),
                'id' => $id,
        ));

        return json_decode($result, true);

        
    }
}

?>
