<?php


  require_once __DIR__ . '/db_connect.php';  
    $db = new DB_CONNECT();

$response = array();


if (isset($_POST['topic_subject']) && isset($_POST['topic_cat']) && isset($_POST['topic_by']) && isset($_POST['post_content'])) {
    
    $topic_subject = $_POST['topic_subject'];  
    $topic_cat = $_POST['topic_cat'];
    $topic_by = $_POST['topic_by'];
    $post_id = mysql_real_escape_string($_POST['post_content']);
   $result = mysql_query("SELECT user_id FROM users WHERE user_name = '$topic_by'");
   if(!$result)
    {
        $response["success"] = 0;
        $response["message"] = "Something wrong.";    
        echo json_encode($response);
    }
    else
    {
        while($row = mysql_fetch_assoc($result))
        {
            $user_id = $row['user_id'];
  
     $p_result = mysql_query("INSERT INTO topics(topic_subject,topic_date, topic_cat, topic_by) 
        VALUES('$topic_subject', NOW(), '$topic_cat', '$user_id')");
  
    if ($p_result) {
       $topicid = mysql_insert_id();
                
                $result = mysql_query("INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysql_real_escape_string($_POST['post_content']) . "',
                                  NOW(),
                                  " . $topicid . ",
                                  " . $_SESSION['user_id'] . "
                            )";
               if ($p_result) { 
                $result = mysql_query($sql);
        $response["success"] = 1;
        $response["message"] = "Topic successfully created.";     
        echo json_encode($response);
    } else {
    
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";    
        echo json_encode($response);
    }

    } else {
	
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";    
        echo json_encode($response);
    }
}
}
} else {
   
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    echo json_encode($response);
}
?>