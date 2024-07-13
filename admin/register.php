<?php
session_start();
include('include/config.php');
include("include/header.php");

if(isset($_POST['submit'])) {
    $Fullname = $_POST['Fullname'];
    $Email = $_POST['Email'];
    $Username = $_POST['Username'];
    $password = md5($_POST['password']);
    $role = "Admin";
    $default_image = "../uploads/image.jpg"; // Specify the path to the default image

    // Check if the combination already exists in the database
    $sql_check = "SELECT * FROM admin WHERE fullname = '$Fullname' AND email = '$Email' AND username = '$Username'";
    $result_check = mysqli_query($bd, $sql_check);
    if (mysqli_num_rows($result_check) > 0) {
        echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Admin user already exists.",
                        icon: "error"
                    });
                };
              </script>';
    } else {
        // Insert new admin with default image
        $sql_insert = "INSERT INTO `admin`(`fullname`, `email`, `username`, `password`, `role`, `image`) VALUES ('$Fullname', '$Email', '$Username', '$password', '$role', '$default_image')";
        $result_insert = mysqli_query($bd, $sql_insert);
        if ($result_insert) {
            echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Success!",
                        text: "Admin Account Successfully Created !!",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "index.php";
                        }
                    });
                };
              </script>';
        } else {
            echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Error creating An account.",
                        icon: "error"
                    });
                };
              </script>';
        }
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
        <center><img src="../images/CTU.png" alt="System Logo" class="img-thumbnail rounded-circle" id="logo-img"></center>
      <a class="h1"><b>Sign Up | Admin</b></a>
    </div>
    <div class="card-body">

    <form action="" method="post">
    <div class="input-group mb-3">
        <input type="text" name="Fullname" class="form-control" required placeholder="Fullname">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-users"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="email" name="Email" class="form-control" required placeholder="Email">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="text" name="Username" class="form-control" required placeholder="Username">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-users"></span>
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
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="icheck-primary">
                <a href="index.php" class="text-center">Already Have an Account?</a>
            </div>
        </div>
        <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block" style="background-color: #9900ff; border-radius: 10px;">Sign Up</button>
        </div>
    </div>
</form>

      <!-- /.social-auth-links -->

     <!--  <p class="mb-1">
        <a href="forgotpassword.php">I forgot my password</a>
      </p>
      <p class="mb-0"> -->

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