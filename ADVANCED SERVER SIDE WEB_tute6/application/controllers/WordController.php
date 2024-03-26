<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WordController extends CI_Controller {

    public function index() {
        $this->load->view('word_view');
    }

    public function get_definition() {
        $word = $this->input->post('word');

        // Simulated definitions, replace with actual logic to fetch definitions
        $definitions = [
            'apple' => 'A round fruit with red or green skin and a whitish interior.',
            'banana' => 'A long curved fruit that grows in clusters and has soft pulpy flesh and yellow skin when ripe.',
            'orange' => 'A round juicy citrus fruit with a tough bright reddish-yellow rind.',
        ];

        // Return the definition for the requested word
        if (array_key_exists($word, $definitions)) {
            echo $definitions[$word];
        } else {
            echo "Definition not found for the word '{$word}'.";
        }
    }
}
