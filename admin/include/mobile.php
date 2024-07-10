 <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                       <a class="logo" href="home.php">
                          <img src="../images/CTU.png" class="bg-c3 img-cir img-very-small" alt="images/CTU.png">
                          <strong>NHA KODIA SYSTEM<a/></strong>
                          
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="active has-sub">
                            <a class="js-arrow" href="home.php">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                             <?php include 'include/config.php';
                                $rt = mysqli_query($bd, "SELECT * FROM profiling");
                                $num1 = mysqli_num_rows($rt);
                                ?>
                            <a href="profiling.php">
                                <i class="fas fa-user"></i>Profiling &nbsp;<span class="badge badge-info"><?php echo htmlentities($num1); ?></a>
                        </li>

                        <li>
                             <?php include 'include/config.php';
                             $status="Approved";                   
                             $rt = mysqli_query($bd, "SELECT * FROM profiling");
                             $num1 = mysqli_num_rows($rt);
                            ?>
                            <a href="consul.php">
                                <i class="fas fa-home"></i>Occupied House &nbsp;<span class="badge badge-success"><?php echo htmlentities($num1); ?></a>
                        </li>

                        <li>
                             <?php include 'include/config.php';
                             $status="Pending";                   
                             $rt = mysqli_query($bd, "SELECT * FROM profiling");
                             $num1 = mysqli_num_rows($rt);
                            ?>
                            <a href="appoint.php">
                                <i class="fas fa-home"></i>Unoccupied House &nbsp;&nbsp;<span class="badge badge-danger"><?php echo htmlentities($num1); ?></a>
                        </li>
                         <li>
                             <?php include 'include/config.php';
                                $rt = mysqli_query($bd, "SELECT * FROM admin");
                                $num1 = mysqli_num_rows($rt);
                                ?>
                            <a href="useracc.php">
                                <i class="zmdi zmdi-account"></i>User Account&nbsp;<span class="badge badge-info"><?php echo htmlentities($num1); ?></a>
                        </li>
                          <li>
                                <a href="index.php">

                                <i class="zmdi zmdi-power"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->