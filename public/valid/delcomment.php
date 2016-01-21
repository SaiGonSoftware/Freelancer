<?php 
mysql_connect ('localhost', 'root', '');
mysql_select_db('freelancer');

if (!empty($_POST)) {
	$id=$_POST['id'];
	mysql_query("DELETE FROM comments WHERE id = $id") 
	or mysql_error();
	echo "Xóa thành công";
}
else {
	echo "Có lỗi xảy ra";
}

?>