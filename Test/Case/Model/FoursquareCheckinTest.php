<?php
App::uses('FoursquareCheckin', 'Foursquare.Model');

/**
 * FoursquareCheckin Test Case
 *
 */
class FoursquareCheckinTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.foursquare.foursquare_checkin'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FoursquareCheckin = ClassRegistry::init('Foursquare.FoursquareCheckin');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FoursquareCheckin);

		parent::tearDown();
	}

/**
 * testAddCheckin method
 *
 * @return void
 */
	public function testAddCheckin() {
	}

}
