<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function register_user($first_name, $last_name, $username, $email, $password) {
		$data = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'username' => $username,
			'email' => $email,
			'password' => $password,
		);
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	public function get_user_by_id($id) {
		return $this->db->get_where('user', array('id' => $id))->row_array();
	}

	public function update_user($id, $first_name, $last_name, $username, $password) {
		$data = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'username' => $username
		);
		if ($password) {
			$data['password'] = $password;
		}
		$this->db->where('id', $id);
		$this->db->update('user', $data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function delete_user_session($id) {
		$this->session->unset_userdata('login');
	}
}
