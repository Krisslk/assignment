<?php
	
	// enable cross origin

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


?>


<?php

// get the connection setup

require_once('connection.php');

// get all the employees from the employees table

$query = $conn->prepare("select employee.emp_id,employee.emp_name,employee.emp_email,employee.emp_photo,branch_id from employee");


$query->execute();

$result = $query->get_result();

// check whether there are results available to proceed

if(mysqli_num_rows($result)>0){

	
		// while grabbing data from the result object assign them to data variable

	while ($data = mysqli_fetch_assoc($result)) {
		
		$branchid = $data['branch_id'];

		// query the branch table and bank table with a join query to get data

		$query2 = $conn->prepare("select bank_branch.branch_name,bank_branch.bank_id,bank.bank_name from bank_branch join bank where branch_id = ?");

		$query2->bind_param("s",$branchid);

		$query2->execute();

		$result2 = $query2->get_result();

		$result2 = mysqli_fetch_assoc($result2);

		// assign the required data to variable and then to the array

		$bankname = $result2['bank_name'];

		$branchname = $result2['branch_name'];

		$data['branch_name'] = $branchname;

		$data['bank_name'] = $bankname;


		// remove the branch id from the array

		unset($data['branch_id']);

		// assign the data to final array

		$finaldata[] = $data;

	}

	// sending the data after converting to json format 

	echo json_encode($finaldata);

	$conn->close();

}

// returns no content found message if there is no results in the employee table

else{



	$message = array('httpcode' =>204,'message'=>'no content found' );

	echo json_encode($message);

	$conn->close();

}


?>