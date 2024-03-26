<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
//http://localhost/Tutorials/tute33/index.php/AgeCalculator
// class AgeCalculator extends CI_Controller {

//     public function index() {
//         $this->load->helper('url'); // Load URL helper
//         $this->load->view('dob_form');
//     }

//     public function calculate_age() {
//         $this->load->helper('url'); // Load URL helper
//         $this->load->model('Age_model');
        
//         // Get the date of birth from the form
//         $dob = $this->input->post('dob');

//         // Call the model function to calculate age
//         $age = $this->Age_model->calculate_age($dob);

//         // Pass the age to the view
//         $data['age'] = $age;
//         $this->load->view('age_result', $data);
//     }


// }

//defined('BASEPATH') OR exit('No direct script access allowed');

// class Movies extends CI_Controller {
    
//     public function index() {
//         $this->load->helper('url'); // Load URL helper
//         $this->load->view('movies_index');
//     }
    
//     public function search() {
//         // Your search logic here
//         $genre = $this->input->get('genre');
//         $this->load->model('Moviemodel');
//         $movies = $this->Moviemodel->get_movies_by_genre($genre);
        
//         if ($movies) {
//             $data['movies'] = $movies;
//             $this->load->view('movies_search_results', $data);
//         } else {
//             $data['error'] = 'No movies found for the specified genre.';
//             $this->load->view('movies_error', $data);
//         }
//     }
    
//     public function allmovies() {// this function is called when the user clicks on the "All Movies" link
//         // Your logic to display all movies
//         $this->load->model('Moviemodel');
//         $data['movies'] = $this->Moviemodel->get_all_movies();
//         $this->load->view('all_movies_view', $data);
//     }
// }

defined('BASEPATH') OR exit('No direct script access allowed');

class Movies extends CI_Controller {
    
    public function index() {
        $this->load->helper('url'); // Load URL helper
        $this->load->model('Moviemodel');
        $data['genres'] = $this->Moviemodel->get_all_genres();
        $this->load->view('movieview', $data);
    }
    public function landingpage() {// this function is called when the user clicks on the "Back to Landing page" link
        $this->load->helper('url'); // Load URL helper
        $this->load->view('movies_index');
    }
   
    public function search() {
        $title = $this->input->get('title');
        $genre = $this->input->get('genre');
        $this->load->model('Moviemodel');
        
        if (!empty($title)) {
            $movies = $this->Moviemodel->search_by_title($title);
        } elseif (!empty($genre)) {
            $movies = $this->Moviemodel->get_movies_by_genre($genre);
        } else {
            $movies = false;
        }
        
        if ($movies) {
            $data['movies'] = $movies;
            $this->load->view('movies_search_results', $data);
        } else {
            $data['error'] = 'No movies found.';
            $this->load->view('movies_error', $data);
        }
    }
    
    public function allmovies() {
        $this->load->model('Moviemodel');
        $data['movies'] = $this->Moviemodel->get_all_movies();
        $this->load->view('all_movies_view', $data);
    }

    public function genres() {
        $this->load->model('Moviemodel');
        $data['genres'] = $this->Moviemodel->get_all_genres();
        $this->load->view('movie_genres', $data);
    }
    
    public function genre($genre) {
        $this->load->model('Moviemodel');
        $data['movies'] = $this->Moviemodel->get_movies_by_genre($genre);
        $this->load->view('movies_by_genre', $data);
    }
}

?>