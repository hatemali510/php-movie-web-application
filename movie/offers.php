<?php 
	require_once 'core/init.php';
	include('header.php');

	$user = new user();
	if(!$user->isLoggedIn()){
			Redirect::to('login.php');
	}

	$data = $user->data();
	$id=$data->id;

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
			<center><h2>Offers</h2></center>
		</div>
		<center>
		<div class="row">
				
	<?php
		$offer=DB::getInstance()->get('added_movies',array('seller_id','=', $id));
		echo  '<h2>your Offers Info are : </h2>';
			
		if($offer->count()){
			foreach($offer->results() as $row){
			$movie_id=$row->id;
			$movie_name=$row->name;
			$production_year=$row->yearofproduction;
			echo '<ul><li><h3><a href="update_movie.php/?id=',$movie_id,'">',$movie_name,'(',$production_year,')</a></h3></li></br></ul>';
			}
			session::put('seller_id', $id);

	     	
		}
	?>
	</div>
	</center>
	</div></div></div>

<?php include('footer.php'); ?>