<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

$response = array("error" => FALSE);

// check for required fields
if (isset($_POST['user_name']) && isset($_POST['user_pass']) && isset($_POST['user_email']) && isset($_POST['user_pass_check'])) {
    
  $user_name = mysql_real_escape_string($_POST['user_name']);
  $user_pass = mysql_real_escape_string($_POST['user_pass']);
  $user_email = mysql_real_escape_string($_POST['user_email']);
  $user_pass_check = mysql_real_escape_string($_POST['user_pass_check']);
  

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
    if ($user_pass == $user_pass_check)
    {
        $chck_name = ("SELECT * FROM users WHERE user_name = '" .mysql_real_escape_string($_POST['user_name']) . "
            ' OR user_email = '".mysql_real_escape_string($_POST['user_email'])."'");
        $check_sql = mysql_query($chck_name);
        if (mysql_num_rows($check_sql) >= 1)
           {
                
                $response["error"] = TRUE;
                $response["message"] = "username or email already exists";
                echo json_encode($response);
           }
        else
            {
    // mysql inserting a new row
            $result = mysql_query("INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('" .mysql_real_escape_string($_POST['user_name']) . "',
                       '" . mysql_real_escape_string($_POST['user_pass']) . "', 
                       '" . mysql_real_escape_string($_POST['user_email']) . "',
                        NOW(),
                        0)");

    // check if row inserted or not
                    if ($result) {
                            $stmt = ("SELECT * FROM users WHERE user_name = '" .mysql_real_escape_string($_POST['user_name']) . "'");
                            $resultchk = mysql_query($stmt);
                           if($resultchk){ while($row = mysql_fetch_assoc($resultchk))
                                {
                                    $response["user_id"] = $row["user_id"];
                                    $response["user"]["user_name"] = $row["user_name"];
                                    $response["user"]["user_email"] = $row["user_email"];
                                    $response["user"]["user_level"] = $row["user_level"];
                                    $response["user"]["user_date"] = $row["user_date"];
                                    echo json_encode($response);
                                    $response["error"] = FALSE;
                                    $response["message"] = "Sign up successfull.";
 
                                }
                            }
                                else{
                                    return false;
                                }
                        // successfully inserted into database
                        

                        // echoing JSON response
                        echo json_encode($response);
                    } else {
                        // failed to insert row
                        $response["error"] = TRUE;
                        $response["message"] = "Oops! An error occurred.";
                        
                        // echoing JSON response
                        echo json_encode($response);
                    }}
        }
    else{
        $response["error"] = TRUE;
        $response["message"] = "Password does not match.";
         echo json_encode($response);
    }
    

}else {
    // required field is missing
    $response["success"] = TRUE;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>