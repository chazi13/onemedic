<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Jenssegers\Date\Date;

class Generate extends Admin_Controller
{
	private $faker;
	private $key = 'AIzaSyBBVe8qLWSL-jl6WCavZabdmevEcki0fEk';

	public function __construct()
	{
		parent::__construct();
		
		// $this->faker = Faker\Factory::create();
		$this->faker = Faker\Factory::create('id_ID');

		$this->title = 'Generate Data';
		$this->icon = 'fa fa-cogs';

		$this->load->vars(array(
			'title' => $this->title,
			'icon' => $this->icon
		));
	}

	public function index()
	{
		$this->load->helper('form');
		$this->template
				->set_layout('admin')
				->build('utils/generate/index');
	}

	public function delivery_order()
	{
		$client_uid = $this->input->post('client_uid');
		$order_date = $this->input->post('order_date');
		$num_of_orders = $this->input->post('num_of_orders');

		if ($this->input->post('run') != 'Generate' || empty($client_uid) || empty($order_date) || empty($num_of_orders)) {
			$this->template->set_flashdata('error', 'All data is required!');
			redirect($this->controller_uri);
		}

		$order_date = Date::createFromFormat('d/m/Y', $order_date)->format('Y-m-d');

		$this->load->model('delivery_order_model');
		$this->load->model('delivery_order_detail_model');
		$this->load->model('client_model');
		$this->load->model('client_location_model');
		$this->load->model('client_product_model');
		$this->load->model('client_customer_model');
		$this->load->model('client_customer_address_model');

		$client = $this->client_model->get_by_uid($client_uid);
		if (!$client) {
			$this->template->set_flashdata('error', "Client UID \'$client_uid\' not found!");
			redirect($this->controller_uri);
		}

		$products = $this->client_product_model->get_by_client_id($client->id);
		$client_locations = $this->client_location_model->get_by_client_id($client->id);
		$customers = $this->client_customer_model->get_by_client_id($client->id);
		$unique_customer = array();

		for ($i = 0; $i < $num_of_orders; $i++) {
			$client_location_index = $this->faker->numberBetween(0, count($client_locations) - 1);
			$client_location = $client_locations[$client_location_index];
			
			$customer = null;
			do {
				$customer_index = $this->faker->numberBetween(0, count($customers) - 1);
				$customer = $customers[$customer_index];
			} while (isset($unique_customer[$customer->uid]));
			$unique_customer[$customer->uid] = '';

			$customer_addresses = $this->client_customer_address_model->get_by_client_customer_id($customer->id);
			$customer_address_index = $this->faker->numberBetween(0, count($customer_addresses) - 1);
			$customer_address = $customer_addresses[$customer_address_index];

			$data = array(
				'do_num' => $this->delivery_order_model->set_do_num(),
				'order_date' => $order_date,
				'delivery_date' => $order_date,
				'service_id' => 1, 
				'branch_id' => $client->branch_id, 
				'client_id' => $client->id, 
				'client_location_id' => $client_location->id,
				'client_customer_id' => $customer->id,
				'client_customer_address_id' => $customer_address->id, 
				'sender_name' => $client->name,
				'sender_phone' => $client_location->phone,
				'sender_address' => $client_location->address,
				'sender_region' => $client_location->region_id,
				'sender_postalcode' => $client_location->postalcode,
				'sender_location' => $client_location->location,
				'recipient_name' => $customer->name,
				'recipient_phone' => $customer->phone,
				'recipient_address' => $customer_address->address,
				'recipient_region' => $customer_address->region_id,
				'recipient_postalcode' => $customer_address->postal_code,
				'recipient_location' => $customer_address->location,
				'ref_num' => $this->faker->isbn13,
				'notes' => null,
				'number_of_items' => 0,
				'total_weight' => 0,
				'estimated_route' => null,
				'estimated_distance' => 0,
				'estimated_cost' => 0,
				'distance' => 0,
				'cost' => 0,
				'status' => 'new',
			);

			// Direction
			$sender_location = json_decode($data['sender_location']);
			$recipient_location = json_decode($data['recipient_location']);
			$direction_url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . $sender_location->lat . ',' . $sender_location->lng . '&destination=' . $recipient_location->lat . ',' . $recipient_location->lng . '&key=' . $this->key . '&lang=id&region=id';
			$direction_result = file_get_contents($direction_url);
			$direction = json_decode($direction_result);
			$data['estimated_distance'] = $data['distance'] = $direction->routes[0]->legs[0]->distance->value / 1000;
			$data['estimated_route'] = $direction_result;

			// Details
			$details = array();
			$item_number = $this->faker->numberBetween(1, 5);
			for ($j = 0; $j < $item_number; $j++) {
				$product_index = $this->faker->numberBetween(0, count($products) - 1);
				$product = $products[$product_index];

				$details[] = array(
					'client_product_id' => $product->id,
					'name' => $product->name,
					'quantity' => $this->faker->numberBetween(1, 10),
					'weight' => $product->weight,
					'length' => $product->length,
					'width' => $product->width,
					'height' => $product->height
				);
			}
			foreach($details as $detail) {
				$data['number_of_items'] += $detail['quantity'];
				$data['total_weight'] += $detail['weight'];
			}

			// Cost
			$data['estimated_cost'] = $data['cost'] = $data['estimated_distance'] * $data['total_weight'] * 50;

			// Insert data
			$do_id = $this->delivery_order_model->insert($data);
			foreach($details as $detail) {
				$detail['delivery_order_id'] = $do_id;
				$this->delivery_order_detail_model->insert($detail);
			}
		}
		
		$this->template->set_flashdata('success', "$num_of_orders new delivery orders has been successfully generated for client <strong>$client->name</strong>.");
		redirect($this->controller_uri);
	}
}
