<?php

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


    
}


?>
