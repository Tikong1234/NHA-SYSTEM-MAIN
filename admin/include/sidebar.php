<!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
              <div class="logo">
                 <div class="bg-c3 img-cir img-40">
                    <img src="../images/CTU.png" alt="images/CTU.png">
                 </div>
               <strong style="font-size: small;">&nbsp; NHA KODIA SYSTEM </strong>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
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
                                <i class="fas fa-user"></i>Profiling &nbsp;<span class="badge badge-info" id="count1"><?php echo htmlentities($num1); ?></a>
                        </li>

                        <li>
                             <?php include 'include/config.php';
                             $status="Approved";                   
                             $rt = mysqli_query($bd, "SELECT * FROM profiling");
                             $num1 = mysqli_num_rows($rt);
                            ?>
                            <a href="consul.php">
                                <i class="fas fa-home"></i>Occupied House &nbsp;<span class="badge badge-success" id="count2"><?php echo htmlentities($num1); ?></a>
                        </li>

                        <li>
                             <?php include 'include/config.php';
                             $status="Pending";                   
                             $rt = mysqli_query($bd, "SELECT * FROM profiling");
                             $num1 = mysqli_num_rows($rt);
                            ?>
                            <a href="appoint.php">
                                <i class="fas fa-home"></i>Unoccupied House &nbsp;&nbsp;<span class="badge badge-danger" id="count3"><?php echo htmlentities($num1); ?></a>
                        </li>
                         <li>
                             <?php include 'include/config.php';
                                $rt = mysqli_query($bd, "SELECT * FROM admin");
                                $num1 = mysqli_num_rows($rt);
                                ?>
                            <a href="useracc.php">
                                <i class="zmdi zmdi-account"></i>User Account&nbsp;<span class="badge badge-info" id="count4"><?php echo htmlentities($num1); ?></a>
                        </li>
                          <li>
                                <a href="index.php">

                                <i class="zmdi zmdi-power"></i>Logout</a>
                        </li>
                        
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->