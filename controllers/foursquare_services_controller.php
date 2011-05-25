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

    function index() {

        debug($this->Foursquare->getVenue(578413,$this->Session->read('token')));
        
    }

    public function authorize() {
        
//        $auth = $this->Foursquare->authorize();

        $this->redirect('https://es.foursquare.com/oauth2/authenticate?client_id=TFEGAYBN1KK2TT3M214NWREIDXK5LMMYW05KLTHYHEJ2JI4W&response_type=code&redirect_uri=http://localhost/sites/plugins/foursquare/foursquare_services/getToken');
    }

    public function getToken() {
        $code = $this->params['url']['code'];

        $token = $this->Foursquare->getToken($code);

        $this->Session->write('token', $token->access_token);
        $this->redirect(array('action' => 'index'));
        
    }


}
?>
