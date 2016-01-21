<?php 
mysql_connect ('localhost', 'root', '');
mysql_select_db('freelancer');


if (!empty($_POST)) {
	foreach ($_POST as $field_name => $value) {
		//clean post values
		$field_id=strip_tags(trim($field_name));
		$val=strip_tags(trim(mysql_real_escape_string($value)));
		//from the fieldname:comment_id we need to get comment_id
		$split_data=explode(":", $field_id);
		$comment_id=$split_data[1];
		$field_name=$split_data[0];

		if(!empty($comment_id) && !empty($field_name) && !empty($val)){
			mysql_query("UPDATE comments SET $field_name = '$val' WHERE id = $comment_id") 
			or mysql_error();
			echo "Cập nhật thành công";
		}
		else {
			echo "Có lỗi xảy ra";
		}

	}
}
else {
	echo "Có lỗi xảy ra";
}



?>