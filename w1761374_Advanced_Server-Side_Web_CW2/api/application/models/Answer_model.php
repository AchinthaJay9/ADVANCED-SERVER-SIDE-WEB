<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answer_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function add_answer($qid, $answer, $uid) {
		$data = array(
			'question' => $qid,
			'answer' => $answer,
			'time' => date('Y-m-d H:i:s'),
			'uid' => $uid
		);
		$this->db->insert('answer', $data);
		return $this->db->insert_id();
	}

	public function get_answers($qid) {
		$answers = $this->db->get_where('answer', array('question' => $qid))->result_array();
		foreach ($answers as &$answer) {
			$answer['likes'] = $this->db->get_where('like', array('answer' => $answer['id'], 'like' => 1))->num_rows();
			$answer['dislikes'] = $this->db->get_where('like', array('answer' => $answer['id'], 'like' => 0))->num_rows();
			$answer['user'] = $this->db->get_where('user', array('id' => $answer['uid']))->row_array();
		}
		return $answers;
	}
}
