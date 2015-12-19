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

// get all products from products table
$sql = "SELECT * FROM events WHERE  `events_day_date` >= now() ORDER BY events_day_date ASC LIMIT 5";
$result = mysql_query($sql);

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["events"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["events_id"] = $row['events_id'];
        $product["events_topic"] = $row['events_topic'];
        $product["events_desc"] = $row["events_desc"];
        $product["created_at"] = date('d', strtotime($row['events_day_date']));
        $product["updated_at"] = date('M', strtotime($row['events_day_date']));


        // push single product into final response array
        array_push($response["events"], $product);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";

    // echo no users JSON
    echo json_encode($response);
}
?>
