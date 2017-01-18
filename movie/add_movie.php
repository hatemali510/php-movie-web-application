<?php 
require_once 'core/init.php';
$user = new user();
if(!$user->isLoggedIn()){
		Redirect::to('login.php');
}

$data = $user->data();
$id=$data->id;
if(input::exists()){
	if(token::check(input::get('token'))){

	$Validate=new validate();
	$validation=$Validate->check($_POST, array(
		'name' => array(
			'required'=>true,
			'min'=> 2,
			'max' => 100,
		),
		'quant' => array(
			'required'=>true,
			'min' => 1
		),
		'cat_movie' => array(
			'required' => true
		),
		'type' => array(
			'required'=>true
			),
		'price' => array(
			'required'=>true
			),
		'date' => array(
			'required'=>true
			),
		'description' =>array(
			'required'=>true
			)

		));

	// In an application, this could be moved to a config file
$upload_errors = array(
	// http://www.php.net/manual/en/features.file-upload.errors.php
  UPLOAD_ERR_OK 				=> "No errors.",
  UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
  UPLOAD_ERR_NO_FILE 		=> "No file.",
  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
);

	$tmp_file = $_FILES['file_upload']['tmp_name'];
	$temp = basename(input::get('name'));
	$target_file = str_replace(' ', '', $temp.".jpg");
	$upload_dir = "images/posters";
  	move_uploaded_file($tmp_file, $upload_dir."/".$target_file);

	if($validation->passed()){
		$conn=DB::getInstance();
		try{
			$conn->insert('added_movies',array(
				'name' => input::get('name'),
				'quantity' => input::get('quant'),
				'category'=>input::get('cat_movie'),
                'type' => input::get('type'),
				'seller_id' => $id,
				'price' => input::get('price'),
				'yearofproduction' => input::get('date'),
				'status'=>'new',
				'description' => input::get('description'),
				'poster_name'=>$target_file

			));
			Redirect::to('approved.php');

		} catch(Exception $e){
			die($e->getMessage());
		}
	} else {
		foreach($validation->errors() as $error){
			echo $error, '<br>';

		}

	}

}
}
include('header.php');		
?>
<div class="row">
	<div id="menu">
		<nav>
		<div class="wrap-nav">
		   <ul>
			 <li class="active"><a href="index.php">Home</a></li>
		   	 <li><a href="logout.php">logout</a></li>
		   </ul>
		</div>
		</nav>
	</div>
</div>
	</div>
</header>
	<div class="wrap-container zerogrid">
		<div id="main-content" class="col-2-3">
		<div class="movie">
		<div class="title">
			<center><h2>ADD MOVIE</h2></center>
		</div>
		<center><form action ="" enctype="multipart/form-data" method="post">
		Movie Name:<br><input type="text" name="name"><br>
  		Quantity:<br><input type="text" name="quant"><br>
		
		Category: 
	    <select name="cat_movie">
		    <option value="comedy">Comedy</option>
		    <option value="horror">Horror</option>
		    <option value="tragedy">Tragedy</option>
		    <option value="action">Action</option>
		    <option value="drama">Drama</option>
		    <option value="Documentry">Documentry</option>
		</select><br>
		Movie Type:&nbsp;
		  <input type="radio" name="type" value="dvd"> DVD &nbsp; <input type="radio" name="type" value="video"> Video<br>
		Price:<br><input type="text" name="price"><br>
		Year Of Production:<br><input type="date" data-date-inline-picker="true"  name="date"/><br>
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
   	    Movie Poster:<br><input required type="file" name="file_upload" /><br>
		Description :<br><textarea name="description" cols="40" rows="8"></textarea><br>
  		
		  
		<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
		<button class="button button1" type="submit" value="add">Add</button>
		
		</center></form>
		</div>
		</div>
	</div>
<?php include('footer.php'); ?>