<?php

use common\models\User;
?>

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

            }else{ ?>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <?php $caminhoImagem = User::findOne(Yii::$app->user->getId())->perfil;
                            ?>
                            <img src='<?= $caminhoImagem ?>' class="user-image" alt="UFAM">
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