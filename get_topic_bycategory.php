<?php

$response = array();

require_once __DIR__ . '/db_connect.php';

$db = new DB_CONNECT();

if (isset($_GET["topic_cat"])) {
    $topic_cat = $_GET['topic_cat'];

    $result = mysql_query("SELECT * FROM topics INNER JOIN users ON topic_by = user_id WHERE topic_cat = $topic_cat ORDER BY topics.topic_date DESC") or die(mysql_error());

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
			
			 $response["topics "] = array();

		 while ($row = mysql_fetch_array($result)) {
            //$result = mysql_fetch_array($result);

            $topics = array();
            $topics ["topic_cat"] = $row["topic_cat"];
            $topics ["topic_id"] = $row["topic_id"];
            $topics ["topic_subject"] = $row["topic_subject"];
            $topics ["topic_date"] = date('d', strtotime($row['topic_date']))." ".
                                            date('M', strtotime($row['topic_date']))." ".
                                            date('Y', strtotime($row['topic_date']));
            $topics ["topic_by"] = $row["user_name"];
           // $topics ["updated_at"] = $result["updated_at"];
		   
		   
		    

            array_push($response["topics "], $topics );
		 }
            $response["success"] = 1;

          

            // echoing JSON response
            echo json_encode($response);
        } else {
           
            $response["success"] = 0;
            $response["message"] = "No topic found";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
       
        $response["success"] = 0;
        $response["message"] = "No topic found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>