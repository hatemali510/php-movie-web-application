<?php
    require_once 'core/init.php';
    $user=new user();
    if(!$user->isLoggedIn()){ Redirect::to('login.php'); }
   $data = $user->data();
   $id=$data->id;
    $tot= $_SESSION["tot"];
   $conn=DB::getInstance();
        $exist=DB::getInstance()->get('order_num',array('ct_id','=',$id));
        if(!$exist->count()){
		try{
			$conn->insert('order_num',array(
				'ct_id' => $id,
				'total' => $tot
			));
		}
		catch(Exception $e){
			die($e->getMessage());
		}
        }
        else{
            Redirect::to ('old_orders.php');
            }?>
    pay by deliver : <br>
 <form action="deliver_form.php" method="post">
    <input type="submit" value="deliver_details">
</form>
<br>
pay with paypal:
<br>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="no_shipping" value="0">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="AU">
    <input type="hidden" name="bn" value="PP-BuyNowBF">
    <input type="hidden" name="return" value="http://net.tutsplus.com/payment-complete/">
    <br /><br />
    <input type="submit" value="Pay with PayPal!">
</form>