<!--header begin-->
<br>

<div class="row">
    <div class="col-md-3">
        <img class="img-responsive" alt="logo" src="image/logo.png">
    </div>
</div>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Crowdfunding</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?php echo (isset($_GET['_page'])) ? (($_GET['_page'] == "home") ? 'active' : '') : 'active';?>"><a href="<?php echo url(['_page' => 'home']); ?>">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>

            <form class="has-success navbar-form navbar-left" method="get" action="">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="search" name="search_key">
                    <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
            </form>
            
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if (!User::getCurrentUser()) {
                        ?>
                        <li><a href="<?php echo url(['_page' => 'login']);?>">Log in</a></li>
                        <?php
                    }
                ?>
                <?php
                if (User::getCurrentUser()) {
                    ?>
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <?php echo User::getCurrentUser()->getName(); ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./?_page=reset">Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="./?_page=logout">Log out</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
            if (User::getCurrentUser()) {
                ?>
                <form class="navbar-form navbar-right">
                    <button type="button" class="btn btn-primary" onclick="window.location.replace('<?php echo url(['_page' => 'create_project']);?>')">Create Project</button>
                </form>
                <?php
            }
            ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!--header end-->