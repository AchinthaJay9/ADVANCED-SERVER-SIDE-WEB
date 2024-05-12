<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Like_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function like_answer($answer_id, $user_id, $like) {
		$data = array(
			'answer' => $answer_id,
			'uid' => $user_id,
			'time' => date('Y-m-d H:i:s'),
			'like' => $like
		);
		$this->db->delete('like', array('answer' => $answer_id, 'uid' => $user_id));
		$this->db->insert('like', $data);
		return $this->db->affected_rows() > 0;
	}

	public function like_question($question_id, $user_id, $like) {
		$data = array(
			'question' => $question_id,
			'uid' => $user_id,
			'time' => date('Y-m-d H:i:s'),
			'like' => $like
		);
		$this->db->delete('like', array('question' => $question_id, 'uid' => $user_id));
		$this->db->insert('like', $data);
		return $this->db->affected_rows() > 0;
	}

}
