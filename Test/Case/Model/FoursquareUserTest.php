<?php
App::uses('FoursquareUser', 'Foursquare.Model');

/**
 * FoursquareUser Test Case
 *
 */
class FoursquareUserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.foursquare.foursquare_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FoursquareUser = ClassRegistry::init('Foursquare.FoursquareUser');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FoursquareUser);

		parent::tearDown();
	}

/**
 * testGetUser method
 *
 * @return void
 */
	public function testGetUser() {
	}

/**
 * testGetLeaderboard method
 *
 * @return void
 */
	public function testGetLeaderboard() {
	}

/**
 * testSearch method
 *
 * @return void
 */
	public function testSearch() {
	}

}
