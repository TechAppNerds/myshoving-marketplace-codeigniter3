<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelTesti extends CI_Model {
	
	public $teks = "contoh text";

	public function __construct(){
		parent::__construct();
		$this->teks = "Diubah dari constructor";
		$this->load->database();
	}
     
	 public function ambildatatesti(){
		$query1 = $this->db->get('testimoni');
		$hasil1 = $query1->result();
		return $hasil1;
	}
}
