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
        $events = array();
        $events["events_id"] = $row['events_id'];
        $events["events_topic"] = $row['events_topic'];
        $events["events_desc"] = htmlspecialchars_decode($row["events_desc"]);
        $events["events_date"] = date('d', strtotime($row['events_day_date']));
        $events["events_month"] = date('M', strtotime($row['events_day_date']));


        // push single product into final response array
        array_push($response["events"], $events);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No Upcoming Events found";

    // echo no users JSON
    echo json_encode($response);
}
?>
