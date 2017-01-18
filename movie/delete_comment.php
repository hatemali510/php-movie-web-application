<?php
require_once 'core/init.php';
if(DB::getInstance()->delete('comment',array('id','=',$_POST['id']))){
	echo "done";
	//Redirect::to('delete_movie.php');
}
else{
	echo "not deleted";
	
}

