<?php

// Fonksiyonlar

if(!defined("rs")) {  die("Sorun Olustu!"); }

require ("db.php");


/**
* Ana fonkisyonlar
*/
class project
{
	private $db;
	
	function __construct()
	{
		$this->db = new db();

		$this->db->connection();
	}


	public function login ($email, $password){

		$password = md5($password);

		$sql = "SELECT * FROM `users` WHERE `email` = '" . $email . "' AND `password` = '" . $password . "'";

			

		$result = $this->db->query($sql);


		if($result){

			return $result;

		} else {

			return false;

		}

	}


	public function registration ($email, $password, $name, $surname){


		$password = md5($password);


		$sql = "INSERT INTO `users` (`email`, `password`, `name`, `surname`) VALUES ('" . $email . "', '" . $password . "', '" . $name . "', '" . $surname . "')";
		
		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		}else{

			return false;

		}


	}

	public function show_user ($user){

		$sql = "SELECT * FROM `users` WHERE `id` = '" . $user . "';";

		$result = $this->db->query($sql);

		if($result){
			return $result;
		} else {
			return false;
		}

	}

	/* Masalar fonksiyonlari */
	//////////////////////////////////
	public function get_tables (){

			$sql = "SELECT * FROM `tables`";

			$result = $this->db->query_array($sql);

			if($result){

				return $result;

			} else {

				return false;
			}

	}


	public function add_table ($name, $max_person){

		$sql = "INSERT INTO `tables` (`name`, `max_person`) VALUES ('" . $name . "', '" . $max_person . "');";
		
		$result = $this->db->query_insert($sql);

		if ($result) {

			return $result;

		} else {

			return false;

		}


	}


	public function show_table ($table_id){

		$sql = "SELECT * FROM `tables` WHERE `id` = '" . $table_id . "'";

		$result = $this->db->query($sql);


		if($result){

			return $result;

		} else {

			return false;

		}

	}



	public function edit_table ($table_id, $table_name, $table_max_person){

		$sql = "UPDATE `tables` SET `name` = '" . $table_name . "', `max_person` = '" . $table_max_person . "' WHERE `tables`.`id` = " . $table_id . ";";
		
		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		} else {

			return false;

		}

	}


	public function delete_table ($table_id){

		$sql = "DELETE FROM `tables` WHERE `id` = '" . $table_id . "';";
		
		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		}else{

			return false;

		}

	}

	/* Menu kategorileri fonksiyonlari */

	public function get_product_category (){

			$sql = "SELECT * FROM `product_category`";


			$result = $this->db->query_array($sql);


			if($result){

				return $result;

			} else {

				return false;

			}

	}


	public function add_product_category ($product_category_name){

		$sql = "INSERT INTO `product_category` (`name`) VALUES ('" . $product_category_name . "');";
		
		$result = $this->db->query_insert($sql);

		if ($result) {

			return $result;

		} else {

			return false;
		}

	}


	public function show_product_category ($product_category_id){

		$sql = "SELECT * FROM `product_category` WHERE `id` = '" . $product_category_id . "'";

		
		$result = $this->db->query($sql);


		if($result){

			return $result;

		} else {

			return false;

		}
	}



	public function edit_product_category ($product_category_id, $product_category_name){

		$sql = "UPDATE `product_category` SET `name` = '" . $product_category_name . "' WHERE `product_category`.`id` = " . $product_category_id . ";";
		
		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		}else{

			return false;
		}

	}


	public function delete_product_category ($product_category_id){

		$sql = "DELETE FROM `product_category` WHERE `id` = '" . $product_category_id . "';";
		

		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		}else{

			return false;

		}

	}

	/* Menu ürunlerı fonksiyonlari */

	public function get_products (){

		$sql = "SELECT * FROM `products`";


		$result = $this->db->query_array($sql);


		if($result){

			return $result;

		} else {

			return false;

		}

	}

	public function get_products_by_category ($product_category_id){

		$sql = "SELECT * FROM `products` WHERE `product_category_id` = " . $product_category_id;


		$result = $this->db->query_array($sql);


		if($result){

			return $result;

		} else {

			return false;

		}

	}

	public function add_product ($product_name, $product_image, $product_desc, $product_price, $product_category_id){

		$sql = "INSERT INTO `products` (`name`, `image`, `description`,  `price`, `product_category_id`) VALUES ('" . $product_name . "', '" . $product_image . "', '" . $product_desc . "', '" . $product_price . "', '" . $product_category_id . "');";
		
		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		}else{

			return false;

		}


	}


	public function show_product ($product_id){

		$sql = "SELECT * FROM `products` WHERE `id` = '" . $product_id . "'";

		$result = $this->db->query($sql);


		if($result){

			return $result;

		} else {

			return false;

		}

	}



	public function edit_product ($product_id, $product_name, $product_image, $product_desc, $product_price, $product_category_id){

		$sql = "UPDATE `products` SET `name` = '" . $product_name . "', `image` = '" . $product_image . "',`description` = '" . $product_desc . "', `price` = '" . $product_price . "', `product_category_id` = '" . $product_category_id . "'  WHERE `products`.`id` = " . $product_id . ";";
		
		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		}else{

			return false;

		}


	}


	public function delete_product ($product_id){

		$sql = "DELETE FROM `products` WHERE `id` = '" . $product_id . "';";
		

		$result = $this->db->query_insert($sql);

		if ($result	) {

			return $result;

		}else{

			return false;

		}


	}

	public function search_product($query){

		$sql = "SELECT * FROM `products` WHERE `name` LIKE '%" . $query . "%'";

		$result = $this->db->query_array($sql);

		if($result){

			return $result;

		} else {

			return false;

		}

	}

	/* Order */
	public function add_order ($order_id, $table, $user, $total, $created){

		$sql = "INSERT INTO `order` (`order_id`, `table`, `user`, `total`, `created`) VALUES ('" . $order_id . "', '" . $table . "', '" . $user . "', '" . $total . "', '" . $created . "');";
		
		$result = $this->db->query_insert($sql);

		if ($result) {

			return $result;

		} else {

			return false;
		}

	}

	public function add_order_product ($order_id, $product_id, $product_quantity){

		$sql = "INSERT INTO `order_products` (`order_id`, `product_id`, `product_quantity`) VALUES ('" . $order_id . "', '" . $product_id . "', '" . $product_quantity . "');";
		
		$result = $this->db->query_insert($sql);

		if ($result) {
			return $result;
		} else {
			return false;
		}

	}
	public function show_user_order($user, $order){

		$sql = "SELECT * FROM `order` WHERE `user` = '" . $user . "' AND `id` = " . $order;

		$result = $this->db->query($sql);

		if($result){

			return $result;

		} else {

			return false;

		}
	}
	public function show_user_orders($user, $sort = ""){

		if($sort){

			if($sort == "pending"){
				$status = 0;
			} else if($sort == "accepted"){
				$status = 1;
			} else if($sort == "completed"){
				$status = 2;
			} else if($sort == "declined"){
				$status = 3;
			} else {
				$status = 0;
			}

			$sql = "SELECT * FROM `order` WHERE `user` = '" . $user . "' AND `status` = " . $status;

		} else {

			$sql = "SELECT * FROM `order` WHERE `user` = " . $user;
		}

		$result = $this->db->query_array($sql);

		if($result){

			return $result;

		} else {

			return false;

		}
	}
	public function show_admin_order($order){

		$sql = "SELECT * FROM `order` WHERE `id` = " . $order;

		$result = $this->db->query($sql);

		if($result){

			return $result;

		} else {

			return false;

		}
	}

	public function show_admin_orders($sort = ""){
		if($sort){
			if($sort == "pending"){
				$status = 0;
			} else if($sort == "accepted"){
				$status = 1;
			} else if($sort == "completed"){
				$status = 2;
			} else if($sort == "declined"){
				$status = 3;
			} else {
				$status = 0;
			}

			$sql = "SELECT * FROM `order` WHERE `status` = " . $status;

		} else {

			$sql = "SELECT * FROM `order`;";
		}

		$result = $this->db->query_array($sql);

		if($result){

			return $result;

		} else {

			return false;

		}

	}
	// Show product order
	public function show_products_order($order_id){

		$sql = "SELECT * FROM `order_products` WHERE `order_id` = " . $order_id;

		$result = $this->db->query_array($sql);

		if($result){

			return $result;

		} else {

			return false;

		}

	}
	// Update order status
	public function update_admin_order($order, $status = ""){

		if($status == "pending"){
			$status = 0;
		} else if($status == "accepted"){
			$status = 1;
			$this->update_admin_order_time($order, $status);
		} else if($status == "completed"){
			$status = 2;
			$this->update_admin_order_time($order, $status);
		} else if($status == "declined"){
			$status = 3;
		} else {
			$status = 0;
		}

		$sql = "UPDATE `order` SET `status` = '" . $status . "' WHERE `order`.`id` = " . $order . ";";

		$result = $this->db->query_insert($sql);

		if ($result) {
			return $result;
		} else {
			return false;
		}
	}
	// Update order start time
	public function update_admin_order_time($order, $status = ""){

		$time = time();

		if($status == "1"){
			$level = "start";
		}

		if($status == "2"){
			$level = "end";
		}

		$sql = "UPDATE `order` SET `" . $level . "` = '" . $time . "' WHERE `order`.`id` = " . $order . ";";

		$result = $this->db->query_insert($sql);

		if ($result) {
			return $result;
		} else {
			return false;
		}
	}

	// That's all

}

