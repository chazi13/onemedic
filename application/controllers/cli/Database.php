<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Database extends CI_Controller
{
    public function seeder($class = '')
    {
        if (! $this->input->is_cli_request()) {
            show_error('Seeding can only happen from the command line.');
        }

        if ($class == 'all') {
            $class = '';
        }

        $this->load->library('seeder');

        if (!empty($class)) {
            $this->seeder->call($class);
        } else {
			// $this->seeder->call('BranchSeeder');
			// $this->seeder->call('BranchLocationSeeder');
			// $this->seeder->call('BranchUserSeeder');
			// $this->seeder->call('BranchDriverSeeder');
			// $this->seeder->call('BranchVehicleSeeder');
			// $this->seeder->call('ClientSeeder');
			// $this->seeder->call('ClientProductSeeder');
			// $this->seeder->call('ClientUserSeeder');
			// $this->seeder->call('ClientCustomerSeeder');
			// $this->seeder->call('ClientLocationSeeder');				// Repeat
			// $this->seeder->call('ClientAddLocationSeeder');				// Repeat
			// $this->seeder->call('ClientCustomerAddLocationSeeder');		// Repeat
            $this->seeder->call('DeliveryOrderSeeder');
        }
    }

    public function migrate()
    {
        $this->load->library('migration');

        if ($this->migration->current() === false) {
            show_error($this->migration->error_string());
        }
    }
}
