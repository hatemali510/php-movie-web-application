<?php 
require_once 'core/init.php';
include('header.php');

$user = new user();
if(!$user->isLoggedIn()){ Redirect::to('login.php'); }

$data = $user->data();
$user_id=$data->id;
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
				)
			));

		$movie_id = intval($_GET['id']);
		
		if($validation->passed()){
			$conn=DB::getInstance();
			try{
				$conn->update('added_movies',$movie_id,array(
					'name' => input::get('name'),
					'quantity' => input::get('quant'),
					'category'=>input::get('cat_movie'),
	                'type' => input::get('type'),
					'seller_id' => $user_id,
					'price' => input::get('price'),
					'yearofproduction' => input::get('date') 
				));
				Redirect::to('../approved.php');

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
	$movie_id = intval($_GET['id']);
	//to select the movie's data and put it in the form
		$movie_data=DB::getInstance()->get('added_movies',array('id','=', $movie_id));
		if($movie_data->count()){
			foreach($movie_data->results() as $row){
			$movie_name=$row->name;
			$quantity=$row->quantity;
			$category=$row->category;
			$price=$row->price;
			$production_year=$row->yearofproduction;
			}
		}
?>

<div class="col-1-2">
	<div class="wrap-col f-right">
		<form method="get" action="/search" id="search"  >
		  <input name="q" type="text" size="40" placeholder="Search..." />
		  <input type="submit" value="Submit">
		</form>
	</div>
</div>
</div>
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
		<center><h2>UPDATE MOVIE</h2></center>
	</div>
	<center>
	<form action ="" method="post">
	Movie Name:<br><input type="text" name="name" value="<?php echo $movie_name;?>"><br>
	Quantity:<br><input type="text" name="quant" value="<?php echo $quantity;?>"><br>
	Category: 
	<select name="cat_movie">
		<option value="comedy">comedy</option>
		<option value="horror">Horror</option>
		<option value="tragedy">Tragedy</option>
	</select><br>
	Movie Type:&nbsp;
	<input type="radio" name="type" value="dvd"> DVD &nbsp; <input type="radio" name="type" value="video"> Video<br>
	Price:<br><input type="text" name="price"value="<?php echo $price;?>"><br>
	Year Of Production:<br><input type="date" data-date-inline-picker="true"  name="date" value="<?php echo $production_year;?>"/><br>
	
	<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	
	<button class="button button1" type="submit" value="update">Update</button>
	</form>
	</center>
			</div>
		</div>
	</div>
<?php include('footer.php'); ?>