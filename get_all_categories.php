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

$result = mysql_query("SELECT * FROM categories") or die(mysql_error());

if (mysql_num_rows($result) > 0) {
  
    $response["categories"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        
        $category = array();
        $category["cat_id"] = $row["cat_id"];
        $category["cat_name"] = $row["cat_name"];
        $category["cat_description"] = $row["cat_description"];
       

        array_push($response["categories"], $category);
    }
   
    $response["success"] = 1;
    echo json_encode($response);
	
} else {
  
    $response["success"] = 0;
    $response["message"] = "No category found";

    echo json_encode($response);
}
?>
