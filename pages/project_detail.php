<?php
// get project first
$project = Project::getProjectById($_GET['project_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php
    if ($project) {
        ?>
        <title>Project detail - Cannot find the project in database</title>
        <?php
    } else {
        ?>
        <title>Project - <?php echo $project->title; ?></title>
        <?php
    }
    ?>
    <title>Home Page</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Template CSS -->
    <link href="public/project_detail.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php require('pages/_header.php'); ?>

    <!--main content-->
    <div class="row">
        <div class="content col-md-8 col-sm-12 col-xs-12">
            <div class="section-block">
                <div class="funding-meta">
                    <h4>PROJECT #<?php echo $project->id;?>:</h4>
                    <h1><?php echo $project->title;?></h1>
                    <p>subtitle: there is some more information about the project</p>
                    <hr>
                    <div class="type-meta">
                        <i class="fa fa-user"></i>
                        <b>
                        Xiao Pu
                        </b>
                    </div>
                    <br>
                    <div class="type-meta"><i class="fa fa-tag"></i><b>
                        <?php
                        foreach ($project->getCategories() as $category) {
                            ?>

                            <span class="label label-default"
                                  onclick="window.location.replace('<?php echo url(['_page' => 'home', '_category' => $category->id]); ?>')"
                            ><?php echo $category->name; ?></span>

                            <?php
                        }
                        ?>
                    </b></div>


                    <h2>
                        S$12322422
                    </h2>
                    <span class="contribution">raised by <strong>
                        13454
                    </strong> donators</span>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                            60%
                        </div>
                    </div>
                    <span class="goal-progress"><strong>
                            3%</strong> of raised</span>
                    <hr>
                    <span class="goal-progress">
                    Started at
                    <strong>
                        <?php
                            echo $project->start_date->format('d/m/Y');
                        ?>
                    </strong>
                     | End at
                    <strong>
                        <?php
                            $end_date = clone $project->start_date;
                            echo $end_date->add(new DateInterval('P' . $project->duration . 'D'))->format('d/m/Y');;
                        ?>
                    </strong>
                    </span>
                </div>

                <span class="count-down"><strong>
                <?php
                    $days_left = date_diff(new DateTime(), $project->start_date, $absolute = false);
                    echo $days_left->format('%r%a days');
                ?>
                </strong>Days to go.</span>
                <a href="#" class="btn btn-launch">CLICK TO FUND</a>
            </div>

            <!--tabs-->
            <div class="section-block">
                <div class="section-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About</a></li>
                        <li role="presentation"><a href="#updates" aria-controls="updates" role="tab" data-toggle="tab">All Funds</a></li>
                    </ul>
                </div>
            </div>
            <!--/tabs-->
            <!--tab panes-->
            <div class="section-block">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="about">
                        <div class="about-information">
                            <h1 class="section-title">
                                ABOUT <?php echo $project->title; ?>
                            </h1>
                            <p>
                                <?php
                                    echo nl2br($project->description);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="updates">
                        <div class="update-information">
                            <h1 class="section-title">UPDATES</h1>
                            <!--update items-->
                            <div class="update-post">
                                <h4 class="update-title">We've started shipping!</h4>
                                <span class="update-date">Posted 2 days ago</span>
                                <p>Suspendisse luctus at massa sit amet bibendum. Cras commodo congue urna, vel dictum velit bibendum eget. Vestibulum quis risus euismod, facilisis lorem nec, dapibus leo. Quisque sodales eget dolor iaculis dapibus. Vivamus sit amet lacus ipsum. Nullam varius lobortis neque, et efficitur lacus. Quisque dictum tellus nec mi luctus imperdiet. Morbi vel aliquet velit, accumsan dapibus urna. Cras ligula orci, suscipit id eros non, rhoncus efficitur nisi.</p>
                            </div>
                            <div class="update-post">
                                <h4 class="update-title">Launch begins manufacturing </h4>
                                <span class="update-date">Posted 9 days ago</span>
                                <p>Suspendisse luctus at massa sit amet bibendum. Cras commodo congue urna, vel dictum velit bibendum eget. Vestibulum quis risus euismod, facilisis lorem nec, dapibus leo. Quisque sodales eget dolor iaculis dapibus. Vivamus sit amet lacus ipsum. Nullam varius lobortis neque, et efficitur lacus. Quisque dictum tellus nec mi luctus imperdiet. Morbi vel aliquet velit, accumsan dapibus urna. Cras ligula orci, suscipit id eros non, rhoncus efficitur nisi.</p>
                            </div>
                            <div class="update-post">
                                <h4 class="update-title">Designs have now been finalized</h4>
                                <span class="update-date">Posted 17 days ago</span>
                                <p>Suspendisse luctus at massa sit amet bibendum. Cras commodo congue urna, vel dictum velit bibendum eget. Vestibulum quis risus euismod, facilisis lorem nec, dapibus leo. Quisque sodales eget dolor iaculis dapibus. Vivamus sit amet lacus ipsum. Nullam varius lobortis neque, et efficitur lacus. Quisque dictum tellus nec mi luctus imperdiet. Morbi vel aliquet velit, accumsan dapibus urna. Cras ligula orci, suscipit id eros non, rhoncus efficitur nisi.</p>
                            </div>
                            <!--/update items-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/tabs-->
        <!--/main content-->
        <!--sidebar-->
        <div class="content col-md-4 col-sm-12 col-xs-12">
            <div class="section-block">
                <h1 class="section-title">Highlighted Funds</h1>
                <!--reward blocks-->
<!--                        --><?php
//                        $i = 1;
//                        foreach ($donations as $donation) {
//                            if ($i > 8) break;
//                            echo
//                                '<div class="reward-block last">
//                                <h3>' . $donation['amount'] . '</h3>
//                                <h2>Premium Bird</h2>
//                                <p>' . $donation['message'] . '</p>
//                                <span class="type-meta"><i class="fa fa-user"></i><b>'.$donation['name'].'</b></span>
//                                <span class="type-meta"><i class="fa fa-calendar-o"></i><b>'.$donation['created'].'</b></span>
//                            </div>';
//                            $i = $i + 1;
//                        }
//                        ?>
                <div class="reward-block last">
                    <h3>$50</h3>
                    <h2>Premium Bird</h2>
                    <p>Curabitur accumsan sem sed velit ultrices fermentum. Pellentesque rutrum mi nec ipsum elementum aliquet. Sed id vestibulum eros. Nullam nunc velit, viverra sed consequat ac, pulvinar in metus.</p>
                    <span class="type-meta"><i class="fa fa-user"></i><b>Jonathan Doe</b></span>
                    <span class="type-meta"><i class="fa fa-calendar-o"></i><b>2016-9-4</b></span>
                </div>
                <!--/reward blocks-->
            </div>
        </div>
        <!--/sidebar-->
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
</body>
</html>
