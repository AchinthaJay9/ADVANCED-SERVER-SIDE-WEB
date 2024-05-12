<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {

	public function addQuestion($question, $tags, $uid) {
		$time = date('Y-m-d H:i:s');
		$data = array(
			'question' => $question,
			'tags' => $tags,
			'time' => $time,
			'uid' => $uid
		);
		$this->db->insert('question', $data);
		return $this->db->insert_id();
	}

	public function getQuestionById($qid) {
		return $this->db->get_where('question', array('id' => $qid))->row_array();
	}

	public function getAllQuestions() {
		return $this->db->get('question')->result_array();
	}
}

