<!DOCTYPE html>
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="col-md-8">
        <h4>Current</h4>
        <?php
            $projects = Project::getAll();
            if (count($projects)) {
                foreach ($projects as $project) {
                    ?>
                    <!--project begin-->
                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php $project->title ?></h3>
                    </div>
                    <div class="panel-body">
                        <!--summary-->
                        <p><?php $project->description ?></p>

                        <!--image display-->
                        <div class="row">
                            <div class="col-xs-6 col-md-3">
                                <a href="#" class="thumbnail">
                                    <img src="https://s18.postimg.org/irz1j03nt/Screen_Shot_2016_08_04_at_12_19_28_AM.png"
                                         alt="test1" style="height: 100px; width: 100%; display: block;">
                                </a>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <a href="#" class="thumbnail">
                                    <img src="https://s18.postimg.org/vxj52umx5/Screen_Shot_2016_07_27_at_3_35_55_PM.png"
                                         alt="test2" style="height: 100px; width: 100%; display: block;">
                                </a>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <a href="#" class="thumbnail">
                                    <img src="https://s18.postimg.org/n3s8lqzyh/Screen_Shot_2016_07_25_at_11_52_58_PM.png"
                                         alt="test3" style="height: 100px; width: 100%; display: block;">
                                </a>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <a href="#" class="thumbnail">
                                    <img src="https://s18.postimg.org/jlg8pcz2h/Screen_Shot_2016_07_25_at_4_04_34_PM.png"
                                         alt="test4" style="height: 100px; width: 100%; display: block;">
                                </a>
                            </div>
                        </div>

                        <!--tag display-->
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <span class="label label-default">War</span>
                                <span class="label label-default">Education</span>
                                <span class="label label-default">Family</span>
                            </div>
                        </div>
                        <br>

                        <!--fund summary-->
                        <!--<div class="alert alert-success" role="alert">...</div>-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info" role="alert">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-3 text-center">
                                            <strong><?php $project->goal ?></strong>
                                            <div>total goal</div>
                                        </div>
                                        <div class="col-xs-6 col-md-3 text-center">
                                            <strong>$2000</strong>
                                            <div>remaining</div>
                                        </div>
                                        <div class="col-xs-6 col-md-3 text-center">
                                            <strong>24564</strong>
                                            <div>donors</div>
                                        </div>
                                        <div class="col-xs-6 col-md-3 text-center">
                                            <strong><?php $project->duration ?></strong>
                                            <div>day active</div>
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
                                <a class="btn btn-default btn-block" href="#" role="button">More..</a>
                            </div>
                        </div>
                    </div>
                </div>
                    <!--project end-->
                    <?
                }
            } else {
                ?>
                    <div class="alert alert-warning" role="alert">
                        Current not project. <a href="#"><strong>Be the first one</strong></a>  to post project for crowdfunding?
                    </div>
                <?
            }
        ?>

    </div>
    <div class="col-md-4">
        <!--tag list-->
        <h4>Category</h4>
        <div class="list-group">
            <a href="#" class="list-group-item active">
                War
            </a>
            <a href="#" class="list-group-item">Family</a>
            <a href="#" class="list-group-item">Boy</a>
            <a href="#" class="list-group-item">Girl</a>
            <a href="#" class="list-group-item">Love</a>
        </div>
    </div>
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
