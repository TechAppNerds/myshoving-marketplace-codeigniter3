<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChatController extends CI_Controller {
function __construct(){
        parent::__construct();
        $this->load->helper("form");
        $this->load->database();
        $this->load->model('ModelChat');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('upload');
		$this->load->library('form_validation');
        $this->load->library('pagination');
		$this->load->helper('cookie');
       $this->load->library('cart');
		$this->load->helper('url');
        //$this->output->enable_profiler(TRUE);
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->load->view('Chat/log');
		
	}
    public function chat()
    {
          $data2['arrItem1'] = $this->ModelChat->ambildataadmin();//untuk admin
        $data2['arrItem2'] = $this->ModelChat->ambildatareseller();//untuk reseller
        $data2['arrItem3'] = $this->ModelChat->ambildatakonsumen();//untuk konsumen
        $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
        $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
        $data['arrItem3'] = $this->ModelChat->ambildataadmin();//untuk room chat
        $data['arrItem4'] = $this->ModelChat->ambildatareseller();//untuk reseller
        $data['arrItem5'] = $this->ModelChat->ambildatakonsumen();//untuk konsumen
        $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
    
    //mengambil jenis user
      
          
                $username = $this->input->post('username');
    			$password = hash("sha512", md5($this->input->post('password')));
				//$password = hash(md5($this->input->post('b')));
    			$cek = $this->model_app->cek_login($username,$password,'users');
    		    $row = $cek->row_array();
    		    $total = $cek->num_rows();
    			if ($total > 0){
    				$this->session->set_userdata('upload_image_file_manager',true);
    				$this->session->set_userdata(array('username'=>$row['username'],
    								   'level'=>$row['level'],
                                       'id_session'=>$row['id_session']));
                     $this->model_app->update_login($username);
    				$this->load->view('Chat/chatbox',$data); 
                    
    			}else{
                    echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Username dan Password Salah!!</center></div>');
    				redirect($this->uri->segment(1).'/index');
    			}
          
    }
    public function chat2()
    {
        $data2['arrItem1'] = $this->ModelChat->ambildataadmin();//untuk admin
        $data2['arrItem2'] = $this->ModelChat->ambildatareseller();//untuk reseller
        $data2['arrItem3'] = $this->ModelChat->ambildatakonsumen();//untuk konsumen
        $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
        $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
        $data['arrItem3'] = $this->ModelChat->ambildataadmin();//untuk room chat
        $data['arrItem4'] = $this->ModelChat->ambildatareseller();//untuk reseller
        $data['arrItem5'] = $this->ModelChat->ambildatakonsumen();//untuk konsumen
        $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
    //mengambil jenis user
        
           
            
                $iuser = $this->input->post('checkbox');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
            if($iuser=='admin')
                {
                    $query = $this->db->query("SELECT password FROM users where username ='$username'");
                    $tampassword="";
                    foreach ($query->result_array() as $row){
                        $tampassword=$row['password'];
                    }
                  if($tampassword==$password)
                    {
                    $this->session->set_userdata('username', $username); //email
                     $this->load->view('chatbox',$data);
                  } else
            {
               $this->load->view('log'); 
            }
                }
            else if($iuser=='reseller')
                {
                    $query = $this->db->query("SELECT password FROM rb_reseller where username ='$username'");
                        $tampassword="";
                        foreach ($query->result_array() as $row){
                            $tampassword=$row['password'];
                        }
                if($tampassword==$password)
                {
                    $this->session->set_userdata('username', $username); //email
                $this->load->view('chatbox',$data); 
                } else
            {
               $this->load->view('log'); 
            }
                
                }
            else if($iuser=='konsumen')
                {
                  $query = $this->db->query("SELECT password FROM rb_konsumen where username ='$username'");
                        $tampassword="";
                        foreach ($query->result_array() as $row){
                            $tampassword=$row['password'];
                        }
                  if($tampassword==$password)
                    {
                     $this->session->set_userdata('username', $username); //email
                    $this->load->view('chatbox',$data);
                      } else
            {
               $this->load->view('log'); 
            }
                
                }
            else
            {
               $this->load->view('log'); 
            }
        
    }
    public function detailchat(){
         $session = $this->session->userdata('username');
         $user="";
        if($session!='')
        {
            $query = $this->db->query("SELECT username FROM users where username ='$session'");
            $username="";
            foreach ($query->result_array() as $row){
                $username=$row['username'];
            }
            if($username!="")
            {
                $users="admin";
            }else if($username=="")
            {
                $query = $this->db->query("SELECT username FROM rb_reseller where username ='$session'");
                $username="";
                foreach ($query->result_array() as $row){
                    $username=$row['username'];
                }  
                if($username!="")
                {
                    $users="pengguna";
                }else
                {
                    $users="pengguna";
                }
            }
            if($users=="admin")
            {
                $data['arrItem3'] = $this->ModelChat->ambildataadmin();//untuk admin
                $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
                $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
                $data['arrItem4'] = $this->ModelChat->ambildatareseller();//untuk reseller
                $data['arrItem5'] = $this->ModelChat->ambildatakonsumen();//untuk konsumen
                $this->load->view('Chat/chatbox',$data);  
            }else if($users=="pengguna")
            {
                //SELECT username FROM users ORDER BY RAND() LIMIT 1
                $query2 = $this->db->query("SELECT username FROM users where status_online ='1' order by RAND() LIMIT 1");
                $admin="";
                foreach ($query2->result_array() as $row2){
                    $admin=$row2['username'];
                }
                if($admin!="")
                {     $masuk="";
                      $username= $this->session->userdata('username');
                      $session=$username;
                 
            
                              $querycekganda = $this->db->query("SELECT receiver FROM room_chat where sender ='$session'");
                              $cekacak="";
                              foreach ($querycekganda->result_array() as $rowganda){
                                $cekacak=$rowganda['receiver'];
                              }
                                if($cekacak=="")
                                {
                                      $receiver= $admin;
                                }else
                                {
                                    $receiver= $cekacak;
                                }
                            $query = $this->db->query("SELECT id_room FROM room_chat where sender ='$session' and receiver='$receiver' or receiver ='$session' and sender='$receiver'");
                            $id_room="";
                            foreach ($query->result_array() as $row){
                                $id_room=$row['id_room'];
                            }
                            if($id_room!="")
                            {
                                $data['arrItem3'] = $this->ModelChat->ambildataadmin();//untuk admin
                                 $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
                                 $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
                                 $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
                                $this->load->view('Chat/chatbox',$data);  

                            }else if($id_room=="")
                            {
                                 $username= $this->session->userdata('username');
                                 $this->ModelChat->createroom($username, $receiver);
                                 
                                  $query3 = $this->db->query("SELECT id_room FROM room_chat where sender ='$username' and receiver='$receiver' or receiver ='$username' and sender='$receiver'");
                                  $idroom="";  
                                  foreach ($query3->result_array() as $row3){
                                        $idroom=$row3['id_room'];
                                    }
                                 $message="Pesan anda akan segera dibalas mohon menunggu beberapa saat.";
                                 $tanggal=date('Y-m-d H:i:s');
                                 $this->ModelChat->savechat($receiver, $message,$idroom,$tanggal); 
                                 $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
                                 $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
                                 $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
                                 $this->load->view('Chat/chatbox',$data); 
                               
                            }
                      
                }else if($admin=="")
                {
                    $queryoff = $this->db->query("SELECT username FROM users order by RAND() LIMIT 1");
                    $adminacak="";
                    foreach ($queryoff->result_array() as $rowoff){
                        $adminacak=$rowoff['username'];
                    }
                      $masuk="";
                      $username= $this->session->userdata('username');
                      $session=$username;
                    
                              $querycekganda = $this->db->query("SELECT receiver FROM room_chat where sender ='$session'");
                              $cekacak="";
                              foreach ($querycekganda->result_array() as $rowganda){
                                $cekacak=$rowganda['receiver'];
                              }
                                if($cekacak=="")
                                {
                                      $receiver= $adminacak;
                                }else
                                {
                                    $receiver= $cekacak;
                                }
                    
                    
                            $query = $this->db->query("SELECT id_room FROM room_chat where sender ='$session' and receiver='$receiver' or receiver ='$session' and sender='$receiver'");
                            $id_room="";
                            foreach ($query->result_array() as $row){
                                $id_room=$row['id_room'];
                            }
                            if($id_room!="")
                            {
                                $data['arrItem3'] = $this->ModelChat->ambildataadmin();//untuk admin
                                 $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
                                 $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
                                 $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
                                $this->load->view('Chat/chatbox',$data);  

                            }else if($id_room=="")
                            {
                                 $username= $this->session->userdata('username');
                                 $this->ModelChat->createroom($username, $receiver);
                                 
                                  $query3 = $this->db->query("SELECT id_room FROM room_chat where sender ='$username' and receiver='$receiver' or receiver ='$username' and sender='$receiver'");
                                  $idroom="";  
                                  foreach ($query3->result_array() as $row3){
                                        $idroom=$row3['id_room'];
                                    }
                                 $message="Pesan anda akan segera dibalas mohon menunggu beberapa saat.";
                                 $tanggal=date('Y-m-d H:i:s');
                                 $this->ModelChat->savechat($receiver, $message,$idroom,$tanggal); 
                                 $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
                                 $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
                                 $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
                                 $this->load->view('Chat/chatbox',$data); 
                               
                            }
                }
            }
           
         
         }else
        {
             Redirect(base_url('/reseller'), false); 
        }
         
        
    }
     //MAILER
     public function mailer()
     {
         
           $this->load->library('email');   
    $config = array();
    $config['protocol']     = "smtp"; // you can use 'mail' instead of 'sendmail or smtp'
    $config['smtp_host']    = "ssl://smtp.googlemail.com";// you can use 'smtp.googlemail.com' or 'smtp.gmail.com' instead of 'ssl://smtp.googlemail.com'
    $config['smtp_user']    = "viprohouse@gmail.com"; // client email gmail id
    $config['smtp_pass']    = "322746kk"; // client password
    $config['smtp_port']    =  465;
    $config['smtp_crypto']  = 'tls';
    $config['smtp_timeout'] = "";
    $config['mailtype']     = "html";
    $config['charset']      = "iso-8859-1";
    $config['newline']      = "\r\n";
    $config['wordwrap']     = TRUE;
    $config['validate']     = FALSE;
    $this->load->library('email', $config); // intializing email library, whitch is defiend in system

    $this->email->set_newline("\r\n"); // comuplsory line attechment because codeIgniter interacts with the SMTP server with regards to line break

    $from_email = 'viprohouse@gmail.com'; // sender email, coming from my view page 
    $to_email ='thecornells21@gmail.com'; // reciever email, coming from my view page
    //Load email library

    $this->email->from($from_email);
    $this->email->to($to_email);
    $this->email->subject('Send Email Codeigniter'); 
    $this->email->message('The email send using codeigniter library');  // we can use html tag also beacause use $config['mailtype'] = 'HTML'
    //Send mail
    if($this->email->send()){
        $this->session->set_flashdata("email_sent","Congragulation Email Send Successfully.");
        echo "email_sent";
    }
    else{
        echo "email_not_sent";
        echo $this->email->print_debugger();  // If any error come, its run
    }
         
//          $subject = 'Ini Subject Kevin';
//         $message = 'Ini Pesan Kevi';
//         $name = 'Ini Nama Kevin';
//         $email ='thecornells21@gmail.com';
//      // Konfigurasi email
//        $config = [
//            'mailtype'  => 'html',
//            'charset'   => 'utf-8',
//            'protocol'  => 'mail',
//            'smtp_host' => 'mail.myshoving.com',
//            'smtp_user' => 'customer.care@myshoving.com',  // Email gmail
//            'smtp_pass'   => 'Xwje*GDRrwhD',  // Password gmail
//            'smtp_crypto' => 'ssl',
//            'smtp_port'   => 465,
//            'crlf'    => "\r\n",
//            'newline' => "\r\n"
//        ];
//         $this->email->set_newline("\r\n");
//        // Load library email dan konfigurasinya
//        $this->load->library('email', $config);
//
//        // Email dan nama pengirim
//        $this->email->from('no-reply@myshoving.com', 'MyShoving');
//
//        // Email penerima
//        $this->email->to($email); // Ganti dengan email tujuan
//
//        // Lampiran email, isi dengan url/path file
//       // $this->email->attach('https://www.dropbox.com/home?preview=LogoTcreativeCrop.png');
//
//        // Subject email
//        $this->email->subject('Terimakasih '.$name.' Telah Menghubungi Kami | MyShoving');
//
//        // Isi email
//        $this->email->message("Ini merupakan e-mail balasan otomatis, terimakasih telah menghubungi kami. Kami akan membalas pesan anda segera.<br><br> Salam hangat, MyShoving");
//
//        // Tampilkan pesan sukses atau error
//        if ($this->email->send()) {
//            echo 'Email Berhasil Dikirim';
//        } else {
//            echo 'Error! email tidak dapat dikirim.';
//             show_error($this->email->print_debugger()); 
//        }
//         
//         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
//        $subject="Ticket confirmation";
//        $message="Your ticket number #..$1asttiket.. has been submitted, please wait for our agent to solve your problem"; 
//        $message2="<1.1><W>This is the data you are submitted to";
//        $message3="<W>Subject <1,./>Department :  <W>Problem category "; 
//        $message4="<bg/><W>This is generated mail system and you don't need to reply this. <ii.1><I,x/>Regards,<W><W,";
//
//        $email_pengirim ="viprohouse@gmail.com";
//        $nama_Pengirim =  "IT Helpdesk "; 
//        $email_penerima = 'thecornells21@gmail.com'; 
//        $emailcc='';
//        $emailbcc='';                        
//
//        $subjek = $subject; 
//        $pesan= $message.$message2.$message3.$message4; //inputan pesan
//
//        $mail = new PHPMailer; 
//        $mail->isSMTP();
//
//        $mail->Host ='smtp.gmail.com';
//        $mail->Username = $email_pengirim; //email pengirim
//        $mail->Password = '322746kk';
//        $mail->Port = 587;
//        $mail->SMTPAuth = true;
//        $mail->SMTPSecure = 'TLS';
//        $mail->SMTPDebug = 0; // Aktifkan untuk melakukan debugging
//        $mail->SMTPOptions = array(
//                          'ssl' => array(
//                          'verify_peer' => false,
//                          'verify_peer_name'=> false,
//                          'allow_self_signed' => true
//                            )
//                        );
//
//        $mail->setFrom($email_pengirim, $nama_pengirim); 
//        $mail->addAddress($email_penerima);
//        $mail->addCC($emailcc,'');
//        $mail->addBCC($emailbcc,'');
//        $mail->isHTML(true);
//
//
//        $mail->Subject=$subjek;
//        $mail->Body=$pesan;
//
//        $send = $mail->send(); 
//        if($send)
//        { 
//            echo "Pesan Terkirim";
//        }else
//        {
//             echo "Pesan Gagal Terkirim";
//        }
       
      
     }
    //MAILER
    public function reload(){
          Redirect(base_url('ChatController/detailchat/'), false); 
    }
     public function sendmessage(){
          $session = $this->session->userdata('username');
          if($session!='')
            {
             $username= $this->session->userdata('username');
             $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
             $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
             $message = $this->input->post('message');
             $idroom= $this->uri->segment(3);
             $tanggal=date('Y-m-d H:i:s');
             $this->ModelChat->savechat($username, $message,$idroom,$tanggal); 
             Redirect(base_url('ChatController/detailchat/'.$idroom), false); 
            }
            else
            {
                Redirect(base_url('/reseller'), false); 
            }
    }
     public function create_ticket(){
          $session = $this->session->userdata('username');
         $query = $this->db->query("SELECT username FROM users where username ='$session'");
            $username="";
            foreach ($query->result_array() as $row){
                $username=$row['username'];
            }
            if($username!="")
            {
                $users="admin";
            }else if($username=="")
            {
                $query = $this->db->query("SELECT username FROM rb_reseller where username ='$session'");
                $username="";
                foreach ($query->result_array() as $row){
                    $username=$row['username'];
                }  
                if($username!="")
                {
                    $users="pengguna";
                }else
                {
                    $users="pengguna";
                }
            }
         if($users=="admin")
         {
             $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
             $data['detailtiket'] = $this->ModelChat->ambildatadetailtiket();//untuk detail tiket
             $this->load->view('Chat/create_ticketing',$data); 
         }else
         {
             $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
             $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
             $this->load->view('Chat/chatbox',$data); 
         }
         
        }
    public function detail(){
          $session = $this->session->userdata('username');
         $query = $this->db->query("SELECT username FROM users where username ='$session'");
            $username="";
            foreach ($query->result_array() as $row){
                $username=$row['username'];
            }
            if($username!="")
            {
                $users="admin";
            }else if($username=="")
            {
                $query = $this->db->query("SELECT username FROM rb_reseller where username ='$session'");
                $username="";
                foreach ($query->result_array() as $row){
                    $username=$row['username'];
                }  
                if($username!="")
                {
                    $users="pengguna";
                }else
                {
                    $users="pengguna";
                }
            }
         if($users=="admin"||$users=="pengguna")
         {
             $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
             $data['detailtiket'] = $this->ModelChat->ambildatadetailtiket();//untuk detail tiket
             $this->load->view('Chat/detail_ticketing',$data); 
         }else
         {
             $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
             $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
             $this->load->view('Chat/chatbox',$data); 
         }
        
    }
    public function update_tiket(){
        $id_tiket=$this->input->post('idtiket');
        $masalah_detail=$this->input->post('masalah');
        $status=$this->input->post('status');
        $tanggal=date('Y-m-d H:i:s');
        $this->ModelChat->detail_ticket($id_tiket, $masalah_detail,$status,$tanggal); 
        Redirect(base_url('ChatController/detail/'.$id_tiket), false); 
    }
     public function status_ticket(){
          $session = $this->session->userdata('username');
          $query = $this->db->query("SELECT username FROM users where username ='$session'");
            $username="";
            foreach ($query->result_array() as $row){
                $username=$row['username'];
            }
            if($username!="")
            {
                $users="admin";
            }else if($username=="")
            {
                $query = $this->db->query("SELECT username FROM rb_reseller where username ='$session'");
                $username="";
                foreach ($query->result_array() as $row){
                    $username=$row['username'];
                }  
                if($username!="")
                {
                    $users="pengguna";
                }else
                {
                    $users="pengguna";
                }
            }
         if($users=="admin")
         {
               $data['tiket'] = $this->ModelChat->ambildatatiket();//untuk tiket
             $data['detailtiket'] = $this->ModelChat->ambildatadetailtiket();//untuk detail tiket
             $this->load->view('Chat/status_ticketing',$data);
         }else
         {
              $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
             $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
             $this->load->view('Chat/chatbox',$data); 
             
         }
     
        }
    public function insert_ticket(){
            $username=$this->input->post('username');
            $email=$this->input->post('email');
            $handphone=$this->input->post('phone');
            $masalah=$this->input->post('service');
            $masalah_detail=$this->input->post('message');
            $customer_service=$this->session->userdata('username');
            $id_tiket=substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
            $status='Belum Diproses';
            $tanggal=date('Y-m-d H:i:s');
        
        
        
             $this->ModelChat->insert_ticket($id_tiket, $masalah,$username,$email,$handphone,$customer_service);
            $this->ModelChat->detail_ticket($id_tiket, $masalah_detail,$status,$tanggal); 
            Redirect(base_url('ChatController/create_ticket'), false); 
        }
    public function buatroom(){
           $session = $this->session->userdata('username');
          if($session!='')
            {
                $receiver= $this->uri->segment(3);
                $query = $this->db->query("SELECT id_room FROM room_chat where sender ='$session' and receiver='$receiver' or receiver ='$session' and sender='$receiver'");
                $id_room="";
                foreach ($query->result_array() as $row){
                    $id_room=$row['id_room'];
                }
                if($id_room!="")
                {
                    Redirect(base_url('ChatController/detailchat/'.$id_room), false); 

                }else
                {
                     $username= $this->session->userdata('username');
                     $data['arrItem'] = $this->ModelChat->ambildataroomchat();//untuk room chat
                     $data['arrItem2'] = $this->ModelChat->ambildatadetailchat();//untuk room chat
                     $this->ModelChat->createroom($username, $receiver);
                     Redirect(base_url('ChatController/detailchat/'), false); 
                }
                 
          }
            else
            {
                 Redirect(base_url('/reseller'), false);  
            }
        
    }
    
     public function logout(){
         $username = $this->session->userdata('username');
        $this->model_app->logout_status($username);
        session_destroy();
        Redirect(base_url(''), false);
	}
}
