<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of foursquare_user
 *
 * @author asmerkin
 */
class FoursquareUser extends FoursquareAppModel {

    public $useDbConfig = 'foursquare';

    public function getUser($id = null, $aspect = null) {

        if(!$id) $id = 'self';

        $options = array(
                    'resource' => 'users',
                    'id' => $id,
                    'oauth_token' => Configure::read('Foursquare.oauth_token')
        );

        if(isset($aspect)) $options['aspect'] = $aspect;

        $user = $this->find('all', $options);

        return $user; 
    }

    public function getLeaderboard() {

        $leaderboard = $this->find('all', array(
            'path' => array('users', 'leaderboard'),
            'oauth_token' => Configure::read('Foursquare.oauth_token'),

        ));

        return $leaderboard;

    }

    public function search() {
        $leaderboard = $this->find('all', array(
            'path' => array('users', 'search'),
            'oauth_token' => Configure::read('Foursquare.oauth_token'),

        ));
        
    }

}
?>
