<?php

$response = array();

require_once __DIR__ . '/db_connect.php';

$db = new DB_CONNECT();

if (isset($_GET["course_sem"])) {
    $course_sem = $_GET['course_sem'];

    $result = mysql_query("SELECT * FROM courses INNER JOIN semester ON courses.course_sem = semester.sem_id WHERE courses.course_sem = $course_sem") or die(mysql_error());

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
			
			 $response["courses"] = array();

		 while ($row = mysql_fetch_array($result)) {
            //$result = mysql_fetch_array($result);

            $topics = array();
            $topics ["course_sem"] = $row["course_sem"];
            $topics ["course_id"] = $row["course_id"];
            $topics ["course_name"] = $row["course_name"];
            $topics ["course_code"] = $row["course_code"];
           // $topics ["updated_at"] = $result["updated_at"];
		   
		   
		    

            array_push($response["courses"], $topics );
		 }
            $response["success"] = 1;

          

            // echoing JSON response
            echo json_encode($response);
        } else {
           
            $response["success"] = 0;
            $response["message"] = "No courses found";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
       
        $response["success"] = 0;
        $response["message"] = "No courses found";

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