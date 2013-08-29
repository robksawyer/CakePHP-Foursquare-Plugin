<?php
App::uses('FoursquareVenue', 'Foursquare.Model');

/**
 * FoursquareVenue Test Case
 *
 */
class FoursquareVenueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.foursquare.foursquare_venue'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FoursquareVenue = ClassRegistry::init('Foursquare.FoursquareVenue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FoursquareVenue);

		parent::tearDown();
	}

/**
 * testGetVenue method
 *
 * @return void
 */
	public function testGetVenue() {
	}

/**
 * testSearch method
 *
 * @return void
 */
	public function testSearch() {
	}

/**
 * testGetCategories method
 *
 * @return void
 */
	public function testGetCategories() {
	}

/**
 * testGetNearbyVenues method
 *
 * @return void
 */
	public function testGetNearbyVenues() {
	}

}
