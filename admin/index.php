<?php
session_start();
include("include/config.php");
include("include/header.php");

if (isset($_POST['submit'])) {
    $userIdentifier = $_POST['userIdentifier'];
    $password = md5($_POST['password']); // Consider using a more secure hashing method

    // Use prepared statements to prevent SQL injection
    $stmt = $bd->prepare("SELECT id, role FROM admin WHERE (email=? OR username=?) AND password=?");
    if ($stmt) {
        $stmt->bind_param('sss', $userIdentifier, $userIdentifier, $password); // Bind parameters
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $role);
            $stmt->fetch();

            // Check if the user is an admin
            if ($role === 'Admin') {
                // Authentication successful for admin
                $_SESSION['alogin'] = $userIdentifier;
                $_SESSION['id'] = $id;
                $_SESSION['role'] = $role;

                // Close the prepared statement before redirecting
                $stmt->close();

                echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                title: "Success!",
                                text: "You are Successfully logged in!",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "home.php";
                                }
                            });
                        };
                      </script>';
            } else {
                // Not an admin, deny access
                echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Access Denied. You are not authorized to access this portal.",
                                icon: "error"
                            });
                        };
                      </script>';
            }
        } else {
            // Authentication failed
            echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Access Denied Please Check Your Credentials",
                            icon: "error"
                        });
                    };
                  </script>';
        }
    } else {
        // Error preparing the statement
        echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Database error. Please try again later.",
                        icon: "error"
                    });
                };
              </script>';
    }
}
?>




    <style>
     
      #logo-img{
          width:5em;
          height:5em;
          object-fit:scale-down;
          object-position:center center;
      }
    
  </style>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>

  <!-- Google Font: Source Sans Pro -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/sweetalert2@10.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary" style="border-radius: 40px;">
    <div class="card-header text-center">
        <!-- <center><img src="../images/CTU.png" alt="System Logo" class="img-thumbnail rounded-circle" id="logo-img"></center> -->
      <a class="h1"><b>Admin Log In</b></a>
    </div>
    <div class="card-body">

      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="userIdentifier" class="form-control" required placeholder="Email or Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
         <div class="input-group">
                           <input type="password" class="form-control" autocomplete="off" name="password" id="password" placeholder="Password" required>
                           <div class="input-group-append">
                               <button class="btn btn-outline-secondary" type="button" id="oldPasswordToggle">
                               <i class="fas fa-eye toggle-icon"></i>
                               </button>
                           </div>
                       </div>        </div>
        <div class="row">
          <div class="col-12">
            <div class="icheck-primary">
            <button type="submit" name="submit" class="btn btn-primary btn-block" >Log In</button>
        
            </div>
          </div>
          <!-- /.col -->
          <div class="col-8">
          <a href="register.php" class="text-center">Register</a>
          </div>
          <div class="col-4">
          <a href="../index.php" class="text-center">User Login</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgotpassword.php">I forgot my password</a>
      </p>
      <p class="mb-0">

      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>

</html>
<script>
    let password = document.querySelector("input[name='password']")

    function showPass() {
        if (password.getAttribute("type") == "password") {
            password.setAttribute("type", "text")
        } else {
            password.setAttribute("type", "password")
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const newPasswordInput = document.getElementById('newpassword');
        const confirmPasswordInput = document.getElementById('confirmpassword');

        const toggleIcons = document.querySelectorAll('.toggle-icon');

        toggleIcons.forEach(function (icon) {
            icon.addEventListener('click', function () {
                const inputField = icon.closest('.input-group').querySelector('input');
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);

                // Change icon based on password visibility
                icon.classList.toggle('fa-eye-slash');
            });
        });
    });
</script>