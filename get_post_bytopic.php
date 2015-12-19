<?php

$response = array();

require_once __DIR__ . '/db_connect.php';

$db = new DB_CONNECT();

if (isset($_GET["post_topic"])) {
    $post_topic = $_GET['post_topic'];

    $result = mysql_query("SELECT * FROM posts INNER JOIN users ON posts.post_by = users.user_id INNER JOIN topics ON topics.topic_id = posts.post_topic WHERE post_topic = $post_topic") or die(mysql_error());

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {
			
			 $response["posts "] = array();

		 while ($row = mysql_fetch_array($result)) {
            //$result = mysql_fetch_array($result);
                        $newTime = date('m/d/Y H:i:s', strtotime($row['post_date']));
                        //function elapsedTimeAgo ($newTime) {
                        date_default_timezone_set('America/New_York');
                        $l = date('m/d/Y H:i:s', time());
                        
                          $a = strtotime($l);
                            $b = strtotime($newTime);
                            $timeCalc = $a - $b;
                            $elapsedTimeText = "";

                            if ($timeCalc > (60*60*24*7)) {
                                $elapsedTimeText = round($timeCalc/60/60/24/7) . "&nbsp;weeks ago";
                            } 
                            elseif ($timeCalc > (60*60*24)) {
                                $elapsedTimeText = round($timeCalc/60/60/24) . "&nbsp;days ago";
                            }
                            else if ($timeCalc > (60*60)) {
                                $elapsedTimeText = round($timeCalc/60/60) .  "&nbsp;hrs ago";
                            }else if ($timeCalc > (60)) {
                                $elapsedTimeText = round($timeCalc/60) .  "&nbsp;min ago";
                            } else if ($timeCalc > 0) {
                                $elapsedTimeText .= round($timeCalc/2) ."sec ago";
                            } else {
                                $elapsedTimeText .=  "&nbsp;Just Posted";
                            } 
                        
            $posts = array();
            $posts ["post_title"] = $row["topic_subject"];
            $posts ["post_topic"] = $row["post_topic"];
            $posts ["post_id"] = $row["post_id"];
            $posts ["post_content"] = $row["post_content"];
            $posts ["post_date"] = date('h:i A', strtotime($row['post_date']))."(".$elapsedTimeText.")";
            $posts["post_by"] = $row["user_name"];
           // $posts ["updated_at"] = $result["updated_at"];
		   
		   
		    

            array_push($response["posts "], $posts );
		 }
            $response["success"] = 1;

          

            // echoing JSON response
            echo json_encode($response);
        } else {
           
            $response["success"] = 0;
            $response["message"] = "There is no post related to this topic";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
       
        $response["success"] = 0;
        $response["message"] = "There is no post related to this topic";

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