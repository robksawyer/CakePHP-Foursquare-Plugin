<?php
/**
 * Foursquare Venue Model.
 *
 * This model contains all Venue related methods for API interactions
 *
 * @author Andrés Smerkin <info@andressmerkin.com.ar>
 * @link http://www.andressmerkin.com.ar
 * @copyright (c) 2011 Andrés Smerkin
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */
class FoursquareVenue extends FoursquareAppModel {

    //public $useDbConfig = 'foursquare';

    public $useTable = 'venues';

    public $categoryIds = '4d4b7105d754a06374d81259,4d4b7105d754a06376d81259,4bf58dd8d48988d1f9941735,4bf58dd8d48988d11e951735,4bf58dd8d48988d1f5941735,4bf58dd8d48988d118951735,50aa9e744b90af0d42d5de0e,4bf58dd8d48988d119951735,50be8ee891d4fa8dcc7199a7,4bf58dd8d48988d1ef931735,4eb1bc533b7b2c5b1d4306cb,4bf58dd8d48988d1fa931735,4f04b25d2fb6e1c99f3db0c0,4bf58dd8d48988d146941735';
/**
 * Gets a Venue based on its id
 *
 * @param integer $id Venue ID
 * @return mixed result array
 */
    public function getVenue($id = null) {
        if(!$id) return false;
        //try{
        	return $this->find('all', array('id' => $id));
        //} catch(Exception $e){
        //	debug($e);
        //	return false;
        //}
    }

/**
 * Search Venues
 * Returns a list of venues near the current location, optionally matching a search term. 
 * @source https://developer.foursquare.com/docs/venues/search
 * 
 * To ensure the best possible results, pay attention to the intent parameter below. And if you're looking for "top" venues or recommended venues, 
 * use the explore endpoint instead. 
 * If lat and long is provided, each venue includes a distance. If authenticated, the method will return venue metadata related to you and 
 * your friends. If you do not authenticate, you will not get this data.  
 * Note that most of the fields returned inside venue can be optional. The user may create a venue that has no address, city or state (the venue is 
 * created instead at the geolat/geolong specified). Your client should handle these conditions safely.  
 * You'll also notice a stats block that reveals some count data about the venue. herenow shows the number of people currently there 
 * (this value can be 0).
 *
 * $options can include the following properties:
 * `query` - A search term to be applied against venue names. Example: donuts
 * `ll` - (Required unless near is provided. Required for query searches) Latitude and longitude of the user's location. Optional if using intent=global Example: 44.3,37.2
 */
	public function search($options = array()){
		$queryData = array(
			'action' => 'search',
			'options' => array(
				'limit' => 10,
				'intent' => 'match'
			)
		);
		$queryData['options'] = array_merge($queryData['options'], $options);
		//try{
			return $this->find('all', $queryData);
		/*}catch(Exception $e){
			echo $e;
			return true;
		}*/
		
	}

/**
 * getCategories method
 * This method handles pulling the latest list of categories from Foursquare
 * @source https://developer.foursquare.com/docs/venues/categories.html
 * @param 
 * @return array
 */
	public function getCategories(){
		$queryData = array(
			'action' => 'categories',
			'options' => array()
		);
		$foursquare_categories = Cache::read('foursquare_categories');
		if (empty($foursquare_categories) || !$foursquare_categories){
			$foursquare_categories = $this->find('all', $queryData);
			Cache::set(array('duration' => '+8 hours'));
			Cache::write('foursquare_categories', $foursquare_categories);
		}
		return $foursquare_categories;
	}

/**
 * getNearbyVenues method
 * A helper method to find nearby Venues on foursquare
 * @param string lat
 * @param string lng
 * @param int limit The total records to pull
 * @param array 
 */
	public function getNearbyVenues($lat='',$lng='',$limit = 25,$category='food'){
		//TODO: Add more categories
		//if($category == "food"){
			//$categoryIds = '4d4b7105d754a06374d81259,4d4b7105d754a06376d81259,4bf58dd8d48988d1f9941735,4bf58dd8d48988d11e951735,4bf58dd8d48988d1f5941735,4bf58dd8d48988d118951735,50aa9e744b90af0d42d5de0e,4bf58dd8d48988d119951735,50be8ee891d4fa8dcc7199a7,4bf58dd8d48988d1ef931735,4eb1bc533b7b2c5b1d4306cb,4bf58dd8d48988d1fa931735,4f04b25d2fb6e1c99f3db0c0,4bf58dd8d48988d146941735';
		//}
		//Search for the place on Foursquare
		$options = array(
			//'query' => $item['name'],
			'll' => $lat.','.$lng,
			'limit' => $limit,
			'radius' => 200,
			'intent' => 'checkin',
			'categoryId' => $this->categoryIds
			//Food, Nightlife Spot,Cheese Shop,Food Court,Gourmet Shop,Grocery Store,
			//Health Food Store,Wine Shop, Market,Airport Food Court,Airport Lounge,Hotel,Travel Lounge
		);
		return $this->search($options);
	}

}
?>
