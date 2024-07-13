<?php
session_start();
include('include/config.php');
include("include/header.php");

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Manila'); // change according to timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    $noti = "The admin has updated his or her own profile data."; // Corrected the notification message
    $stat = "Unread";
    $assignroles = "Office Main";
    $memberstatus = "Admin: ";

    if (isset($_POST['submit'])) {
        $oldPassword = md5($_POST['password']);
        $newPassword = md5($_POST['newpassword']);
        $confirmPassword = md5($_POST['confirmpassword']);

        $sqlCheckPassword = mysqli_query($bd, "SELECT password FROM admin WHERE password='$oldPassword' AND email='".$_SESSION['alogin']."'");
        $num = mysqli_fetch_array($sqlCheckPassword);

        if (!empty($num)) {
            // Password matches, proceed with updating the password
            $sqlUpdatePassword = mysqli_query($bd, "UPDATE admin SET password='$newPassword' WHERE email='".$_SESSION['alogin']."'");
            if (!$sqlUpdatePassword) {
                echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Error updating admin password.",
                            icon: "error"
                        });
                    };
                  </script>';
            }

            // Get other form data
            $id = intval($_GET['admin_id']);
            $firstname = $_POST['fullname'];
            $lastname = $_POST['address'];
            $username = $_POST['username']; // Corrected the name to match the form field
            $email = $_POST['email'];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Specify upload directory
                $uploadDir = 'uploads/';

                // Fetch old photo path from the database
                $sqlFetchOldPhoto = "SELECT image FROM admin WHERE email = '{$_SESSION['alogin']}'";
                $resultFetchOldPhoto = mysqli_query($bd, $sqlFetchOldPhoto);
                $rowFetchOldPhoto = mysqli_fetch_assoc($resultFetchOldPhoto);
                $oldPhotoPath = $rowFetchOldPhoto['image'];

                // Delete old photo file from the server
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }

                // Upload new photo
                $fileName = $_FILES['image']['name'];
                $fileTmpName = $_FILES['image']['tmp_name'];
                $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array($fileType, $allowedTypes)) {
                    echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Only JPG, JPEG, PNG, and GIF files are allowed.",
                                icon: "error"
                            });
                        };
                      </script>';
                    exit;
                }

                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($fileTmpName, $filePath)) {
                    // Construct the SQL query for profile data update
                    $sqlUpdateProfile = "UPDATE admin SET fullname = '{$fullname}', address = '{$address}', email = '{$email}', username = '{$username}', image = '{$filePath}' WHERE admin_id = {$id}";

                    // Execute the SQL query for profile data update
                    $result = mysqli_query($bd, $sqlUpdateProfile);
                } else {
                    echo '<script>
                        window.onload = function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Error uploading image.",
                                icon: "error"
                            });
                        };
                      </script>';
                }
            } else {
                // If no file is uploaded, update the database with existing photo path
                $sqlUpdateProfile = "UPDATE admin SET fullname = '{$fullname}', address = '{$address}', email = '{$email}', username = '{$username}' WHERE admin_id = {$id}";
                $result = mysqli_query($bd, $sqlUpdateProfile);
            }

            if ($result) {
                // $sql3 = mysqli_query($bd, "INSERT INTO notificationsadmin (clients_id, message, address, description, status) VALUES ('$username', '$noti', '$assignroles','$memberstatus $firstname $lastname $username', '$stat')");
                echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Profile data successfully updated!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "home.php";
                            }
                        });
                    };
                  </script>';
            } else {
                echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Error updating admin profile data.",
                            icon: "error"
                        });
                    };
                  </script>';
            }
        } else {
            echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Old Password does not match!",
                        icon: "error"
                    });
                };
              </script>';
        }
    }
}
?>
  <style type="text/css">

      .unread {
     background-color: antiquewhite; /* Example background color for unread notifications */
    /* Add any other styles you want for unread notifications */
     }
      

      .img-very-small {
    width: 30px; /* Set a smaller width */
    height: 30px; /* Set a smaller height */
  }
   </style>
    <script>
    function markAsRead(notificationId, Id) {
        // Send AJAX request to mark notification as read
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Redirect to message_notiform.php with notificationId and agentsId
                    window.location.href = 'edit-appoint.php?id=' + notificationId ;
                } else {
                    console.error('Error marking notification as read');
                }
            }
        };
        xhr.send('notification_id=' + notificationId);
    }
</script>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.php'; ?>

<body class="animsition">
    <div class="page-wrapper">
        <?php include 'include/mobile.php'; ?>
        <?php include 'include/sidebar.php'; ?>

     

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                               <div class="card"style="width: 104%;">
              <div class="card-header">
                <h3 class="card-title">Profiling</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="controls" style="margin-top: 5px;">
                         
                      
                    </div>
                    <form class="form" id="form" action="" enctype="multipart/form-data" method="post">
    <?php
    $id = intval($_GET['admin_id']);
    $query = mysqli_query($bd, "SELECT * FROM admin WHERE id='$id'");
    $row = mysqli_fetch_array($query);
    ?>  
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="control-label">Fullname</label>
                <div class="controls">
                    <input class="form-control" type="text" placeholder="Fullname" name="fullname" required value="<?php echo $row['fullname']; ?>">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="control-label">Address</label>
                <div class="controls">
                    <input class="form-control" type="text" placeholder="Address" name="address" required value="<?php echo $row['address']; ?>">
                </div>
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="control-label">Username</label>
                <input class="form-control" type="text" placeholder="Username" name="username" required value="<?php echo $row['username']; ?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="" class="control-label">Email</label>
                <input class="form-control" type="email" placeholder="Email" name="email" required value="<?php echo $row['email']; ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="password" class="control-label">Old Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your old password" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="oldPasswordToggle">
                            <i class="fas fa-eye toggle-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="newpassword" class="control-label">New Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Enter your new password" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="showPasswordToggle">
                            <i class="fas fa-eye toggle-icon"></i>
                        </button>
                    </div>
                </div>
                <small id="passwordHelpBlock" class="form-text text-muted"></small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="confirmpassword" class="control-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter your new password" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="showPasswordToggle">
                            <i class="fas fa-eye toggle-icon"></i>
                        </button>
                    </div>
                </div>
                <small><i>Take note: Please memorize your password all the time.</i></small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <?php
                $id = intval($_GET['admin_id']);
                $query = mysqli_query($bd, "SELECT * FROM admin WHERE id='$id'");
                $data = mysqli_fetch_assoc($query);
                ?> 
                <label for="" class="control-label">Profile Photo</label>
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                <div>
                    <img style="margin-top: 10px;" src="<?php echo $data['image']; ?>" width="150px" height="150px" alt="Profile Photo" class="img-thumbnail rounded-circle">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group"> 
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <button class="btn btn-secondary" type="button" onclick="location.href='home.php'">Cancel</button>
            </div>
        </div>
    </div>
</form>
              </div>
              <!-- /.card-body -->
            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2024  NHA KODIA SYSTEM. All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>
    <script>
    document.getElementById('newpassword').addEventListener('input', function() {
        var newpassword = this.value;
        var uppercaseRegex = /[A-Z]/;
        var numberRegex = /[0-9]/;
        var atSymbolRegex = /[@]/;

        var isValid = uppercaseRegex.test(newpassword) && numberRegex.test(newpassword) && atSymbolRegex.test(newpassword);

        if (!isValid) {
            this.setCustomValidity("Password must contain at least one uppercase letter, 8 numbers or letters, and the '@' symbol.");
        } else {
            this.setCustomValidity('');
        }
    });
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
   <script>
    function logout() {
        Swal.fire({
            title: "Logout",
            text: "Are you sure you want to logout?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, logout",
            cancelButtonText: "Cancel"
       }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'logout.php'; // Redirect to delete script
            // After the deletion is successful, show a success message
            Swal.fire({
                title: 'Logout!',
                text: 'You have successfully logged out !!',
                icon: 'success'
            });
        } else {
            // Handle cancel action here, for example, show a message
            Swal.fire({
                title: 'Cancelled',
                text: 'Logged out cancel',
                icon: 'info'
            });
        }
    });
}
</script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="js/sweetalert2@10.js"></script>
<script>
// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get all elements with the class "delete_data"
    const deleteLinks = document.querySelectorAll('.delete_data');

    // Iterate through each delete link
    deleteLinks.forEach(function(link) {
        // Add a click event listener to each delete link
        link.addEventListener('click', function(event) {
            // Prevent the default action of the link (i.e., navigating to the href)
            event.preventDefault();

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure you want to delete?',
                text: 'Please make sure you have a backup!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // Check if the user confirmed deletion
                if (result.isConfirmed) {
                    // Navigate to the href specified in the link
                    window.location.href = link.getAttribute('href');
                } else {
                    // Handle cancel action here, for example, show a message
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Your data is safe.',
                        icon: 'info'
                    });
                }
            });
        });
    });
});
<?php include 'include/footer.php' ?>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": [ "csv", "excel", "pdf", "print"]

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
  $(document).ready(function(){
    $('#list').dataTable()
  
 
  })
 
</script>

</html>
<!-- end document-->
