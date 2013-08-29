<?php
App::uses('FoursquareAppModel', 'Foursquare.Model');

/**
 * FoursquareAppModel Test Case
 *
 */
class FoursquareAppModelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.foursquare.foursquare_app_model'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FoursquareAppModel = ClassRegistry::init('Foursquare.FoursquareAppModel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FoursquareAppModel);

		parent::tearDown();
	}

}
