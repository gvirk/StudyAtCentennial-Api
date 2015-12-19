<?php

$response = array();

require_once __DIR__ . '/db_connect.php';

$db = new DB_CONNECT();

if (isset($_GET["course_id"])) {
    $course_id = $_GET['course_id'];

    $result = mysql_query("SELECT * FROM courses INNER JOIN software ON courses.course_soft = software.soft_id WHERE courses.course_id = $course_id") or die(mysql_error());

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
			
			 $response["posts "] = array();

		 while ($row = mysql_fetch_array($result)) {
            //$result = mysql_fetch_array($result);
                        
            $posts = array();

            $posts ["course_id"] = $row["course_id"];
            $posts ["course_code"] = $row["course_code"];
            $posts ["course_name"] = $row["course_name"];
            $posts ["course_detail"] = $row["course_detail"];
            $posts ["soft_name"] = $row["soft_name"];
            $posts ["soft_link"] = $row["soft_link"];
           // $posts ["updated_at"] = $result["updated_at"];
		    
            array_push($response["posts "], $posts );
		 }
            $response["success"] = 1;

          

            // echoing JSON response
            echo json_encode($response);
        } else {
           
            $response["success"] = 0;
            $response["message"] = "There is no course";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
       
        $response["success"] = 0;
        $response["message"] = "There is no course in this semester";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "There is no course in this semester";

    // echoing JSON response
    echo json_encode($response);
}
?>