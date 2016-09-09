<?php
    $user = 'root';
    $pass = 'a123456789';
    $db = 'cs2102_crowdfunding';

    $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect"); 

    if (isset($_GET['project_id'])) {
        $project_id = trim($_GET['project_id']);

        $find_project = $db->prepare("select id, title, description, owner from project where id = ?;");
        $find_project->bind_param('s', $project_id);  // 's' stands for string
        $find_project->execute();

        $find_project->bind_result($project_id, $project_title, $project_description, $project_owner);
        $find_project->fetch();
        $find_project->close();


        $categories_query = "select category from project_category where project_id = " . $project_id;

        if ($categories_query = $db->query($categories_query))
            $categories = $categories_query->fetch_all(MYSQLI_ASSOC);
            // echo '<pre>', print_r($categories), '</pre>';
        else
            echo "error";


        $owner_query = "select name from user where email = '" . $project_owner . "'";
        if ($owner_query = $db->query($owner_query))
            $owner = $owner_query->fetch_all(MYSQLI_ASSOC)[0]['name'];
        else
            echo "error";
    }
?>
