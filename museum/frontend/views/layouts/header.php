<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header"><?php
                if(Yii::$app->user->isGuest){
                    echo "<a href='http://localhost/redes/museum/frontend/Landing_Page/?#' class='navbar-brand'><b>Fim de papo</b></a>";
                }else{
                    echo "<a href='http://localhost/redes/museum/frontend/web/index.php' class='navbar-brand'><b>Fim de papo</b></a>";
                }
                ?>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <?php
            if(Yii::$app->user->isGuest){

            }else{
              echo"<!-- Collect the nav links, forms, and other content for toggling -->";
                echo"<div class='collapse navbar-collapse pull-left' id='navbar-collapse'>";
                echo"<ul class='nav navbar-nav'>";
                    echo"<li class='dropdown'>";
                        echo"<a href='#' class='dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>Funcionalidades<span class='caret'></span></a>";
                        echo"<ul class='dropdown-menu' role='menu'>";
                            echo"<li>";
                                echo"<a href='index.php?r=historia%2Fcreate'>Cadastrar História</a>";
                            echo"</li>";
                            echo"<li class='divider'></li>";
                            echo"<li>";
                                echo"<a href='index.php?r=moderador/index'>Moderar Histórias</a>";
                            echo"</li>";
                        echo"</ul>";
                    echo"</li>";
                echo"</ul>";

            echo "</div><!-- /.navbar-collapse -->";
            }
            ?>
            <?php
            if(Yii::$app->user->isGuest){

            }else{ ?>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                        <li><!-- start notification -->
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
            </a>
                                        </li><!-- end notification -->
                                    </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="img/ufam.png" class="user-image" alt="UFAM">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">
                                <?php
                                if(Yii::$app->user->isGuest){
                                    echo "Visitante ";
                                }else{
                                    echo Yii::$app->user->identity->username;
                                }
                                ?>
            </span>
            </a>
            <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                    <img src="img/ufam.png" class="img-circle" alt="UFAM">
                    <p>
                        <?php
                        if(Yii::$app->user->isGuest){
                            echo "Visitante ";
                        }else{
                            echo Yii::$app->user->identity->username;
                        }
                        ?>
                        <small>
                            <?php
                            if(Yii::$app->user->isGuest){
                                echo "Visitante ";
                            }else{
                                echo Yii::$app->user->identity->email;
                            }
                            ?>
                        </small>
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                    </div>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <form action="/redes/museum/frontend/web/index.php?r=site%2Flogout" method="POST">
                            <input type="hidden" name="_csrf-frontend">
                            <button  href="/redes/museum/frontend/Landing_Page/?#" type="submit" class="btn btn-link">Sair</button>
                            <a href="/redes/museum/frontend/Landing_Page/?#" class="btn btn-default btn-flat">Sign out</a>
                        </form>

                    </div>
                </li>
            </ul>
            </li>
            </ul>
        </div><!-- /.navbar-custom-menu -->
            <?php }
            ?>

        </div><!-- /.container-fluid -->
    </nav>
</header>