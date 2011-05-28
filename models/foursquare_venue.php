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

    public $useDbConfig = 'foursquare';

    public $useTable = 'venues';

    /**
     * Gets a Venue based on its id
     *
     * @param integer $id Venue ID
     * @return mixed result array
     */
    public function getVenue($id = null) {
        
        if(!$id) return false;

        return $this->find('all', array('id' => $id));

    }

}
?>
