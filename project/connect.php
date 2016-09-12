<?php
    $db = pg_connect("host=localhost port=5432 dbname=cs2102crowdfunding user=postgres password=a123456789") or die('Could not connect: ' . pg_last_error());

    if (isset($_GET['project_id'])) {
        $project_id = trim($_GET['project_id']);

        $project_query = "select * from project where id = " . $project_id;
        if ($project_result = pg_query($project_query)) {
            $project = pg_fetch_all($project_result)[0];
            $project_id = $project['id'];
            $project_owner_id = $project['owner_id'];
            $project_title = $project['title'];
            $project_description = $project['description'];
            $project_goal = $project['goal'];
            $project_duration = $project['duration'];
            $project_start_date_str = $project['start_date'];
        }
        else
            echo "error", pg_last_error(), "\n";


        $project_start_date = date_create($project_start_date_str);
        $project_end_date = date_create($project_start_date_str);
        $project_duration = new DateInterval('P' . $project_duration . 'D');
        $project_end_date->add($project_duration);
        $today = new DateTime();
        $days_left = date_diff($today, $project_end_date, $absolute = false);


        $categories_query = "select name from category, project_category where project_id = " . $project_id . " and category.id = category_id;";
        if ($categories_result = pg_query($categories_query))
            $categories = pg_fetch_all($categories_result);
        else
            echo "error", pg_last_error(), "\n";


        $owner_query = "select name from account where id = " . $project_owner_id;
        if ($owner_result = pg_query($owner_query))
            $owner = pg_fetch_all($owner_result)[0]['name'];
        else
            echo "error", pg_last_error(), "\n";


        $donation_sum_query = "select sum(amount) from donation where project_id = " . $project_id;
        if ($donation_sum_result = pg_query($donation_sum_query))
            $donation_sum = pg_fetch_all($donation_sum_result)[0]['sum'];
        else
            echo "error", pg_last_error(), "\n";

        $donator_count_query = "select count(distinct user_id) from donation where project_id = " . $project_id;
        if ($donator_count_result = pg_query($donator_count_query))
            $donator_count = pg_fetch_all($donator_count_result)[0]['count'];
        else
            echo "error", pg_last_error(), "\n";

        $donations_query = "select name, * from donation, account where project_id = " 
            . $project_id . 
            " and account.id = user_id order by -amount;";
        if ($donations_result = pg_query($donations_query))
            $donations = pg_fetch_all($donations_result);
        else
            echo "error", pg_last_error(), "\n";

        $percent = $donation_sum / $project_goal * 100;
    }
?>
