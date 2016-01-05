<?php 
	mysql_connect ('localhost', 'root', '');
   	mysql_select_db('freelancer');


if (isset($_POST['username'])) {
	$username=mysql_real_escape_string($_POST['username']);
	if (!empty($username)) {
		$query = "SELECT * FROM users WHERE username = '".mysql_real_escape_string($_POST['username'])."'";
		if(mysql_num_rows(mysql_query($query)) == 0){
			echo "Tên đăng nhập có thể sử dụng";
		}
		else 
		{ 
		   echo "Tên đăng nhập đã được sử dụng";
		} 
	}
}

if (isset($_POST['email'])) {
	$email=mysql_real_escape_string($_POST['email']);
	if (!empty($email)) {
		$query = "SELECT * FROM users WHERE email = '".mysql_real_escape_string($_POST['email'])."'";
		if(mysql_num_rows(mysql_query($query)) == 0){
			echo "Email có thể sử dụng";
		}
		else 
		{ 
		   echo "Email đã được sử dụng";
		} 
	}
}
?>