<?php 
/*
-- ---------------------------------------------------------------
-- MARKETPLACE MULTI BUYER MULTI SELLER + SUPPORT RESELLER SYSTEM
-- CREATED BY : ROBBY PRIHANDAYA
-- COPYRIGHT  : Copyright (c) 2018 - 2019, PHPMU.COM. (https://phpmu.com/)
-- LICENSE    : http://opensource.org/licenses/MIT  MIT License
-- CREATED ON : 2019-03-26
-- UPDATED ON : 2019-03-27
-- ---------------------------------------------------------------
*/
class Model_reseller extends CI_model{
  
    
    function top_menu(){
        return $this->db->query("SELECT * FROM menu where position='Top' ORDER BY urutan ASC");
    }
    function testimonial(){
       $query1 = $this->db->get('testimoni');
		$hasil1 = $query1->result();
		return $hasil1;
    }
      public function insert_testimonial($id_pelanggan, $id_barang,$isi_testimoni,$rating,$tanggal,$star,$id_transaksi)
    {
        $query1 = "SELECT * FROM testimoni";
		$sql = $this->db->query($query1);
		$data = ['id_konsumen'=>$id_pelanggan,'id_barang'=>$id_barang,'isi_testimoni'=>$isi_testimoni,'rating'=>$rating,'isi_testimoni'=>$isi_testimoni,'aktif'=>'Y','waktu_testimoni'=>$tanggal,'id_penjualan'=>$id_transaksi,'star'=>$star];
		$query = $this->db->insert('testimoni',$data);
    }
    ////
    function testimoni(){
        return $this->db->query("SELECT a.*, b.nama_lengkap, b.id_konsumen FROM testimoni a JOIN rb_konsumen b ON a.id_konsumen=b.id_konsumen ORDER BY a.id_testimoni DESC");
    }

    function testimoni_update(){
        $datadb = array('isi_testimoni'=>$this->input->post('b'),
                            'aktif'=>$this->input->post('f'));
        $this->db->where('id_testimoni',$this->input->post('id'));
        $this->db->update('testimoni',$datadb);
    }

    function testimoni_edit($id){
        return $this->db->query("SELECT a.*, b.nama_lengkap, b.id_konsumen FROM testimoni a JOIN rb_konsumen b ON a.id_konsumen=b.id_konsumen where a.id_testimoni='$id'");
    }

    function testimoni_delete($id){
        return $this->db->query("DELETE FROM testimoni where id_testimoni='$id'");
    }

    function public_testimoni($sampai, $dari){
        return $this->db->query("SELECT a.*, b.nama_lengkap, b.foto, b.id_konsumen, b.jenis_kelamin FROM testimoni a JOIN rb_konsumen b ON a.id_konsumen=b.id_konsumen  where a.aktif='Y' ORDER BY a.id_testimoni DESC LIMIT $dari, $sampai");
    }

    function hitung_testimoni(){
        return $this->db->query("SELECT * FROM testimoni where aktif='Y'");
    }

    function insert_testimoni(){
            $datadb = array('id_konsumen'=>$this->session->id_konsumen,
                            'isi_testimoni'=>$this->input->post('testimoni'),
                            'aktif'=>'N',
                            'waktu_testimoni'=>date('Y-m-d H:i:s'));
        $this->db->insert('testimoni',$datadb);
    }

    function cari_reseller($kata){
        $pisah_kata = explode(" ",$kata);
        $jml_katakan = (integer)count($pisah_kata);
        $jml_kata = $jml_katakan-1;
        $cari = "SELECT * FROM rb_reseller a LEFT JOIN rb_kota b ON a.kota_id=b.kota_id WHERE";
            for ($i=0; $i<=$jml_kata; $i++){
              $cari .= " a.nama_reseller LIKE '%".$pisah_kata[$i]."%' OR b.nama_kota LIKE '%".$pisah_kata[$i]."%' ";
                if ($i < $jml_kata ){
                    $cari .= " OR "; 
                } 
            }
        $cari .= " ORDER BY a.id_reseller DESC LIMIT 36";
        return $this->db->query($cari);
    }

    public function view_join_rows($table1,$table2,$field,$where,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get();
    }

    function penjualan_list_konsumen($id,$level){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_konsumen b ON a.id_pembeli=b.id_konsumen where a.status_penjual='$level' AND a.id_penjual='$id' ORDER BY a.id_penjualan DESC");
    }
    function history_penjualan_list_konsumen($id,$level){
        return $this->db->query("SELECT * FROM `history_penjualan` a where  a.status_penjual='$level' AND a.id_pembeli='$id' ORDER BY a.id_penjualan DESC");
    }
    function jual($id){
        return $this->db->query("SELECT sum(a.jumlah) as jual FROM rb_penjualan_detail a JOIN rb_penjualan b ON a.id_penjualan=b.id_penjualan where a.id_produk='$id' AND b.status_penjual='admin' AND b.proses='1'");
    }

    function beli($id){
        return $this->db->query("SELECT sum(a.jumlah_pesan) as beli FROM rb_pembelian_detail a where a.id_produk='$id'");
    }

    function jual_reseller($penjual, $produk){
        return $this->db->query("SELECT sum(jumlah) as jual FROM `rb_penjualan` a JOIN rb_penjualan_detail b ON a.id_penjualan=b.id_penjualan where a.status_pembeli='konsumen' AND a.status_penjual='reseller' AND a.id_penjual='$penjual' AND b.id_produk='$produk' AND a.proses='1'");
    }

    function beli_reseller($pembeli, $produk){
        return $this->db->query("SELECT sum(jumlah) as beli FROM `rb_penjualan` a JOIN rb_penjualan_detail b ON a.id_penjualan=b.id_penjualan where a.status_pembeli='reseller' AND a.status_penjual='admin' AND a.id_pembeli='$pembeli' AND b.id_produk='$produk' AND a.proses='1'");
    }

    function penjualan_konsumen_detail($id){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_reseller b ON a.id_penjual=b.id_reseller JOIN rb_kota c ON b.kota_id=c.kota_id where a.id_penjualan='$id'");
    }
     function penjualan_konsumen_detailref($id){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_referral b ON a.id_penjual=b.id_reseller JOIN rb_kota c ON b.kota_id=c.kota_id where a.id_penjualan='$id'");
    }

    function profile_konsumen($id){
        return $this->db->query("SELECT a.id_konsumen, a.username, a.nama_lengkap, a.email, a.jenis_kelamin, a.tanggal_lahir, a.tempat_lahir, a.alamat_lengkap, a.kecamatan, a.no_hp, a.tanggal_daftar, b.kota_id, b.nama_kota as kota, c.provinsi_id, c.nama_provinsi as propinsi FROM `rb_konsumen` a LEFT JOIN rb_kota b ON a.kota_id=b.kota_id LEFT JOIN rb_provinsi c ON b.provinsi_id=c.provinsi_id where a.id_konsumen='$id'");
    }

    function orders_report($id,$level){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_reseller b ON a.id_penjual=b.id_reseller where a.status_penjual='$level' AND a.id_pembeli='$id' ORDER BY a.id_penjualan DESC");
    }

    function agenda_terbaru($limit){
        return $this->db->query("SELECT * FROM agenda ORDER BY id_agenda DESC LIMIT $limit");
    }

    public function view_join_where_one($table1,$table2,$field,$where){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($where);
        return $this->db->get();
    }

    function modupdatefoto(){
        $config['upload_path'] = 'asset/foto_user/';
        $config['allowed_types'] = 'gif|jpg|png|JPG|gif|JPEG|jpeg';
        $config['max_size']     = '1000'; // kb
        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $hasil=$this->upload->data();

        $config['image_library'] = 'gd2';
        $config['source_image'] = 'asset/foto_user/'.$hasil['file_name'];
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['height']       = 622;
        $this->load->library('image_lib', $config);
        $this->image_lib->crop();

        $datadb = array('foto'=>$hasil['file_name']);
        $this->db->where('id_konsumen',$this->session->id_konsumen);
        $this->db->update('rb_konsumen',$datadb);
    }

    function modupdatefotoreseller(){
        $config['upload_path'] = 'asset/foto_user/';
        $config['allowed_types'] = 'gif|jpg|png|JPG|gif|JPEG|jpeg';
        $config['max_size']     = '1000'; // kb
        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $hasil=$this->upload->data();

        $config['image_library'] = 'gd2';
        $config['source_image'] = 'asset/foto_user/'.$hasil['file_name'];
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['height']       = 622;
        $this->load->library('image_lib', $config);
        $this->image_lib->crop();

        $datadb = array('foto'=>$hasil['file_name']);
        $this->db->where('id_reseller',$this->session->id_reseller);
        $this->db->update('rb_reseller',$datadb);
    }

    function profile_update($id){
        if (trim($this->input->post('a')) != ''){
            $datadbd = array('username'=>$this->db->escape_str(strip_tags($this->input->post('aa'))),
                            'password'=>hash("sha512", md5($this->input->post('a'))),
                            'nama_lengkap'=>$this->db->escape_str(strip_tags($this->input->post('b'))),
                            'email'=>$this->db->escape_str(strip_tags($this->input->post('c'))),
                            'jenis_kelamin'=>$this->db->escape_str($this->input->post('d')),
                            'tanggal_lahir'=>$this->db->escape_str($this->input->post('e')),
                            'tempat_lahir'=>$this->db->escape_str(strip_tags($this->input->post('f'))),
                            'alamat_lengkap'=>$this->db->escape_str(strip_tags($this->input->post('g'))),
                            'kecamatan'=>$this->db->escape_str(strip_tags($this->input->post('k'))),
                            'kota_id'=>$this->db->escape_str(strip_tags($this->input->post('ga'))),
                            'no_hp'=>$this->db->escape_str(strip_tags($this->input->post('l'))));
        }else{
           $datadbd = array('username'=>$this->db->escape_str(strip_tags($this->input->post('aa'))),
                            'nama_lengkap'=>$this->db->escape_str(strip_tags($this->input->post('b'))),
                            'email'=>$this->db->escape_str(strip_tags($this->input->post('c'))),
                            'jenis_kelamin'=>$this->db->escape_str($this->input->post('d')),
                            'tanggal_lahir'=>$this->db->escape_str($this->input->post('e')),
                            'tempat_lahir'=>$this->db->escape_str(strip_tags($this->input->post('f'))),
                            'alamat_lengkap'=>$this->db->escape_str(strip_tags($this->input->post('g'))),
                            'kecamatan'=>$this->db->escape_str(strip_tags($this->input->post('k'))),
                            'kota_id'=>$this->db->escape_str(strip_tags($this->input->post('ga'))),
                            'no_hp'=>$this->db->escape_str(strip_tags($this->input->post('l'))));
        }
        $this->db->where('id_konsumen',$id);
        $this->db->update('rb_konsumen',$datadbd);
    }

    function penjualan_list_konsumen_top($id,$level){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_konsumen b ON a.id_pembeli=b.id_konsumen where a.status_penjual='$level' AND a.id_penjual='$id' ORDER BY a.id_penjualan DESC LIMIT 10");
    }

    function reseller_pembelian($id,$level){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_reseller b ON a.id_pembeli=b.id_reseller where a.status_penjual='$level' AND a.id_pembeli='$id' ORDER BY a.id_penjualan DESC");
    }

    function cek_saldo($id){
        return $this->db->query("SELECT * FROM mutasi_rek where id_reseller=$id ORDER BY tanggal DESC LIMIT 1");
    }
	
	function cek_mutasi($id){
        return $this->db->query("SELECT * FROM mutasi_rek where id_reseller=$id ORDER BY tanggal DESC LIMIT 10");
    }
	
	function penjualan_detail($id){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_reseller b ON a.id_pembeli=b.id_reseller where a.id_penjualan='$id'");
    }

    function penjualan_konsumen_detail_reseller($id){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_konsumen b ON a.id_pembeli=b.id_konsumen where a.id_penjualan='$id'");
    }

    function penjualan_list($id,$level){
        return $this->db->query("SELECT * FROM `rb_penjualan` a JOIN rb_reseller b ON a.id_pembeli=b.id_reseller where a.status_penjual='$level' AND a.id_penjual='$id' ORDER BY a.id_penjualan DESC");
    }

    function pembelian($id_reseller){
        return $this->db->query("SELECT sum((b.jumlah*b.harga_jual)-b.diskon) as total FROM rb_penjualan a JOIN rb_penjualan_detail b ON a.id_penjualan=b.id_penjualan where a.status_penjual='admin' AND a.id_pembeli='".$id_reseller."' AND a.proses='1'");
    }

    function penjualan_perusahaan($id_reseller){
        return $this->db->query("SELECT sum((a.jumlah*a.harga_jual)-a.diskon) as total, sum(a.jumlah) as produk FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk JOIN rb_penjualan c ON a.id_penjualan=c.id_penjualan where c.status_penjual='reseller' AND b.id_produk_perusahaan!='0' AND id_penjual='".$id_reseller."' AND c.proses='1'");
    }

    function penjualan($id_reseller){
        return $this->db->query("SELECT sum((a.jumlah*a.harga_jual)-a.diskon) as total, sum(a.jumlah) as produk FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk
                                    JOIN rb_penjualan c ON a.id_penjualan=c.id_penjualan where c.status_penjual='reseller' AND b.id_produk_perusahaan='0' AND id_penjual='".$id_reseller."' AND c.proses='1'");
    }

    function modal_perusahaan($id_reseller){
        return $this->db->query("SELECT sum(a.jumlah*b.harga_reseller) as total FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk JOIN rb_penjualan c ON a.id_penjualan=c.id_penjualan where c.status_pembeli='konsumen' AND c.proses='1' AND c.id_penjual='".$id_reseller."' AND b.id_produk_perusahaan!='0'");
    }

    function modal_pribadi($id_reseller){
        return $this->db->query("SELECT sum(a.jumlah*b.harga_beli) as total FROM `rb_penjualan_detail` a JOIN rb_produk b ON a.id_produk=b.id_produk JOIN rb_penjualan c ON a.id_penjualan=c.id_penjualan where c.status_pembeli='konsumen' AND c.proses='1' AND c.id_penjual='".$id_reseller."' AND b.id_produk_perusahaan='0'");
    }

    function produk_perkategori($id_reseller,$id_produk_perusahaan,$id_kategori_produk,$limit){
        return $this->db->query("SELECT a.*, b.nama_reseller, c.nama_kota FROM rb_produk a LEFT JOIN rb_reseller b ON a.id_reseller=b.id_reseller
                                    LEFT JOIN rb_kota c ON b.kota_id=c.kota_id where a.id_reseller!='$id_reseller' AND a.id_produk_perusahaan='$id_produk_perusahaan' AND a.id_kategori_produk='$id_kategori_produk' ORDER BY a.id_produk DESC LIMIT $limit");
    }
    function insert_nego($data){
        //cek sudah pernah nego produk ini
        $query = $this->db->get_where('rb_nego', array('id_produk'=>$data['id_produk']));
        $pernah_ada = $query->num_rows();
        if($pernah_ada>0){
            $query1 = $query->result_array();
            for ($i=0; $i < $pernah_ada; $i++) {    
                $this->db->where('id_nego',$query1[$i]['id_nego']);
                $this->db->update('rb_nego',$data);    
            }
        }
        else{
            $this->db->insert('rb_nego', $data);    
        }
    }
    function insert_nego_temp($data){
        $this->db->insert('rb_nego_temp', $data);
        $this->db->select_max('id_nego_temp');
        $query = $this->db->get('rb_nego_temp')->row_array()['id_nego_temp'];
        //$_SESSION['nego_temp'] = "bla";
        $this->session->set_userdata('nego_temp', $query);
    }
    function get_nego_temp($id){
        $query = $this->db->get_where('rb_nego_temp', array('id_nego_temp'=>$id))->row_array();
        return $query;
    }
    function find_nego_pembeli_a($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego', a.`id_status_nego` as 'id_status_nego', a.`id_produk` as 'id_produk', a.`id_penjual` as 'id_penjual', b.`harga_konsumen` as 'harga_konsumen', b.`jumlah` as 'jumlah_max' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_referral` d ON a.`id_penjual` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_pembeli`=".$id."")->result_array();
        
        
    }
     function find_nego_pembeli_b($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego', a.`id_status_nego` as 'id_status_nego', a.`id_produk` as 'id_produk', a.`id_penjual` as 'id_penjual', b.`harga_konsumen` as 'harga_konsumen', b.`jumlah` as 'jumlah_max' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_reseller` d ON a.`id_penjual` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_pembeli`=".$id."")->result_array();
    }
    function find_nego_penjual_a($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_referral` d ON a.`id_pembeli` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_penjual`=".$id." AND a.`id_status_nego` = 1")->result_array();
        
    }
    function find_nego_penjual_b($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_reseller` d ON a.`id_pembeli` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_penjual`=".$id." AND a.`id_status_nego` = 1")->result_array();
    }
    function find_nego_penjual_a_diterima($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_referral` d ON a.`id_pembeli` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_penjual`=".$id." AND a.`id_status_nego` = 2")->result_array();
        
    }
    function find_nego_penjual_b_diterima($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_reseller` d ON a.`id_pembeli` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_penjual`=".$id." AND a.`id_status_nego` = 2")->result_array();
    }
    function find_nego_penjual_a_ditolak($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_referral` d ON a.`id_pembeli` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_penjual`=".$id." AND a.`id_status_nego` = 3")->result_array();
        
    }
    function find_nego_penjual_b_ditolak($id){
        return $this->db->query("SELECT d.`username` as 'user', b.`nama_produk` as 'produk', a.`jumlah` as 'jumlah', a.`harga_jual` as 'harga', a.`satuan` as 'satuan', a.`tanggal_pengajuan` as 'tanggal', e.`nama` as 'nama_status', a.`id_nego` as 'id_nego' FROM `rb_nego` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` JOIN `rb_reseller` d ON a.`id_pembeli` = d.`id_reseller` JOIN `status_nego` e ON a.`id_status_nego` = e.`id_status_nego` WHERE a.`id_penjual`=".$id." AND a.`id_status_nego` = 3")->result_array();
    }
    public function hapus_nego($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function tolak_nego($where,$table){
        $this->db->where($where);
        $data = ['id_status_nego'=>3];
        $this->db->update($table,$data); 
    }
    public function setuju_nego($jumlah,$id_nego,$id_user){
        //pilih id_produk
        $id_produk = $this->db->query("SELECT `id_produk`,`harga_jual`,`satuan` FROM `rb_nego` WHERE `id_nego` = ".$id_nego." AND `id_penjual` = ".$id_user."")->result_array();
        $data = $this->db->query("SELECT `jumlah` FROM `rb_produk` WHERE `id_produk` = ".$id_produk[0]['id_produk']."")->result_array();
        if($data[0]['jumlah']>$jumlah){
            //update status menjadi diterima
            $this->db->query("UPDATE `rb_nego` SET `id_status_nego` = 2 WHERE `id_nego` = ".$id_nego."");
            // //update stock barang
            // $this->db->query("UPDATE `rb_produk` SET `jumlah` = ".($data[0]['jumlah']-$jumlah)." WHERE `id_produk` = ".$id_produk[0]['id_produk']."");
            $pembeli = $this->db->query("SELECT * FROM `rb_nego` WHERE `id_nego` = ".$id_nego."")->result_array();
            $status_pembeli = "reseller";
            $status_penjual = "reseller";
            if($pembeli[0]['id_pembeli']>1000){
                $status_pembeli = "referral";
            }
            if($id_user>1000){
                $status_penjual = "referral";
            }
            $idp = 'TRX-'.date('YmdHis');
            $time = date('Y-m-d H:i:s');
            //insert penjualan
            $this->db->query("INSERT INTO `rb_penjualan`(`kode_transaksi`, `id_pembeli`, `id_penjual`, `status_pembeli`, `status_penjual`, `waktu_transaksi`, `proses`) VALUES ('".$idp."',".$pembeli[0]['id_pembeli'].",".$id_user.",'".$status_pembeli."','".$status_penjual."','".$time."','0')");
            //pilih id penjualan terbaru
            $id_penjualan = $this->db->query("SELECT MAX(`id_penjualan`) as 'id_penjualan' FROM `rb_penjualan`")->result_array();
            //insert detail penjualan
            $this->db->query("INSERT INTO `rb_penjualan_detail`(`id_penjualan`, `id_produk`, `jumlah`, `diskon`, `harga_jual`, `satuan`) VALUES (".$id_penjualan[0]['id_penjualan'].",".$id_produk[0]['id_produk'].",".$jumlah.",0,".$id_produk[0]['harga_jual'].",'".$id_produk[0]['satuan']."')");
            //insert history penjualan
            $this->db->query("INSERT INTO `history_penjualan`(`kode_transaksi`, `id_pembeli`, `id_penjual`, `status_pembeli`, `status_penjual`, `waktu_transaksi`, `proses`) VALUES ('".$idp."',".$pembeli[0]['id_pembeli'].",".$id_user.",'".$status_pembeli."','".$status_penjual."','".$time."','0')");
            //pilih id history penjualan terbaru
            $id_penjualan = $this->db->query("SELECT MAX(`id_penjualan`) as 'id_penjualan' FROM `history_penjualan`")->result_array();
            //insert detail history penjualan
            $this->db->query("INSERT INTO `history_penjualan_detail`(`id_penjualan`, `id_produk`, `jumlah`, `diskon`, `harga_jual`, `satuan`) VALUES (".$id_penjualan[0]['id_penjualan'].",".$id_produk[0]['id_produk'].",".$jumlah.",0,".$id_produk[0]['harga_jual'].",'".$id_produk[0]['satuan']."')");
        }
        else{
            echo "<script>alert('Stock Barang tidak mencukupi untuk disetujui');</script>";
        }
    }
    function lihat_wishlist($id_user){
        return $this->db->query("SELECT b.`nama_produk` as 'nama_produk', a.`id_wishlist` as 'id_wishlist', b.`produk_seo` as 'produk_seo', b.`username` as 'username', b.`harga_konsumen` as 'harga_konsumen', b.`jumlah` as 'stock_barang', b.`satuan` as 'satuan' FROM `wishlist` a JOIN `rb_produk` b ON a.`id_produk` = b.`id_produk` WHERE a.`id_user` = ".$id_user." AND a.`status_wish` = 1")->result_array();
    }
    public function hapus_wish($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }
}