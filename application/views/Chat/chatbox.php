<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Customer Care</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="<?php echo base_url()?>asset/dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<!-- Swipe core CSS -->
		<link href="<?php echo base_url()?>asset/dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<link href="<?php echo base_url()?>asset/dist/img/favicon.png" type="image/png" rel="icon">
	</head>
           <?php  
               $username = $this->session->userdata('username');
               $koderoom= $this->uri->segment(3);
               $level="";
               $query = $this->db->query("SELECT level FROM users where username ='$username'");
                        foreach ($query->result_array() as $row){
                            $level=$row['level'];
                        }
              
              ?>
    <script>
(function() {

    const idleDurationSecs =10;    // X number of seconds
   // const redirectUrl = '/detailchat/';  // Redirect idle users to this URL
    let idleTimeout; // variable to hold the timeout, do not modify
    var base_url = window.location;
    const resetIdleTimeout = function() {

        // Clears the existing timeout
        if(idleTimeout) clearTimeout(idleTimeout);

        // Set a new idle timeout to load the redirectUrl after idleDurationSecs
        idleTimeout = setTimeout(() => location.href = base_url, idleDurationSecs * 1000);
    };

    // Init on page load
    resetIdleTimeout();

    // Reset the idle timeout on any of the events listed below
    ['click', 'touchstart', 'mousemove', 'keydown'].forEach(evt => 
        document.addEventListener(evt, resetIdleTimeout, false)
    );

})();
</script>
	<body>
      
		<main>
			<div class="layout">
				<!-- Start of Navigation -->
				<div class="navigation">
					<div class="container">
						<div class="inside">
							<div class="nav nav-tab menu">
								<button class="btn"><img class="avatar-xl" src="<?php echo base_url()?>asset/dist/img/avatars/avatar-male-1.jpg" alt="avatar"></button>
                                 <?php  echo $username; ?>
								<a href="#members" data-toggle="tab"><i class="material-icons">account_circle</i></a>
								<a href="#discussions" data-toggle="tab" class="active"><i class="material-icons active">chat_bubble_outline</i></a>
                               <a href="<?php echo base_url('ChatController/logout')?>"><button class="btn power" ><i class="material-icons">power_settings_new</i></button></a>
                                
							</div>
						</div>
					</div>
				</div>
				<!-- End of Navigation -->
                   
				<!-- Start of Sidebar -->
				<div class="sidebar" id="sidebar">
					<div class="container">
						<div class="col-md-12">
							<div class="tab-content">
								<!-- Start of Discussions -->
								<div id="discussions" class="tab-pane fade active show">
									<div class="search">
<!--
										<form class="form-inline position-relative">
											<input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
											<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
										</form>
-->
										<button class="btn create" data-toggle="modal" data-target="#startnewchat"><i class="material-icons">create</i></button>
									</div>
									<div class="list-group sort">
										<button class="btn filterDiscussionsBtn active show" data-toggle="list" data-filter="all">All</button>
                                         <?php if($level=='admin'||$level=='kontributor'){?>
                                            <a href="<?php echo base_url('ChatController/create_ticket')?>"> <button class="btn filterDiscussionsBtn" >Buat Tiket</button>  </a>
                                             <a href="<?php echo base_url('ChatController/status_ticket')?>"> <button class="btn filterDiscussionsBtn" >Tiket</button>  </a>
                                        <?php }?>
                                               
									</div>						
									<div class="discussions">
										<h1>Discussions</h1>
										<div class="list-group" id="chats" role="tablist">
                                            <?php foreach ($arrItem as $key1): ?>
                                              <?php if ($key1->receiver==$username||$key1->sender==$username){ ?>
											<a href="<?php echo base_url('ChatController/detailchat/'.$key1->id_room);?>" class="filterDiscussions all single active" id="list-chat-list" role="tab">
												<img class="avatar-md" src="<?php echo base_url()?>asset/dist/img/avatars/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
<!--
												<div class="new bg-yellow">
													<span>+7</span>
												</div>
-->
												<div class="data">
                                                    <?php if($key1->receiver!=$username) {?>
													<h5><?php echo $key1->receiver;?></h5>
                                                    <?php } ?>
                                                     <?php if($key1->sender!=$username) {?>
													<h5><?php echo $key1->sender;?></h5>
                                                    <?php }?>
													<span>Mon</span>
													<p>
                                                        
                                                       <?php
                                                           if($key1->sender!=$username)
                                                           {
                                                             
                                                                $query = $this->db->query("SELECT dc.message FROM detail_chat dc,room_chat rc  where rc.sender='$key1->sender' and dc.username=rc.sender and rc.id_room=dc.id_room  ORDER BY dc.ID DESC LIMIT 1 ");
//                                                                echo "masuk sini";
                                                           }
                                                           if($key1->receiver!=$username)
                                                           {
//                                                               echo "masuk sini 2";
                                                                 $query = $this->db->query("SELECT dc.message FROM detail_chat dc,room_chat rc  where rc.receiver='$key1->receiver' and dc.username=rc.receiver and rc.id_room=dc.id_room ORDER BY dc.ID DESC LIMIT 1");
                                                              
                                                                
                                                           }  
                                                        $message="";
                                                        foreach ($query->result_array() as $row){
                                                            $message=$row['message'];
                                                        }
                                                        echo $message;

                                                        ?>
                                                    </p>
												</div>
											</a>
                                                <?php }?>
                                             <?php endforeach;?>
										</div>
									</div>
								</div>
								<!-- End of Discussions -->
								
								<!-- Start of Settings -->
								<div class="tab-pane fade" id="settings">			
									<div class="settings">
										<div class="profile">
											<img class="avatar-xl" src="dist/img/avatars/avatar-male-1.jpg" alt="avatar">
											<h1><a href="#">Michael Knudsen</a></h1>
											<span>Helena, Montana</span>
											<div class="stats">
												<div class="item">
													<h2>122</h2>
													<h3>Fellas</h3>
												</div>
												<div class="item">
													<h2>305</h2>
													<h3>Chats</h3>
												</div>
												<div class="item">
													<h2>1538</h2>
													<h3>Posts</h3>
												</div>
											</div>
										</div>
										<div class="categories" id="accordionSettings">
											<h1>Settings</h1>
											<!-- Start of My Account -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
													<i class="material-icons md-30 online">person_outline</i>
													<div class="data">
														<h5>My Account</h5>
														<p>Update your profile details</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings">
													<div class="content">
														<div class="upload">
															<div class="data">
																<img class="avatar-xl" src="dist/img/avatars/avatar-male-1.jpg" alt="image">
																<label>
																	<input type="file">
																	<span class="btn button">Upload avatar</span>
																</label>
															</div>
															<p>For best results, use an image at least 256px by 256px in either .jpg or .png format!</p>
														</div>
														<form>
															<div class="parent">
																<div class="field">
																	<label for="firstName">First name <span>*</span></label>
																	<input type="text" class="form-control" id="firstName" placeholder="First name" value="Michael" required>
																</div>
																<div class="field">
																	<label for="lastName">Last name <span>*</span></label>
																	<input type="text" class="form-control" id="lastName" placeholder="Last name" value="Knudsen" required>
																</div>
															</div>
															<div class="field">
																<label for="email">Email <span>*</span></label>
																<input type="email" class="form-control" id="email" placeholder="Enter your email address" value="michael@gmail.com" required>
															</div>
															<div class="field">
																<label for="password">Password</label>
																<input type="password" class="form-control" id="password" placeholder="Enter a new password" value="password" required>
															</div>
															<div class="field">
																<label for="location">Location</label>
																<input type="text" class="form-control" id="location" placeholder="Enter your location" value="Helena, Montana" required>
															</div>
															<button class="btn btn-link w-100">Delete Account</button>
															<button type="submit" class="btn button w-100">Apply</button>
														</form>
													</div>
												</div>
											</div>
											<!-- End of My Account -->
											<!-- Start of Chat History -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
													<i class="material-icons md-30 online">mail_outline</i>
													<div class="data">
														<h5>Chats</h5>
														<p>Check your chat history</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionSettings">
													<div class="content layer">
														<div class="history">
															<p>When you clear your conversation history, the messages will be deleted from your own device.</p>
															<p>The messages won't be deleted or cleared on the devices of the people you chatted with.</p>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input" id="same-address">
																<label class="custom-control-label" for="same-address">Hide will remove your chat history from the recent list.</label>
															</div>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" class="custom-control-input" id="save-info">
																<label class="custom-control-label" for="save-info">Delete will remove your chat history from the device.</label>
															</div>
															<button type="submit" class="btn button w-100">Clear blah-blah</button>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Chat History -->
											<!-- Start of Notifications Settings -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
													<i class="material-icons md-30 online">notifications_none</i>
													<div class="data">
														<h5>Notifications</h5>
														<p>Turn notifications on or off</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionSettings">
													<div class="content no-layer">
														<div class="set">
															<div class="details">
																<h5>Desktop Notifications</h5>
																<p>You can set up Swipe to receive notifications when you have new messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Unread Message Badge</h5>
																<p>If enabled shows a red badge on the Swipe app icon when you have unread messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Taskbar Flashing</h5>
																<p>Flashes the Swipe app on mobile in your taskbar when you have new notifications.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Notification Sound</h5>
																<p>Set the app to alert you via notification sound when you have unread messages.</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Vibrate</h5>
																<p>Vibrate when receiving new messages (Ensure system vibration is also enabled).</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="set">
															<div class="details">
																<h5>Turn On Lights</h5>
																<p>When someone send you a text message you will receive alert via notification light.</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Notifications Settings -->
											<!-- Start of Connections -->
											<div class="category">
												<a href="#" class="title collapsed" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
													<i class="material-icons md-30 online">sync</i>
													<div class="data">
														<h5>Connections</h5>
														<p>Sync your social accounts</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
												<div class="collapse" id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionSettings">
													<div class="content">
														<div class="app">
															<img src="dist/img/integrations/slack.svg" alt="app">
															<div class="permissions">
																<h5>Skrill</h5>
																<p>Read, Write, Comment</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/dropbox.svg" alt="app">
															<div class="permissions">
																<h5>Dropbox</h5>
																<p>Read, Write, Upload</p>
															</div>
															<label class="switch">
																<input type="checkbox" checked>
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/drive.svg" alt="app">
															<div class="permissions">
																<h5>Google Drive</h5>
																<p>No permissions set</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
														<div class="app">
															<img src="dist/img/integrations/trello.svg" alt="app">
															<div class="permissions">
																<h5>Trello</h5>
																<p>No permissions set</p>
															</div>
															<label class="switch">
																<input type="checkbox">
																<span class="slider round"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<!-- End of Connections -->
											
											<!-- Start of Logout -->
											<div class="category">
												<a href="<?php echo base_url('ChatController/logout')?>" class="title collapsed">
													<i class="material-icons md-30 online">power_settings_new</i>
													<div class="data">
														<h5>Power Off</h5>
														<p>Log out of your account</p>
													</div>
													<i class="material-icons">keyboard_arrow_right</i>
												</a>
											</div>
											<!-- End of Logout -->
										</div>
									</div>
								</div>
								<!-- End of Settings -->
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
				<!-- Start of Add Friends -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Add your friends</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form>
									<div class="form-group">
										<label for="user">Username:</label>
										<input type="text" class="form-control" id="user" placeholder="Add recipient..." required>
										<div class="user" id="contact">
											<img class="avatar-sm" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
											<h5>Keith Morris</h5>
											<button class="btn"><i class="material-icons">close</i></button>
										</div>
									</div>
									<div class="form-group">
										<label for="welcome">Message:</label>
										<textarea class="text-control" id="welcome" placeholder="Send your welcome message...">Hi Keith, I'd like to add you as a contact.</textarea>
									</div>
									<button type="submit" class="btn button w-100">Send Friend Request</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Add Friends -->
				<!-- Start of Create Chat -->
				<div class="modal fade" id="startnewchat" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Start new chat</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form method="post" action="<?php echo base_url('ChatController/buatroom'); ?>">
									<div class="form-group">
										<label for="participant">Recipient:</label>
                                        <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height:50px;width:100%;color:white;background-color:black" >
                                          Daftar Admin
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                           <?php foreach ($arrItem3 as $key1): ?>
                                              <?php if(($key1->level=='admin'||$key1->level=='kontributor') and $key1->status_online=='1') {?>
                                                     <?php if($key1->username!=$username) {?>
                                                       <a class="dropdown-item" href="<?php echo base_url('ChatController/buatroom/'.$key1->username); ?>"><?php echo $key1->username;?></a>
                                                    <?php }?>
                                              <?php }?>
                                            <?php endforeach;?>
                                          </div>
                                        </div>
                                        
                                        <?php if($level==""){?>
                                        <br>
                                            <div class="dropdown">
                                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height:50px;width:100%;color:white;background-color:black" >
                                              Daftar Tiket
                                              </button>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 150px; overflow: auto;">
                                               <?php foreach ($tiket as $key2): ?>
                                                    <a class="dropdown-item" href="<?php echo base_url('ChatController/detail/'.$key2->id_ticket); ?>"><?php echo $key2->id_ticket;?></a>
                                                <?php endforeach;?>
                                              </div>
                                            </div>
                                        <?php }?>
                                        <br>
                                        <?php if($level!="") {?>
                                            <div class="dropdown">
                                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height:50px;width:100%;color:white;background-color:black" >
                                               Reseller
                                              </button>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 150px; overflow: auto;">
                                               <?php foreach ($arrItem4 as $key2): ?>

                                                         <?php if($key1->username!=$username) {?>
                                                           <a class="dropdown-item" href="<?php echo base_url('ChatController/buatroom/'.$key2->username); ?>"><?php echo $key2->username;?></a>
                                                        <?php }?>

                                                <?php endforeach;?>
                                              </div>
                                            </div>
                                            <br>
                                            <div class="dropdown">
                                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height:50px;width:100%;color:white;background-color:black" >
                                               Konsumen
                                              </button>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="height: 150px; overflow: auto;">
                                               <?php foreach ($arrItem5 as $key2): ?>

                                                         <?php if($key1->username!=$username) {?>
                                                           <a class="dropdown-item" href="<?php echo base_url('ChatController/buatroom/'.$key2->username); ?>"><?php echo $key2->username;?></a>
                                                        <?php }?>

                                                <?php endforeach;?>
                                              </div>
                                            </div>
                                        <?php } ?>
<!--										<input type="text" class="form-control" id="participant" placeholder="Add recipient..." required>-->
									
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Create Chat -->
				<div class="main">
					<div class="tab-content" id="nav-tabContent">
						<!-- Start of Babble -->
						<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat1">
                                <?php if($koderoom!=""){?>
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="<?php echo base_url()?>asset/dist/img/avatars/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="Receiver" alt="avatar"></a>
												<div class="status">
													<i class="material-icons online">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#"><?php
                                                                        $namalawanchat="";
                                                                        $query = $this->db->query("SELECT sender FROM room_chat where id_room ='$koderoom'");
                                                                        foreach ($query->result_array() as $row){
                                                                            $namalawanchat=$row['sender'];
                                                                        }
                                                                        if($namalawanchat==$username)
                                                                        {
                                                                             $query = $this->db->query("SELECT receiver FROM room_chat where id_room ='$koderoom'");
                                                                                foreach ($query->result_array() as $row){
                                                                                    $namalawanchat=$row['receiver'];
                                                                                }
                                                                        }
                                                                        echo $namalawanchat
                                                                    ?>
                                                        </a></h5>
                                                        <?php
                                                            $status="";
                                                            $status_user="";
                                                            $query = $this->db->query("SELECT status_online FROM users where username ='$namalawanchat'");
                                                            foreach ($query->result_array() as $row){
                                                                $status=$row['status_online'];
                                                            }
                                                            if($status=="1")
                                                            {
                                                                $status_user="Online";
                                                            }else{
                                                                $status_user="Offline";
                                                            }
                                                        ?>
                                                        
<!--												   <span><?php echo $status_user;?></span>-->
												</div>
<!--
												<button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item connect" name="1"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item connect" name="1"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
-->
											</div>
										</div>
									</div>
								</div>
                            <?php }?>
								<div class="content" id="content">
                                     
								
                                    <div class="container">
                                        <?php foreach ($arrItem2 as $key1): ?>
                                    <?php if($key1->id_room==$koderoom) {?> 
										<div class="col-md-12">
<!--
											<div class="date">
												<hr>
												<span>Yesterday</span>
												<hr>
											</div>
-->
                                             <?php if($key1->username!=$username) {?>
											<div class="message">
												<img class="avatar-md" src="<?php echo base_url()?>asset/dist/img/avatars/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="User" alt="avatar">
												<div class="text-main">
													<div class="text-group">
														<div class="text" style="color:black">
															<p><?php echo $key1->message;?></p>
														</div>
													</div>
													<span><?php echo $key1->time;?></span>
												</div>
											</div>
                                             <?php }?>
                                            <?php if($key1->username==$username) {?>
											<div class="message me">
												<div class="text-main">
													<div class="text-group me">
														<div class="text me">
															<p><?php echo $key1->message;?></p>
														</div>
													</div>
													<span><?php echo $key1->time;?></span>
												</div>
											</div>
											<?php }?>
<!--
											<div class="message">
												<img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
												<div class="text-main">
													<div class="text-group">
														<div class="text typing">
															<div class="wave">
																<span class="dot"></span>
																<span class="dot"></span>
																<span class="dot"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
-->
										</div>
                                           <?php }?>
                                    <?php endforeach;?>
									</div>
								</div>
                                <?php if($koderoom!=""){?>
								<div class="container" style="color:black;">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100" method="post" action="<?php echo base_url('ChatController/sendmessage/'.$koderoom);?>">
												<textarea class="form-control" style="color:black;" name="message" placeholder="Ketik Pesanmu disini..." rows="1" ></textarea>
<!--												<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>-->
												<button type="submit" class="btn send"><i class="material-icons">send</i></button>
											</form>
<!--
											<label>
												<input type="file">
												<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
-->
										</div>
									</div>
								</div>
                             <?php }else {?>
                                <div class="container">
										<div class="col-md-12">
											<div class="no-messages" style="margin-top:-20%">
												<i class="material-icons md-48" style="margin-left:40%;font-size:100px">forum</i>
												<p style="margin-left:30%">Jangan ragu untuk bertanya, silahkan hubungi kami segera :)</p>
											</div>
										</div>
									</div>
                                <?php }?>
							</div>
							<!-- End of Chat -->
							<!-- Start of Call -->
							<div class="call" id="call1">
								<div class="content">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<div class="panel">
													<div class="participant">
														<img class="avatar-xxl" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
														<span>Connecting</span>
													</div>							
													<div class="options">
														<button class="btn option"><i class="material-icons md-30">mic</i></button>
														<button class="btn option"><i class="material-icons md-30">videocam</i></button>
														<button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
														<button class="btn option"><i class="material-icons md-30">person_add</i></button>
														<button class="btn option"><i class="material-icons md-30">volume_up</i></button>
													</div>
													<button class="btn back" name="1"><i class="material-icons md-24">chat</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Call -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-empty" role="tabpanel" aria-labelledby="list-empty-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat2">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="dist/img/avatars/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Lean" alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#">Lean Avent</a></h5>
													<span>Inactive</span>
												</div>
												<button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item connect" name="2"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item connect" name="2"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages">
												<i class="material-icons md-48">forum</i>
												<p>Seems people are shy to start the chat. Break the ice send the first message.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
												<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
												<button type="submit" class="btn send"><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file">
												<span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
							<!-- Start of Call -->
							<div class="call" id="call2">
								<div class="content">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<div class="panel">
													<div class="participant">
														<img class="avatar-xxl" src="dist/img/avatars/avatar-female-2.jpg" alt="avatar">
														<span>Connecting</span>
													</div>							
													<div class="options">
														<button class="btn option"><i class="material-icons md-30">mic</i></button>
														<button class="btn option"><i class="material-icons md-30">videocam</i></button>
														<button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
														<button class="btn option"><i class="material-icons md-30">person_add</i></button>
														<button class="btn option"><i class="material-icons md-30">volume_up</i></button>
													</div>
													<button class="btn back" name="2"><i class="material-icons md-24">chat</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Call -->
						</div>
						<!-- End of Babble -->
						<!-- Start of Babble -->
						<div class="babble tab-pane fade" id="list-request" role="tabpanel" aria-labelledby="list-request-list">
							<!-- Start of Chat -->
							<div class="chat" id="chat3">
								<div class="top">
									<div class="container">
										<div class="col-md-12">
											<div class="inside">
												<a href="#"><img class="avatar-md" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
												<div class="status">
													<i class="material-icons offline">fiber_manual_record</i>
												</div>
												<div class="data">
													<h5><a href="#">Louis Martinez</a></h5>
													<span>Inactive</span>
												</div>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-30">phone_in_talk</i></button>
												<button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-36">videocam</i></button>
												<button class="btn d-md-block disabled d-none" disabled><i class="material-icons md-30">info</i></button>
												<div class="dropdown">
													<button class="btn disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled><i class="material-icons md-30">more_vert</i></button>
													<div class="dropdown-menu dropdown-menu-right">
														<button class="dropdown-item"><i class="material-icons">phone_in_talk</i>Voice Call</button>
														<button class="dropdown-item"><i class="material-icons">videocam</i>Video Call</button>
														<hr>
														<button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
														<button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
														<button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<div class="no-messages request">
												<a href="#"><img class="avatar-xl" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
												<h5>Louis Martinez would like to add you as a contact. <span>Hi Keith, I'd like to add you as a contact.</span></h5>
												<div class="options">
													<button class="btn button"><i class="material-icons">check</i></button>
													<button class="btn button"><i class="material-icons">close</i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100">
												<textarea class="form-control" placeholder="Messaging unavailable" rows="1" disabled></textarea>
												<button class="btn emoticons disabled" disabled><i class="material-icons">insert_emoticon</i></button>
												<button class="btn send disabled" disabled><i class="material-icons">send</i></button>
											</form>
											<label>
												<input type="file" disabled>
												<span class="btn attach disabled d-sm-block d-none"><i class="material-icons">attach_file</i></span>
											</label> 
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
						</div>
						<!-- End of Babble -->
					</div>
				</div>
			</div> <!-- Layout -->
		</main>
		<!-- Bootstrap/Swipe core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="<?php echo base_url();?>asset/dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="<?php echo base_url();?>asset/dist/js/vendor/popper.min.js"></script>
		<script src="<?php echo base_url();?>asset/dist/js/swipe.min.js"></script>
		<script src="<?php echo base_url();?>asset/dist/js/bootstrap.min.js"></script>
		<script>
			function scrollToBottom(el) { el.scrollTop = el.scrollHeight; }
			scrollToBottom(document.getElementById('content'));
		</script>
	</body>

</html>