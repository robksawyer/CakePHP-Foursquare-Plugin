<?php

class FoursquareAppController extends AppController {

    public function beforeFilter() {

        if($this->Session->read('oauth_token')) {
            Configure::write('Foursquare.oauth_token', $this->Session->read('oauth_token'));
        }

    }

}

?>