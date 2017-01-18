<?php
require_once 'core/init.php';
include('header.php');

$user= new user();
if(!$user->isLoggedIn()){
		Redirect::to('login.php');
	}
	$user= new user($username);
	if(!$user->exists()){
		Redirect::to(404);
		 } else {
			$data = $user->data();
		}
       echo escape($data->username);
       echo "<br>"; 
	   echo escape($data->name);
	   ?>
	  ...... <a href="profile.php">profile</a>
	   <?php
	   include('footer.php');
?>