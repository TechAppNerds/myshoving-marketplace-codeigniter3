<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelChat extends CI_Model {
	
	public $teks = "contoh text";

	public function __construct(){
		parent::__construct();
		$this->teks = "Diubah dari constructor";
		$this->load->database();
	}
     
	 public function ambildatakonsumen(){
		$query1 = $this->db->get('rb_konsumen');
		$hasil1 = $query1->result();
		return $hasil1;
	}
    public function ambildataadmin(){
		$query1 = $this->db->get('users');
		$hasil1 = $query1->result();
		return $hasil1;
	}
     public function ambildatareseller(){
		$query1 = $this->db->get('rb_reseller');
		$hasil1 = $query1->result();
		return $hasil1;
	}
     public function ambildataroomchat(){
		$query1 = $this->db->get('room_chat');
		$hasil1 = $query1->result();
		return $hasil1;
	}
     public function ambildatadetailchat(){
		$query1 = $this->db->get('detail_chat');
		$hasil1 = $query1->result();
		return $hasil1;
	}
    public function ambildatatiket(){
		$query1 = $this->db->get('ticket');
		$hasil1 = $query1->result();
		return $hasil1;
	}
    public function ambildatadetailtiket(){
		$query1 = $this->db->get('detail_ticket');
		$hasil1 = $query1->result();
		return $hasil1;
	}
     public function savechat($username,$message,$idroom)
    {
        $query1 = "SELECT * FROM detail_chat";
		$sql = $this->db->query($query1);
		$data = ['username'=>$username,'message'=>$message,'id_room'=>$idroom];
		$query = $this->db->insert('detail_chat',$data);
    }
     public function createroom($username,$receiver)
    {
        $query1 = "SELECT * FROM room_chat";
		$sql = $this->db->query($query1);
		$data = ['receiver'=>$username,'sender'=>$receiver];
		$query = $this->db->insert('room_chat',$data);
    }
     public function insert_ticket($id_tiket, $masalah,$username,$email,$handphone,$customer_service)
    {
        $query1 = "SELECT * FROM ticket";
		$sql = $this->db->query($query1);
		$data = ['id_ticket'=>$id_tiket,'masalah'=>$masalah,'username'=>$username,'email'=>$email,'handphone'=>$handphone,'customer_service'=>$customer_service];
		$query = $this->db->insert('ticket',$data);
    }
     public function detail_ticket($id_tiket, $masalah_detail,$status,$tanggal)
    {
        $query1 = "SELECT * FROM detail_ticket";
		$sql = $this->db->query($query1);
		$data = ['id_ticket'=>$id_tiket,'detail_masalah'=>$masalah_detail,'status'=>$status,'tanggal'=>$tanggal];
		$query = $this->db->insert('detail_ticket',$data);
    }
}
