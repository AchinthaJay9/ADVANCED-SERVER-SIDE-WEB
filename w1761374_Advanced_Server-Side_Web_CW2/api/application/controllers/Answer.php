<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property $db
 * @property $session
 * @property $input
 */
class Answer extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
	}

	public function index($qid = null){

		if (!isset($this->session->userdata['login']) ||
			$this->session->userdata['login'] == null){

			echo json_encode(array(
				'success' => false,
				'message' => "Not logged in",
			));
			return;
		}

		$id = $this->session->userdata('login');

		if (!isset($qid) || $qid == null) {
			echo json_encode(array(
				'success' => false,
				'message' => "Invalid question id",
			));
			return;
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST'){

			$input = json_decode($this->input->raw_input_stream, true);

			$question = $input['question'];
			$tags = $input['tags'];
			$time = date('Y-m-d H:i:s');
			$uid = $id;

			$this->db->insert('answer', array(
				'question' => $qid,
				'answer' => $question,
				'time' => $time,
				'uid' => $uid
			));

			$insert_id = $this->db->insert_id();

			if ($this->db->error()['code'] != 0){
				echo json_encode(array(
					'success' => false,
					'message' => $this->db->error()['message'],
				));
				return;
			}

			echo json_encode(array(
				'success' => true,
				'message' => "Answer added successfully",
				'id' => $insert_id
			));

			return;
		}

		if ($this->input->server('REQUEST_METHOD') === 'GET'){
			$answers = $this->db->get_where('answer', array('question' => $qid))->result_array();

			$answers = array_map(function($question){
				$question['likes'] = $this->db->get_where('like', array('answer' => $question['id'], 'like' => 1))->num_rows();
				$question['dislikes'] = $this->db->get_where('like', array('answer' => $question['id'], 'like' => 0))->num_rows();
				$question['user'] = $this->db->get_where('user', array('id' => $question['uid']))->row_array();
				return $question;
			}, $answers);

			echo json_encode(array(
				'success' => true,
				'data' => $answers,
				'id' => $qid
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
