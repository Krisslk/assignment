<?php
	
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


?>


<?php



require_once('connection.php');



if (isset($_POST['submit'])) {



	$empid = mysqli_real_escape_string($conn,$_POST['empid']);

	$pass =mysqli_real_escape_string($conn,str_replace(" ","",$_POST['password']));



$query = $conn->prepare("SELECT * FROM employee where emp_id = ?");

$query->bind_param("s",$empid);



if ($query->execute()) {

	

	$results = $query->get_result();



	$results = mysqli_fetch_array($results);



	$emppass = $results['emp_password'];



	if (password_verify($pass,$emppass)) {

		$query2 = $conn->prepare("select bank.bank_name,bank_branch.branch_name from bank JOIN bank_branch where bank_branch.branch_id = ?");
		$query2->bind_param("s",$results['branch_id']);

		$query2->execute();

		$results2 = $query2->get_result();

		$results2 = mysqli_fetch_assoc($results2);
	

		$arrayName = array('status'=>1,'empid' =>$results['emp_id'],'emp_name'=>$results['emp_name'],'emp_email'=>$results['emp_email'],'emp_photo'=>$results['emp_photo'],'emp_address'=>$results['emp_address'],'branch_name'=>$results2['branch_name'],'bank_name'=>$results2['bank_name']);


		echo json_encode($arrayName);



	}else{



		$arrayName = array('message'=>'incorrect employee id or password',"status"=>'failed');

		echo json_encode($arrayName);





	}





}else{



	$message = array('status' =>'failed' ,"message"=>"employee id not found" );



	echo json_encode($message);





}





}



else {



	$message = array('status' =>'failed',"message"=>"not submitted" );



	echo json_encode($message);





}



$query->close();



?>