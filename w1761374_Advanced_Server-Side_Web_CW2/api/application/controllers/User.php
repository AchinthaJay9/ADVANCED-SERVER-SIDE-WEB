<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property $db
 * @property $session
 * @property $input
 */
class User extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function index(){
		if ($this->input->server('REQUEST_METHOD') === 'POST'){

			$input = json_decode($this->input->raw_input_stream, true);

			$first_name = $input['first_name'];
			$last_name = $input['last_name'];
			$username = $input['username'];
			$email = $input['email'];
			$password = $input['password'];

			$this->db->insert('user', array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'username' => $username,
				'email' => $email,
				'password' => $password,
			));

			$insert_id = $this->db->insert_id();

			if ($this->db->error()['code'] != 0){
				echo json_encode(array(
					'success' => false,
					'message' => $this->db->error()['message'],
				));
				return;
			}

			$this->session->set_userdata('login', $insert_id);

			echo json_encode(array(
				'success' => true,
				'message' => "Registered successfully",
				'id' => $insert_id
			));

			return;
		}
		if ($this->input->server('REQUEST_METHOD') === 'GET'){
			if (!isset($this->session->userdata['login']) ||
				$this->session->userdata['login'] == null){

				echo json_encode(array(
					'success' => false,
					'message' => "Not logged in",
				));
				return;
			}

			$id = $this->session->userdata('login');


			$user = $this->db->get_where('user', array('id' => $id));

			echo json_encode(array(
				'success' => true,
				'data' => $user->row_array(),
			));
			return;
		}
		if ($this->input->server('REQUEST_METHOD') === 'PATCH'){

			$input = json_decode($this->input->raw_input_stream, true);

			if (!isset($this->session->userdata['login']) ||
				$this->session->userdata['login'] == null){

				if (
					!isset($input['email']) || $input['email'] == null
					|| !isset($input['password']) || $input['password'] == null
				){
					echo json_encode(array(
						'success' => false,
						'message' => "Not logged in",
					));
					return;
				}
				$email = $input['email'];

				if (!isset($input['verification']) || $input['verification'] == null
					|| strcmp($input['verification'], "1234") != 0){
					echo json_encode(array(
						'success' => false,
						'message' => "Invalid verification code",
					));
					return;
				}

				$user = $this->db->get_where('user', array('email' => $email))->row_array();

				if ($user == null){
					echo json_encode(array(
						'success' => false,
						'message' => "Email is not registered!",
						'data' => $user,
					));
					return;
				}

				$this->db->where('email', $user['email']);
			}
			else{
				$id = $this->session->userdata('login');
				$this->db->where('id', $id);
			}






			if (isset($input['password']) && $input['password'] != null){

				$password = $input['password'];
				$this->db->update('user', array(
					'password' => $password
				));


				if ($this->db->error()['code'] != 0){
					echo json_encode(array(
						'success' => false,
						'message' => $this->db->error()['message'],
					));
					return;
				}

				echo json_encode(array(
					'success' => true,
					'message' => "Updated successfully",
				));
				return;
			}
			else{
				$first_name = $input['first_name'];
				$last_name = $input['last_name'];
				$username = $input['username'];
				$this->db->update('user', array(
					'first_name' => $first_name,
					'last_name' => $last_name,
					'username' => $username
				));

				if ($this->db->error()['code'] != 0){
					echo json_encode(array(
						'success' => false,
						'message' => $this->db->error()['message'],
					));
					return;
				}

				echo json_encode(array(
					'success' => true,
					'message' => "Updated successfully",
				));
				return;

			}




			return;
		}
		if ($this->input->server('REQUEST_METHOD') === 'DELETE'){

				if (!isset($this->session->userdata['login']) ||
					$this->session->userdata['login'] == null){

					echo json_encode(array(
						'success' => false,
						'message' => "Not logged in",
					));
					return;
				}

				$id = $this->session->userdata('login');
				$this->session->userdata['login'] = null;

				echo json_encode(array(
					'success' => true,
					'message' => "Logged out successfully",
				));
				return;
		}



		echo json_encode(array(
			'success' => false,
			'message' => "Invalid request",
		));
		return;


	}
	public function login(){
		if ($this->input->server('REQUEST_METHOD') === 'POST'){

			$input = json_decode($this->input->raw_input_stream, true);

			$username = $input['username'];
			$password = $input['password'];

			$user = $this->db->get_where('user', array('username' => $username));

			if ($this->db->error()['code'] != 0){
				echo json_encode(array(
					'success' => false,
					'message' => json_encode($this->db->error()),
				));
				return;
			}

			$user = $user->row_array();



			if ($user == null){
				echo json_encode(array(
					'success' => false,
					'message' => "Invalid username!",
				));
				return;
			}
			if (strcmp($password, $user['password']) != 0){
				echo json_encode(array(
					'success' => false,
					'message' => "Wrong password",
				));
				return;
			}

			$this->session->set_userdata('login', $user['id']);

			echo json_encode(array(
				'success' => true,
				'message' => "Logged in successfully",
				'id' => $user['id']
			));

			return;
		}
	}
}
