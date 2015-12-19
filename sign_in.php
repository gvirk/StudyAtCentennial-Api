<?php


// json response array
$response = array("error" => FALSE);

if (isset($_POST['user_name']) && isset($_POST['user_pass'])) {

    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
    // get the user by email and password
  $sql = "SELECT 
                        *
                    FROM
                        users
                    WHERE
                        user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
                    AND
                        user_pass = '" . $_POST['user_pass'] . "'";
    $result = mysql_query($sql);

            if (mysql_num_rows($sql) > 0) {
                
                                        while($row = mysql_fetch_assoc($result))
                                                    {
                                        // use is found
                                        $response["error"] = FALSE;
                                        $response["user_id"] = $row["user_id"];
                                        $response["user"]["user_name"] = $row["user_name"];
                                        $response["user"]["user_email"] = $row["user_email"];
                                        $response["user"]["user_level"] = $row["user_level"];
                                        $response["user"]["user_date"] = $row["user_date"];
                                        echo json_encode($response);
                                     }
            }
    
     else {
        $response["error"] = TRUE;
        $response["message"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
     }
} 
else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["message"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}


?>