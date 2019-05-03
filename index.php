<?php 

$db = new mysqli('localhost','root','p62nvrpupp','aso');

if($db->connect_error){
	echo "Error in connecting db";
	exit;
}else{
	echo "Db connect success";
	echo "<br>";
	$db->set_charset("utf8");
}


// sql to create table
// $sql = "CREATE TABLE users (
// id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
// name VARCHAR(30) NOT NULL,
// email VARCHAR(50),
// reg_date TIMESTAMP
// )";

// echo $sql;

// if ($db->query($sql) === TRUE) {

// 		echo "Table create cuccess";
// }else{
// 	echo "Error in table create";
// }

// $sql = "INSERT INTO users (name, email)
// VALUES ('John', 'john@example.com');";
// $sql .= "INSERT INTO users (name, email)
// VALUES ('Mary',  'mary@example.com');";
// $sql .= "INSERT INTO users (name, email)
// VALUES ('Julie','julie@example.com')";

// if ($db->multi_query($sql) === TRUE) {
//     echo "New records created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $db->error;
// }

// //insert query 
// 	$sql_insert = "INSERT INTO users(name,age,email) VALUES (?,?,?)";
// 	$res1= $db->prepare($sql_insert);
// 	if($res1){
// 		$name = "ASO";
// 		$age  = "50";
// 		$email = "aso@gmail.com";
// 		$res1->bind_param("sis",$name,$age,$email);
// 		$res1->execute();
// 		$res1->close();
// 	}

//update query
	// $sql_update = "UPDATE users SET name=?,age=?,email=? WHERE id=?";
	// $res2 = $db->prepare($sql_update);
	// if($res2){

	// 	$id = 1;
	// 	$name = "MAMA";
	// 	$age  = "25";
	// 	$email = "mama@gmail.com";

	// 	$res2->bind_param("sisi",$name,$age,$email,$id);
	// 	$res2->execute();
	// 	echo "success";
	// 	$res2->close();
	// }

//delete query

	$sql_delete = "DELETE FROM users WHERE id=?";

	$res3 = $db->prepare($sql_delete);
	if($res3){
		$id = '2';

		$res3->bind_param('i',$id);
		$res3->execute();

		echo "delete success";
		$res->close();
	}
?>

