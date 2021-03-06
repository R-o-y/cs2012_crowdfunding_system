<!DOCTYPE html>
<?php
    if (User::getCurrentUser()) {
        $user = User::getCurrentUser();
    } else {
        redirect('./?_page=login');
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Home Page</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="./public/fancybox/jquery.fancybox.css" type="text/css" media="screen" />

    <!-- font awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body <?php if(User::getCurrentUser()) { echo 'onload="set_interval()" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()"';}?>>
<div class="container">
    <?php require('pages/_header.php'); ?>
    <div class="row">
        <div class="col-md-8">
            <?php
            $search_flag = false;
            if (isset($_GET["search_key"])) {
                $projects = Project::getProjectsByTitle($_GET["search_key"]);
                $search_flag = true;
                echo "<h4>Search Results for '".$_GET['search_key']."'</h4>";
            }
            else {
                $projects = Project::getAll();
                echo "<h4>Current</h4>";
            }
            if (count($projects)) {
                foreach ($projects as $project) {
                    ?>
                    <!--project begin-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $project->title; ?></h3>
                        </div>
                        <div class="panel-body">
                            <!--summary-->
                            <p><?php echo $project->getDescriptionSummary(); ?></p>
                            <!--image display-->
                            <div class="row">
                                <?php
                                $images = $project->getAllImagesUrls();
                                for ($i = 1; $images && $i <= 4 && $i < count($images); $i++) {
                                    ?>
                                    <div class="col-xs-6 col-md-3">
                                        <a class="fancybox thumbnail" rel="group" href="<?php echo $images[$i];?>">
                                            <img src="<?php echo $images[$i];?>"
                                                 style="height: 100px; width: 100%; display: block;"/>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <!--tag display-->
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <?php
                                    foreach ($project->getCategories() as $category) {
                                        ?>
                                            <span class="label label-default"
                                            onclick="window.location.replace('<?php echo url(['_page' => 'home', '_category' => $category->id]); ?>')"
                                            ><?php echo $category->name; ?></span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <br>

                            <!--fund summary-->
                            <!--<div class="alert alert-success" role="alert">...</div>-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-<?php echo $project->getDisplayClass();?>" role="alert">
                                        <div class="row">
                                            <div class="col-xs-6 col-md-3 text-center">
                                                <strong>S$ <?php echo $project->goal; ?></strong>
                                                <div>total goal</div>
                                            </div>
                                            <div class="col-xs-6 col-md-3 text-center">
                                                <strong>S$ <?php echo $project->goal - $project->getRaisedAmount();?></strong>
                                                <div>remaining</div>
                                            </div>
                                            <div class="col-xs-6 col-md-3 text-center">
                                                <strong><?php echo $project->getNumOfDonator();?></strong>
                                                <div>donors</div>
                                            </div>
                                            <div class="col-xs-6 col-md-3 text-center">
                                                <?php
                                                $days_left = $project->getRemainingDay();
                                                if ($project->getRaisedAmount() >= $project->goal) {
                                                    ?>
                                                    <strong class="text-success">Completed</strong>
                                                    <?php
                                                } else if ($days_left > 0) {
                                                    ?>
                                                    <strong><?php echo $days_left;?></strong>
                                                    <div>day active</div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <strong class="text-danger">Due</strong>
                                                    <div><?php echo $days_left;?> days ago.</div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="alert alert-warning" role="alert">...</div>-->
                            <!--<div class="alert alert-danger" role="alert">...</div>-->

                            <!--more detail-->
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="btn btn-default btn-block" href="<?php echo url(['_page' => 'project_detail', 'project_id' => $project->id]); ?>" role="button">More..</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--project end-->
                    <?php
                }
            } else if(!$search_flag){
                ?>
                <div class="alert alert-warning" role="alert">
                    Current not project. <a href="#"><strong>Be the first one</strong></a>  to post project for crowdfunding?
                </div>
                <?php
            } else {
            ?>
                <div class="alert alert-warning" role="alert">
                    No Results Found.
                </div>
            <?php
            }
            ?>

        </div>
        <div class="col-md-4">
            <!--current category-->
            <?php
            $current_category = Category::current();
            if ($current_category) {
                ?>
                <h4>Current Category
                    <?php
                    if (User::getCurrentUser() && User::getCurrentUser()->is_admin) {
                        ?>

                        <a href="#" class="btn btn-info btn-sm" onclick="$('#edit_form').show()">Edit</a>
                        <a href="<?php echo url(['_page' => 'category_op', 'op' => 'delete', 'category_id' => $current_category->id])?>" class="btn btn-danger btn-sm">Delete</a>
                        <?php
                    }
                    ?>
                </h4>
                <div class="list-group">
                    <a href="<?php echo url(['_page' => 'home', '_category' => $current_category->id]) ?>" class="list-group-item active">
                        <?php echo $current_category->name; ?> <span class="badge"><?php echo $current_category->getBelongedNumProjects(); ?></span>
                    </a>
                </div>
                <form class="form-horizontal" id="edit_form" style="display: none;" method="POST" action="<?php echo url(['_page' => 'category_op', 'op' => 'edit']);?>">
                    <div class="form-group">
                        <label for="e_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input autocomplete="off" type="text" class="form-control" id="e_name" name="category_name" value="<?php echo $current_category->name; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $current_category->id?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Edit</button>
                            <button type="button" class="btn btn-default" onclick="$('#edit_form').hide()">Close</button>
                        </div>
                    </div>
                </form>
                <?php
            }
            ?>

            <?php
            if (User::getCurrentUser() && User::getCurrentUser()->is_admin) {
                ?>
                <a href="#" class="btn btn-default btn-block" onclick="$('#create_form').show()">Create Category</a>
                <br>
                <form class="form-horizontal" id="create_form" style="display: none;" method="POST" action="<?php echo url(['_page' => 'category_op', 'op' => 'create']);?>">
                    <div class="form-group">
                        <label for="c_name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input autocomplete="off" type="text" class="form-control" id="c_name" name="category_name" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <button type="button" class="btn btn-default" onclick="$('#create_form').hide()">Close</button>
                        </div>
                    </div>
                </form>
                <?php
            }
            ?>

            <!--tag list-->
            <h4>Category</h4>
            <?php require('pages/_category_list.php'); ?>
        </div>
    </div>
    <?php require('pages/_footer.php'); ?>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<!-- Add fancyBox -->
<script type="text/javascript" src="./public/fancybox/jquery.fancybox.pack.js"></script>
<script>
    $('.thumbnail').fancybox();
</script>
<!-- Add Auto Logout -->
<script type="text/javascript" src="javascript/autologout.js"></script>

</body>
</html>
