<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');
App::uses('DataSource', 'Model/Datasource');
App::uses('DboSource', 'Model/Datasource');
class FoursquareAppModel extends AppModel {
	public $useDbConfig = 'Foursquare.foursquare';
}

?>