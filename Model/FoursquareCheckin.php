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
App::uses('DataSource', 'Model/Datasource');
App::uses('DboSource', 'Model/Datasource');*/
class FoursquareCheckin extends FoursquareAppModel {

	//public $useDbConfig = 'foursquare';

	public $useTable = 'checkins';

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

	public function beforeSave($options = array()) {
		/*
		 * If no oauth_token is passed then it's fetched from Configure
		 */
		if(!isset($this->data['FoursquareCheckin']['oauth_token'])) {
			$this->data['FoursquareCheckin']['oauth_token'] = Configure::read('Foursquare.oauth_token');
		}
		return true;
	}


/**
 * addCheckin method
 * @source https://developer.foursquare.com/docs/checkins/add
 * @param string id The venue id
 * @param array 
 * @return array 
 */
	public function addCheckin($id = null,$data = array()){
		$defaults = array(
        	'id' => $id,
        	'venueId' => $id,
        	'action' => 'add'
        );
        $data = array_merge($defaults,$data);
		/*$fields = array(
			'll','shout','venueId','oauth_token'
        );*/
        //Try to read the oauth token from the Session
        if(!$data['oauth_token']){
            $data['oauth_token'] = Session::read('Foursquare.oauth_token');
        }
        $this->create();
		if($result = $this->save($data)){
			debug($result);
			return $result;
		}else{
			return false;
		}
	}

}
?>
