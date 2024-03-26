<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dictionary extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary models/libraries
        $this->load->model('Dictionary_model');
    }

    public function index() {
        // Load the view
        $this->load->view('dictionary_view');
    }

    public function get_definition() {
        // Get the word from the request
        $word = $this->input->post('word');

        // Get the definition from the model
        $definition = $this->Dictionary_model->get_definition($word);

        // Return the definition as a string
        echo $definition;
    }
}
