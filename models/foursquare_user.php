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

    public function beforeFind($queryData = array()) {

        if(!isset($queryData['oauth_token'])) {
            $queryData['oauth_token'] = Configure::read('Foursquare.oauth_token');
        }
        
        return $queryData;
    }


    public function getUser($id = null) {

        if(!$id) $id = 'self';

        $options = array(
                    'resource' => 'users',
                    'id' => $id,
        );
        
        $user = $this->find('all', $options);

        return $user; 
    }

    public function getLeaderboard() {

        $leaderboard = $this->find('all', array(
            'resource' => 'users',
            'general' =>  'leaderboard',
        ));

        return $leaderboard;

    }

    public function search() {
        $leaderboard = $this->find('all', array(
            'resource' => 'users',
            'general' => 'search',
        ));
        
    }

}
?>
