<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dinosaur_model extends CI_Model {

    // Array to store information about geological periods and associated dinosaurs
    private $periods = array(
        'Triassic' => 'Plesiosaurs',
        'Jurassic' => 'Stegosaurus, Brachiosaurus',
        'Cretaceous' => 'Tyrannosaurus Rex, Triceratops'
    );

    public function get_period_info($period) {
        
        // Check if the requested period exists in the array
        if (array_key_exists($period, $this->periods)) {
            return $this->periods[$period];
        } else {
            return 'Information not available for this period.';
        }
    }
}
?>
