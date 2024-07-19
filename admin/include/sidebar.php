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
                            <a href="profiling.php">
                                <i class="fas fa-user"></i>Profiling &nbsp;<span class="badge badge-info" ></a>
                        </li>
                       
                        <!-- <li> -->
                            <!-- <a href="occupied.php"> -->
                                <!-- <i class="fas fa-home"></i>Occupied Block & Lot &nbsp;<span class="badge badge-success" ></a> -->
                        <!-- </li> -->

                        <li>
                            <a href="unoccupied.php">
                                <i class="fas fa-home"></i>Unoccupied Block & Lot&nbsp;&nbsp;<span class="badge badge-danger" ></a>
                        
                        </li>
                        
                        
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->
         <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
           <header class="header-desktop">
    <div class="section__content section__content--p30" >
        <div class="container-fluid">
            <div class="header-wrap">
               
                <div class="header-button" style="display: flex; justify-content: right; align-items: center; width: 100%;">
                <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <span class="quantity">3</span>
                                        <div class="notifi-dropdown js-dropdown">
                                            <div class="notifi__title">
                                                <p>You have 3 Notifications</p>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a email notification</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c2 img-cir img-40">
                                                    <i class="zmdi zmdi-account-box"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your account has been blocked</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c3 img-cir img-40">
                                                    <i class="zmdi zmdi-file-text"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a new file</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__footer">
                                                <a href="#">All notifications</a>
                                            </div>
                                         </div>
                                        </div>
                                    <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                             <div class="bg-c3 img-cir img-40">
                                             <?php
                                             $query=mysqli_query($bd, "select * from admin");
                                             $data = mysqli_fetch_assoc($query);
                                             ?> 
                                            <img src="../uploads/<?php echo $data['image'] ?>" alt="../uploads/image.jpg">
                                            </div>
                                        </div>
                                        <div class="content">
                                            <?php $query=mysqli_query($bd, "select * from admin");
                                                    $cnt=1;
                                                    while($row=mysqli_fetch_array($query))
                                                  {  
                                            ?> 
                                            <a class="js-acc-btn" href="#"><?php echo htmlentities($row['username']);?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <div class="bg-c3 img-cir img-60">
                                                    <a>
                                                        <?php
                                                        $query=mysqli_query($bd, "select * from admin");
                                                        $data = mysqli_fetch_assoc($query);
                                                        ?> 
                                                       <img src="../uploads/<?php echo $data['image'] ?>" alt="../uploads/image.jpg">
                                                    </a>
                                                 </div>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                    <?php $query=mysqli_query($bd, "select * from admin");
                                                    $cnt=1;
                                                    while($row=mysqli_fetch_array($query))
                                                      {  
                                                    ?> 
                                                        <a><?php echo htmlentities($row['fullname']);?></a>
                                                    </h5>
                                                    <span class="lastname"><?php echo htmlentities($row['email']);?></span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                 <?php $query=mysqli_query($bd, "select * from admin");
                                                    $cnt=1;
                                                    while($row=mysqli_fetch_array($query))
                                                       { 
                                                    ?>  
                                                    <a href="adminacc.php?admin_id=<?php echo $row['id']?>"><i class="fas fa-lock"></i>My Account</a>
                                                </div>
                                               
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a onclick="logout()">

                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php }}}?>
            <!-- HEADER DESKTOP-->