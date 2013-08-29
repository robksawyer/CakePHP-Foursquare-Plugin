<?php
App::uses('ComponentCollection', 'Controller');
App::uses('Component', 'Controller');
App::uses('FoursquareUtilsComponent', 'Foursquare.Controller/Component');

/**
 * FoursquareUtilsComponent Test Case
 *
 */
class FoursquareUtilsComponentTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$Collection = new ComponentCollection();
		$this->FoursquareUtils = new FoursquareUtilsComponent($Collection);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FoursquareUtils);

		parent::tearDown();
	}

/**
 * testGetAuthUrl method
 *
 * @return void
 */
	public function testGetAuthUrl() {
	}

/**
 * testGetToken method
 *
 * @return void
 */
	public function testGetToken() {
	}

}
