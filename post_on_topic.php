<?php


  require_once __DIR__ . '/db_connect.php';  
    $db = new DB_CONNECT();

$response = array();


if (isset($_POST['post_content']) && isset($_POST['post_topic']) && isset($_POST['post_by'])) {
    
    $post_content = $_POST['post_content'];  
    $post_topic = $_POST['post_topic'];
    $topic_by = $_POST['post_by'];
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
     $result = mysql_query("INSERT INTO posts(post_content,post_date, post_topic, post_by) VALUES('$post_content', NOW(), '$post_topic', '$post_by')");
        }
    if ($result) {
       
        $response["success"] = 1;
        $response["message"] = "Your Comment successfully posted";     
        echo json_encode($response);
    } 
    else {
	
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";    
        echo json_encode($response);
    }
}
} else {
   
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    echo json_encode($response);
}
?>