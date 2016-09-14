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
        <title>Project - <?php echo $project->title; ?></title>
        <?php
    } else {
        ?>
        <title>Project detail - Cannot find the project in database</title>
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
                    <h4>PROJECT #<?php echo $project->id;?>: <a class="btn btn-danger" href="<?php echo url(['_page' => 'edit_project', 'project_id' => $project->id]);?>">Edit</a> </h4>
                    <h1><?php echo $project->title;?></h1>
                    <hr>
                    <div class="type-meta">
                        <i class="fa fa-user"></i>
                        Created by <b><?php echo $project->getOwner()->name; ?></b>, Email <b><?php echo $project->getOwner()->email;?></b>
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


                    <?php
                        $raised = $project->getRaisedAmount();
                        $percent = sprintf("%.2f", $raised / $project->goal) * 100;
                    ?>

                    <h2>
                        S$<?php echo $raised; ?>
                    </h2>
                    <span class="contribution">raised by <strong>
                        <?php echo $project->getNumOfDonator(); ?>
                    </strong> donators</span>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $percent;?>%;">
                            <?php echo $percent;?>%
                        </div>
                    </div>
                    <span class="goal-progress"><strong>
                            <?php echo $percent;?>%</strong> of raised</span>
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
                                <?php echo $project->title; ?>
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
                            <h1 class="section-title">All Fund</h1>
                            <?php
                            foreach ($project->getDonations() as $donation) {
                                ?>
                                <div class="update-post">
                                    <h4 class="update-title">Amount : <b>S$ <?php echo $donation->amount; ?></b> by <b><?php echo $donation->getOnwer()->name; ?></b></h4>
                                    <span class="update-date">
                                        <?php
                                            echo $donation->created->format('d/m/Y H:i:s');
                                        ?>
                                    </span>
                                    <p>
                                        <?php
                                            echo $donation->message;
                                        ?>
                                    </p>
                                </div>
                                <?php
                            }
                            ?>
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
                <?php
                foreach ($project->getHighlightDonations() as $donation) {
                    ?>
                    <div class="reward-block last">
                        <h3>S$ <?php echo $donation->amount; ?></h3>
                        <h2>#<?php echo $donation->id; ?></h2>
                        <p>
                            <?php echo $donation->message; ?>
                        </p>
                        <span class="type-meta"><i class="fa fa-user"></i><b><?php echo $donation->getOnwer()->name; ?></b></span>
                        <span class="type-meta"><i class="fa fa-calendar-o"></i>
                            <b>
                                <?php
                                    echo $donation->created->format('d/m/Y H:i:s');
                                ?>
                            </b>
                        </span>
                    </div>
                    <br>
                    <?php
                }
                ?>
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
