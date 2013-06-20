<?php

/**
 * CakePHP DataSource for accessing the Foursquare v2 (OAuth2) API.
 *
 * Datasource to access the Foursquare new API
 *
 * @author Andrés Smerkin <info@andressmerkin.com.ar>
 * @link http://www.andressmerkin.com.ar
 * @copyright (c) 2011 Andrés Smerkin
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

App::uses('DataSource', 'Model/Datasource');
App::uses('DboSource', 'Model/Datasource');
App::uses('HttpSocket', 'Network/Http');

class FoursquareSource extends DataSource {
	
	private $id = null;
	private $secret = null; 
	private $Http = null;
	private $url = 'https://api.foursquare.com/v2/';

	//This is now required by Foursquare (http://bit.ly/vywCav)
	private $version = '20130101';

	public $description = 'Foursquare API (Based on OAuth2)';
	
/**
 * Our default config options. These options will be customized in our
 * ``app/Config/database.php`` and will be merged in the ``__construct()``.
 */
	public $config = array(
		'id' => '',
		'secret' => ''
	);

/**
 * If we want to create() or update() we need to specify the fields
 * available. We use the same array keys as we do with CakeSchema, eg.
 * fixtures and schema migrations.
 * Example: https://developer.foursquare.com/docs/checkins/add
 */
	protected $_schema = array(
		'venueId' => array(
            'type' => 'text',
            'null' => false,
            'key' => 'primary',
            'length' => 255,
        ),
        'eventId' => array(
            'type' => 'text',
            'null' => true,
            'length' => 255,
        ),
        'shout' => array(
            'type' => 'text',
            'null' => true,
            'length' => 255,
        ),
        'll' => array(
            'type' => 'text',
            'null' => true,
            'length' => 255,
        ),
        'oauth_token' => array(
        	'type' => 'text',
            'null' => true,
            'length' => 255,
        ),
        'mentions' => array(
        	'type' => 'text',
            'null' => true,
            'length' => 255
        ),
        'broadcast' => array(
        	'type' => 'text',
            'null' => true,
            'length' => 255
        ),
        'llAcc' => array(
        	'type' => 'integer',
            'null' => true,
            'length' => 11
        ),
        'alt' => array(
        	'type' => 'integer',
            'null' => true,
            'length' => 11
        ),
        'altAcc' => array(
        	'type' => 'integer',
            'null' => true,
            'length' => 11
        )
	);


/**
 * 
 */
	public function __construct($config) {
		parent::__construct($config);

		$this->Http = new HttpSocket();
		$this->id = $this->config['id'];
		$this->secret = $this->config['secret'];
	}

/**
 * Since datasources normally connect to a database there are a few things
 * we must change to get them to work without a database.
 */

/**
 * listSources() is for caching. You'll likely want to implement caching in
 * your own way with a custom datasource. So just ``return null``.
 */
	public function listSources($data = null) {
		return null;
	}

/**
 * describe() tells the model your schema for ``Model::save()``.
 *
 * You may want a different schema for each model but still use a single
 * datasource. If this is your case then set a ``schema`` property on your
 * models and simply return ``$model->schema`` here instead.
 */
	public function describe($model) {
		return $this->_schema;
	}

/**
 * calculate() is for determining how we will count the records and is
 * required to get ``update()`` and ``delete()`` to work.
 *
 * We don't count the records here but return a string to be passed to
 * ``read()`` which will do the actual counting. The easiest way is to just
 * return the string 'COUNT' and check for it in ``read()`` where
 * ``$data['fields'] == 'COUNT'``.
 */
	public function calculate(Model $model, $func, $params = array()) {
		return 'COUNT';
	}


/*
 * The format of $queryData shoud be the following
 *
 * 'resource', 'general', 'aspect', 'action', 'id'
 *
 *  These are the four elements in which the API is divided. 
 */
	public function read(Model $model, $queryData = array()) {

		if(!empty($queryData)) {

			$defaultOptions = array(
			   "v" => $this->version //This is now required by Foursquare (http://bit.ly/vywCav)
			);
			if(!empty($queryData['options'])){
				$queryData['options'] = array_merge($defaultOptions, $queryData['options']);
			}else{
				 $queryData['options'] = $defaultOptions;
			}

			/*
			 * Here the endpoint is the table that was configured Model::useTable
			 */
			$query = $model->useTable;

			if(isset($queryData['general'])) {
				$query .= '/'.$queryData['general'];
				unset ($queryData['id']);
				unset ($queryData['aspect']);
				unset ($queryData['action']);
			}

			if(isset($queryData['id']))
				$query .='/'. $queryData['id'];
			 

			if(isset($queryData['aspect'])) {
				$query .= '/'.$queryData['aspect'];
				unset ($queryData['action']);
			}
			
			if(isset($queryData['action']))
				$query .= '/'.$queryData['action'];

				//If not oauth_token is set then secret key is configured
				if(!isset($queryData['oauth_token'])) {
					$parameters = array(
						'client_id' => $this->id,
						'client_secret' => $this->secret,
					);
				} else {
					$parameters['oauth_token'] = $queryData['oauth_token'];
				}

				/**
				 * @todo improve this block of code
				 */
				if(!empty($queryData['options'])) {
					foreach($queryData['options'] as $key => $value) {
						$parameters[$key] = $value;
					}
				}

				//debug($this->url.$query);
				/*debug($parameters);
				debug($queryData);
				debug($this->url.$query);*/
				try{
					$result = $this->Http->get($this->url.$query, $parameters);
				}catch(Exception $e){
					debug($e);
				}
				if (is_null($result)) {
					$error = json_last_error();
					throw new CakeException($error);
				}else{
					return json_decode($result, true); 
				}
		}
	}

/**
 * create method
 * Implement the C in CRUD. Calls to ``Model::save()`` without $model->id set arrive here.
 * This function is used to create new elements (Checkins, venues, etc). 
 * @param string $model
 * @param array $fields 
 * @param array $values
 */
	public function create(Model $model, $fields = array(), $values = array()) {
		if(empty($fields['action'])){
			$action = "add";
		}else{
			$action = $fields['action'];
			unset($fields['action']);
		}
		$data = array_combine($fields, $values);
		$url = $this->url.$model->useTable.'/'.$action;
		//$fields['v'] = $this->version; //This is now required by Foursquare (http://bit.ly/vywCav)

		//If not oauth_token is set then secret key is configured
		if(!isset($values['oauth_token'])) {
			$data_t = array(
				'client_id' => $this->id,
				'client_secret' => $this->secret,
			);
			$data = array_merge($data,$data_t);
		} else {
			$data['oauth_token'] = $values['oauth_token'];
		}

		//$socket = new HttpSocket();
		$json = $this->Http->post($url, $data);
		$result = json_decode($json, true);
		if (is_null($result)) {
			$error = json_last_error();
			throw new CakeException($error);
		}
		return $result;
	}


/**
 * Implement the U in CRUD. Calls to ``Model::save()`` with $Model->id
 * set arrive here. Depending on the remote source you can just call
 * ``$this->create()``.
 */
	public function update(Model $model, $fields = null, $values = null, $conditions = null) {
		return $this->create($model, $fields, $values);
	}

/**
 * Implement the D in CRUD. Calls to ``Model::delete()`` arrive here.
 */
	public function delete(Model $model, $id = null) {
		/*$json = $this->Http->get('http://example.com/api/remove.json', array(
			'id' => $id[$model->alias . '.id'],
			'apiKey' => $this->config['apiKey'],
		));
		$res = json_decode($json, true);
		if (is_null($res)) {
			$error = json_last_error();
			throw new CakeException($error);
		}
		return true;*/
	}
	
}
