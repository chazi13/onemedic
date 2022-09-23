<?php

/**
 * Part of CI PHPUnit Test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 *
 * @property Faker\Faker $faker
 *
 */
class Seeder {

	protected $CI;
	protected $db;
	protected $dbforge;
	protected $faker;
	protected $min_lat = -6.294612;
	protected $min_lng = 106.687151;
	protected $max_lat = -6.124578;
	protected $max_lng = 106.956926;
	protected $coord_norm = 1000000;
	protected $key = 'AIzaSyBBVe8qLWSL-jl6WCavZabdmevEcki0fEk';

	public function __construct()
	{
		$this->CI = & get_instance();

		// Ensure our database is loaded and ready
		$this->CI->load->database();
		$this->CI->load->dbforge();

		// Setup some convenience variables
		$this->db = $this->CI->db;
		$this->dbforge = $this->CI->dbforge;

		// $this->faker = Faker\Factory::create();
		$this->faker = Faker\Factory::create('id_ID');
		$this->faker->seed(1645985237);
	}

	/**
	 * Runs the database seeds. This is where the magic happens.
	 * This method MUST be overridden by the child classes.
	 */
	public function run()
	{

	}

	/**
	 * Run another seeder
	 *
	 * @param string $class Seeder classname
	 */
	public function call($class)
	{
		if (empty($class))
		{
			show_error('No Seeder was specified.');
		}

		$path = APPPATH . 'database/seeds/' . str_ireplace('.php', '', $class) . '.php';
		if (!is_file($path))
		{
			show_error("Unable to find the Seed class: {$class}");
		}

		try
		{
			echo "Seeding $class ... ";
			require $path;
			$seeder = new $class();
			$seeder->run();
			unset($seeder);
			echo " Done\n";
		}
		catch (\Exception $e)
		{
			show_error($e->getMessage(), $e->getCode());
		}

		return TRUE;
	}

	public function generateLocation()
	{
		$data = array();
		$location = array();
		do {
			$location = array(
				'lat' => sprintf("%8.6f", $this->min_lat + (mt_rand(0, abs(($this->max_lat * $this->coord_norm) - ($this->min_lat * $this->coord_norm))) / $this->coord_norm)),
				'lng' => sprintf("%8.6f",$this->min_lng + (mt_rand(0, abs(($this->max_lng * $this->coord_norm) - ($this->min_lng * $this->coord_norm))) / $this->coord_norm))
			);
			$result_json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . implode(',', $location) . '&key=' . $this->key . '&lang=id&region=id');
			$response = json_decode($result_json);
			sleep($this->faker->numberBetween(1, 5));		// Diperlambat, suka error dari Google: REQUEST_DENIED: This IP, site or mobile application is not authorized to use this API key.
			if ($response->status != 'OK') {
				echo $response->status . ': ' . $response->error_message;
				die();
			}
			$results = $response->results;
			if (isset($results[0])) {
				$result = $results[0];
				$address_comp = $result->address_components[0];
				$address = $address_comp->long_name;
			} else {
				$address = 'Unnamed Road';
			}
		} while ($address == 'Unnamed Road');

		$data['address'] = str_replace(', ', "\n", $result->formatted_address);
		foreach($result->address_components as $comp) {
			if (isset($comp->types[0])) {
				if ($comp->types[0] == 'postal_code') {
					$data['postalcode'] = $comp->long_name;
				}
			}
		}
		$data['location'] = json_encode($location);
		return $data;
	}
	
	public function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// replace '-' with '.'
		$text = preg_replace('/-/', '.', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}

	public function __get($property)
	{
		return $this->CI->$property;
	}

}
