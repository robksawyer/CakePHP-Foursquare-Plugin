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

class FoursquareUser extends FoursquareAppModel {


    public $useDbConfig = 'foursquare';

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
    public function getUser($id = null) {

        if(!$id) $id = 'self';

        $options = array(
                    'id' => $id,
        );
        
        $user = $this->find('all', $options);

        return $user; 
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

    


    public function search() {
        $leaderboard = $this->find('all', array(
            'general' => 'search',
        ));
        
    }

}
?>
