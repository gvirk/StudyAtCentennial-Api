<?php


/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$result = mysql_query("SELECT * FROM semester") or die(mysql_error());

if (mysql_num_rows($result) > 0) {
  
    $response["categories"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        
        $category = array();
        $category["sem_id"] = $row["sem_id"];
        $category["sem_name"] = $row["sem_name"];
       

        array_push($response["categories"], $category);
    }
   
    $response["success"] = 1;
    echo json_encode($response);
	
} else {
  
    $response["success"] = 0;
    $response["message"] = "No semester found";

    echo json_encode($response);
}
?>
