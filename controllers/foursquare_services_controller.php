<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of foursquares_controller
 *
 * @author asmerkin
 */
class FoursquareServicesController extends FoursquareAppController {

    public $uses = array('Foursquare.Foursquare');

    public $components = array('Foursquare.FoursquareUtils');

    function index() {

//        debug($this->Foursquare->getVenue(18225129));
        
    }

    public function authorize() {

        $url = $this->FoursquareUtils->getAuthUrl();

        $this->redirect($url);
    }

    public function getToken() {
        
        $code = $this->params['url']['code'];
        $token = $this->Foursquare->getToken($code);
        
        $this->Session->write('oauth_token', $token->access_token);
        
        Configure::write('Foursquare.oauth_token', $token->access_token);
        $this->redirect(array('action' => 'index'));
        
    }


}
?>
