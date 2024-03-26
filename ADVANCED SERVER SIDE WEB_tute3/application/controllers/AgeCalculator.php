<?php
class AgeCalculator extends CI_Controller {


    public function index() {
        
        $this->load->helper('url'); // Load URL Helper
        $this->load->view('birthday_form');
    }

    public function calculate_age() {

        $this->load->helper('url'); // Load URL Helper
        $birthdate = $this->input->post('birthdate');
        $age = $this->calculateAge($birthdate);
        $data['age'] = $age;
        $this->load->view('age_result', $data);

        // $birthdate = $this->input->post('birthdate');
        // $age = $this->calculateAge($birthdate);
        // $data['age'] = $age;
        // $this->load->view('age_result', $data);
    }

    private function calculateAge($birthdate) {
        $today = date("Y-m-d");
        $diff = date_diff(date_create($birthdate), date_create($today));
        return $diff->format('%y');
    }
}
?>
