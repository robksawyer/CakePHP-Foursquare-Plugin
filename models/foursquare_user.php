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

    public function getUser($id = null) {

        if(!$id) return false;

        $user = $this->find('all', array(
                    'path' => array('users'),
                    'id' => $id,
                    'oauth_token' => Configure::read('Foursquare.oauth_token'),
                ));

        return $user; 
    }

    public function getLeaderboard() {

        $leaderboard = $this->find('all', array(
            'path' => array('users', 'leaderboard'),
            'oauth_token' => Configure::read('Foursquare.oauth_token'),

        ));

        return $leaderboard;

    }

}
?>
