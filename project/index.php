<!DOCTYPE html>
<head>
    <?php include 'connect.php';?>
    
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel='shortcut icon' href="icon.png" type='image/x-icon'/ > 
	<title>
    <?php
        echo $project_title;
    ?>   
    </title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Template CSS -->
	<link href="style.css" rel="stylesheet">

	<!--Fonts-->
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Paaji" rel="stylesheet">
</head>

<body>

	<!--header-->
	<header class="header" style="margin: 0 8%">
        <img src="logo.jpg" style="width: 18%; margin-left: 38px;">
    </header>
    <nav class="navbar navbar-default" style="margin: 28px 8% 0 8%">
        <!-- <img src="logo.jpg" style="width: 12%; float: left;"> -->
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Sign up</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome Username<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

	<!--main content-->
	<div class="main-content">
		<div class="container">
			<div class="row">
				<div class="content col-md-8 col-sm-12 col-xs-12">
					<div class="section-block">
						<div class="funding-meta">
                            <?php
                                echo "<h4>PROJECT #", $project_id, ":</h4>";
                                echo "<h1>", $project_title, "</h1>";
                            ?>
                            <p>subtitle: there is some more information about the project</p><hr>
							<span class="type-meta"><i class="fa fa-user"></i><b>
                                <?php
                                    echo $owner;
                                ?>
                            </b></span><br>
							<span class="type-meta"><i class="fa fa-tag"></i><b>
                                <?php
                                    foreach ($categories as $row) {
                                        if ($row['name'] == end($categories)['name'])
                                            echo '<a href="#">', $row['name'], '</a>';
                                        else
                                            echo '<a href="#">', $row['name'], '</a>, ';
                                    }
                                ?>
                            </b></span>
							<img src="logo.jpg" class="img-responsive" alt="launch HTML5 Crowdfunding">

							<h2>
                            <?php echo $donation_sum; ?>
                            </h2>							
							<span class="contribution">raised by <strong>
                            <?php
                                echo $donator_count;
                            ?>                     
                            </strong> donators</span>
							<div class="progress">
                                <?php
                                echo '
								<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width:' . $percent . '%;">
									<span class="sr-only">' . $percent . '% Complete</span>
								</div>'
                                ?>
							</div>
							<span class="goal-progress"><strong>
                            <?php echo $percent; ?>
                            %</strong> of 
                            <?php echo $project_goal, " "; ?>
                            raised</span>
                            <hr>
                            <span class="goal-progress">
                            Started at 
                            <strong><?php
                                echo $project_start_date->format('Y-m-d') . "\n";
                            ?></strong>              
                             | 
                            End at
                            <strong><?php
                                echo $project_end_date->format('Y-m-d') . "\n";
                            ?></strong>
                            </span>
						</div>

						<span class="count-down"><strong>
                        <?php
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
                                        <?php
                                            echo "ABOUT ", $project_title;
                                        ?>
                                    </h1>
                                    <p>
                                        <?php
                                            echo "<p>", nl2br($project_description), "</p>";
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
                        <?php
                        $i = 1;
                        foreach ($donations as $donation) {
                            if ($i > 8) break;
                            echo 
                            '<div class="reward-block last">
                                <h3>' . $donation['amount'] . '</h3>
                                <h2>Premium Bird</h2>
                                <p>' . $donation['message'] . '</p>
                                <span class="type-meta"><i class="fa fa-user"></i><b>'.$donation['name'].'</b></span>
                                <span class="type-meta"><i class="fa fa-calendar-o"></i><b>'.$donation['created'].'</b></span>
                            </div>';
                            $i = $i + 1;
                        }
                        ?>
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
		</div>
	</div>

	<footer class="footer">
	   <div class="container">
            <div class="row" style="text-align: center; padding-bottom: 18px">
            <span>Copyright © 2016 CS2102 Group 20. All rights reserved</span>
            <!-- <div class="row">
				<span class="copyright">Created by <a href="http://themes.audaindesigns.com" target="_blank">Audain Designs</a> for free use</span>
			</div> -->
            </div>
		</div>
	</footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
