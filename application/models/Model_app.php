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
class Model_app extends CI_model{
    public function view($table){
        return $this->db->get($table);
    }

    public function insert($table,$data){
        return $this->db->insert($table, $data);
    }

    public function edit($table, $data){
        return $this->db->get_where($table, $data);
    }
 
    public function update($table, $data, $where){
        return $this->db->update($table, $data, $where); 
    }
    public function update_login($username){
        $query = $this->db->query("SELECT status_online FROM users where username ='".$username."'");
                    $status_online="";
                    foreach ($query->result_array() as $row){
                        $status_online=$row['status_online'];
                    }
        if($status_online=='1')
        {
            $this->db->where('username',$username);
            $data=['status_online'=>'0'];
            $this->db->update('users',$data);
        }else if  ($status_online=='0')
        {
            $this->db->where('username',$username);
            $data=['status_online'=>'1'];
            $this->db->update('users',$data);
        }
    }
    public function logout_status($username){
        $this->db->where('username',$username);
        $data=['status_online'=>'0'];
        $this->db->update('users',$data);
    }
    public function delete($table, $where){
        return $this->db->delete($table, $where);
    }

    public function view_where($table,$data){
        $this->db->where($data);
        return $this->db->get($table);
    }

    public function view_ordering_limit($table,$order,$ordering,$baris,$dari){
        $this->db->select('*');
        $this->db->order_by($order,$ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }

    public function view_where_ordering_limit($table,$data,$order,$ordering,$baris,$dari){
        $this->db->select('*');
        $this->db->where($data);
        $this->db->order_by($order,$ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }
    
    public function view_ordering($table,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    public function view_where_ordering($table,$data,$order,$ordering){
        $this->db->where($data);
        $this->db->order_by($order,$ordering);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function view_join_one($table1,$table2,$field,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    public function view_join_where($table1,$table2,$field,$where,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    function umenu_akses($link,$id){
        return $this->db->query("SELECT * FROM modul,users_modul WHERE modul.id_modul=users_modul.id_modul AND users_modul.id_session='$id' AND modul.link='$link'")->num_rows();
    }

    public function cek_login($username,$password,$table){
        return $this->db->query("SELECT * FROM $table where username='".$this->db->escape_str($username)."' AND password='".$this->db->escape_str($password)."' AND blokir='N'");
    }

    function grafik_kunjungan(){
        return $this->db->query("SELECT count(*) as jumlah, tanggal FROM statistik GROUP BY tanggal ORDER BY tanggal DESC LIMIT 10");
    }

    function kategori_populer($limit){
        return $this->db->query("SELECT * FROM (SELECT a.*, b.jum_dibaca FROM
                                    (SELECT * FROM kategori) as a left join
                                    (SELECT id_kategori, sum(dibaca) as jum_dibaca FROM berita GROUP BY id_kategori) as b on a.id_kategori=b.id_kategori) as c 
                                        where c.aktif='Y' ORDER BY c.jum_dibaca DESC LIMIT $limit");
    }
    function insert_wish($id_produk,$id_user){
        $wish = $this->db->query("SELECT * FROM `wishlist` WHERE `id_produk` = ".$id_produk." AND `id_user` = ".$id_user."")->result_array();
        if(!isset($wish[0]['status_wish'])){
            $this->db->query("INSERT INTO `wishlist`(`id_produk`, `id_user`, `status_wish`) VALUES (".$id_produk.",".$id_user.", 1)");
            return '<button class="btn btn-danger btn-lg" id="wish" type="button"><i class="fa fa-heart"></i> Wishlist</button>';
        }
        elseif($wish[0]['status_wish']==0){
            $this->db->query("INSERT INTO `wishlist`(`id_produk`, `id_user`, `status_wish`) VALUES (".$id_produk.",".$id_user.", 1)");
            return '<button class="btn btn-danger btn-lg" id="wish" type="button"><i class="fa fa-heart"></i> Wishlist</button>';  
        }
        elseif($wish[0]['status_wish']==1){
            $this->db->query("DELETE FROM `wishlist` WHERE `id_produk` = ".$id_produk." AND `id_user` = ".$id_user."");
            return '<button class="btn btn-secondary btn-lg" id="wish" type="button"><i class="fa fa-heart"></i> Wishlist</button>';   
        }
    }
    function check_wish($id_produk,$id_user=0){
        if($id_user==0){

        }
        else{
            return $this->db->query("SELECT * FROM `wishlist` WHERE `id_produk`=".$id_produk." AND `id_user`=".$id_user."")->result_array();
        }
    }
}