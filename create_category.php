<?php


  require_once __DIR__ . '/db_connect.php';  
    $db = new DB_CONNECT();

$response = array();


if (isset($_POST['cat_name']) && isset($_POST['cat_description'])) {
    
    $cat_name = $_POST['cat_name'];  
    $cat_description = $_POST['cat_description'];
   
     $result = mysql_query("INSERT INTO categories(cat_name, cat_description) VALUES('$cat_name', '$cat_description')");
  
    if ($result) {
       
        $response["success"] = 1;
        $response["message"] = "Category successfully created.";     
        echo json_encode($response);
    } else {
	
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";    
        echo json_encode($response);
    }
} else {
   
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    echo json_encode($response);
}
?>