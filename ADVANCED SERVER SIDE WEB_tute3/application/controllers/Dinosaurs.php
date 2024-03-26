<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dinosaurs extends CI_Controller {
    public function periods() {

        // Load the view containing links to geological periods
        $this->load->view('periods');
    }

    public function getinfo($period) {
        
        // Load the model to retrieve information about the geological period
        $this->load->model('Dinosaur_model');
        $data['period_info'] = $this->Dinosaur_model->get_period_info($period);

        // Load the view to display the information
        $this->load->view('period_info', $data);
    }
}
?>
