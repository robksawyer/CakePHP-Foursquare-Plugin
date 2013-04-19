<?php
/**
 * Foursquare Users Model.
 *
 * This model contains all user related methods for API interactions
 *
 * @author Andrés Smerkin <info@andressmerkin.com.ar>
 * @link http://www.andressmerkin.com.ar
 * @copyright (c) 2011 Andrés Smerkin
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
/*App::uses('CakeSession', 'Model/Datasource');
App::uses('DboSource', 'Model/Datasource');*/
class FoursquareUser extends FoursquareAppModel {

    //public $useDbConfig = 'foursquare';

    public $useTable = 'users';

    public function beforeFind($queryData = array()) {
        /**
         * @todo improve this chunk of code.
         *
         * If id => false then the oauth_token shoudln't be used
         */

        /*
         * If no oauth_token is passed then it's fetched from Configure
         */
        if(!isset($queryData['oauth_token'])) {
            $queryData['oauth_token'] = Configure::read('Foursquare.oauth_token');
        }
        return $queryData;
    }

/**
 * Getting the User Info
 *
 * Gets the user information based on a given id. If not id is passed then
 * the method returns the info for te logged in user (self)
 * 
 * @link https://developer.foursquare.com/docs/users/users.html
 *
 * @param string $id Id of the user
 * @return mixed Array with the response of the user
 */
    public function getUser($id = null, $params = array()) {
        if(!$id) $id = 'self';
        //Try to read the oauth token from the Session
        if(!$params){
            $params['oauth_token'] = Session::read('Foursquare.oauth_token');
        }
        $options = array(
            'id' => $id,
            'options' => $params
        );
        $user = $this->find('all', $options);
        if(!empty($user['meta']['errorType'])){
            //There was an error
            return $user['meta']['errorDetail'];
        }else if($user['meta']['code'] == 200){
            return $user['response']['user'];
        }else{
            return false;
        }
        
    }

/**
 * Returns the user's leaderboard.
 *
 * @link https://developer.foursquare.com/docs/users/leaderboard.html
 *
 * @param mixed $options User options
 * @return mixed The user's leaderboard
 */
    public function getLeaderboard($neighbors = null) {
        $parameters =  array(
            'general' =>  'leaderboard',
        );
        if(isset($neighbors)) {
            $parameters['options'] = array('neighbors' => $neighbors);
        }
        $leaderboard = $this->find('all', $parameters);
        return $leaderboard;
    }

    
/**
 * search method
 */
    public function search() {
        $leaderboard = $this->find('all', array(
            'general' => 'search',
        ));
    }

}
?>
