<?php


class Foursquare extends FoursquareAppModel {

    public $useDbConfig = 'foursquare';

    public function getToken($code = null) {

        $url = 'https://es.foursquare.com/oauth2/access_token';

        $parameters = array(
            'client_id' => 'TFEGAYBN1KK2TT3M214NWREIDXK5LMMYW05KLTHYHEJ2JI4W',
            'client_secret' => '5DOY5WMQPICQYTRBZUTE2ULQQVBW4M21VVH2EQLCQT2LQM4E',
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'http://localhost/sites/plugins/foursquare/foursquare_services/getToken',
            'code' => $code,
        );

        App::import('Core', 'HttpSocket');
        $socket = new HttpSocket();

        $token = $socket->get($url,$parameters);

        return json_decode($token);

    }

    public function getVenue($id = null, $token = null) {

        if(!$id) return false;

        if(isset($token)) {

        $result = $this->find('all', array(
                'elements' => array('type' => 'venues', 'id' => $id),
                'token' => $token
                ));

        return json_decode($result);

        }
        
    }
}

?>
