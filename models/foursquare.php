<?php


class Foursquare extends FoursquareAppModel {

    public $useDbConfig = 'foursquare';

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
