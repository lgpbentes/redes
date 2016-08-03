<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <?php
                if(Yii::$app->user->isGuest){
                    echo "Visitante";
                }else{
                    echo Yii::$app->user->identity->username;
                }
                ?>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MEU MENU</li>

            <li>
                <a href="index.php?r=historia%2Fcreate">
                    <i class="fa fa-th"></i> <span>Cadastrar História</span>
                </a>
            </li>

            <li>
                <a href="index.php?r=moderador/index">
                    <i class="fa fa-th"></i> <span>Moderar Histórias</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-th"></i> <span>Minhas Publicações</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-th"></i> <span>Widgets</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>