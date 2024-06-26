<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('question_model');
	}

	public function index($qid = null)
	{
		if (!isset($this->session->userdata['login']) || $this->session->userdata['login'] == null) {
			echo json_encode(array(
				'success' => false,
				'message' => "Not logged in",
			));
			return;
		}

		$id = $this->session->userdata('login');

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			$input = json_decode($this->input->raw_input_stream, true);

			$question = $input['question'];
			$tags = $input['tags'];
			$time = date('Y-m-d H:i:s');
			$uid = $id;

			$this->db->insert('question', array(
				'question' => $question,
				'tags' => $tags,
				'time' => $time,
				'uid' => $uid
			));

			$insert_id = $this->db->insert_id();

			if ($this->db->error()['code'] != 0) {
				echo json_encode(array(
					'success' => false,
					'message' => $this->db->error()['message'],
				));
				return;
			}

			echo json_encode(array(
				'success' => true,
				'message' => "Question added successfully",
				'id' => $insert_id
			));

			return;
		}
		if ($this->input->server('REQUEST_METHOD') === 'GET') {
			if (isset($qid) && $qid != null) {

				$question = $this->db->get_where('question', array('id' => $qid))->row_array();
				$question["likes"] = $this->db->get_where('like', array('question' => $qid, 'like' => 1))->num_rows();
				$question['dislikes'] = $this->db->get_where('like', array('question' => $qid, 'like' => 0))->num_rows();
				$question['user'] = $this->db->get_where('user', array('id' => $question['uid']))->row_array();

				echo json_encode(array(
					'success' => true,
					'data' => $question,
					'id' => $qid,

				));
				return;
			} else {

				$questions = $this->db->get('question')->result_array();


				$questions = array_map(function ($question) {
					$question['likes'] = $this->db->get_where('like', array('question' => $question['id'], 'like' => 1))->num_rows();
					$question['dislikes'] = $this->db->get_where('like', array('question' => $question['id'], 'like' => 0))->num_rows();
					$question['user'] = $this->db->get_where('user', array('id' => $question['uid']))->row_array();
					$question['answers'] = $this->db->get_where('answer', array('question' => $question['id']))->num_rows();
					return $question;
				}, $questions);

				echo json_encode(array(
					'success' => true,
					'data' => $questions,
				));
				return;
			}
		}


		echo json_encode(array(
			'success' => false,
			'message' => "Invalid request",
		));
		return;


	}

	public function login()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			$input = json_decode($this->input->raw_input_stream, true);

			$username = $input['username'];
			$password = $input['password'];

			$user = $this->db->get_where('user', array('username' => $username));

			if ($this->db->error()['code'] != 0) {
				echo json_encode(array(
					'success' => false,
					'message' => json_encode($this->db->error()),
				));
				return;
			}

			$user = $user->row_array();


			if ($user == null) {
				echo json_encode(array(
					'success' => false,
					'message' => "Invalid username!",
				));
				return;
			}
			if (strcmp($password, $user['password']) != 0) {
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
