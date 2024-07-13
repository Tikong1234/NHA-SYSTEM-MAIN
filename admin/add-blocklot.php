<?php
session_start();
include('include/config.php');
include("include/header.php");
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Manila'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    $noti = "We have a new client named "; // Corrected the notification message
    $stat = "Unread";
    $description = "Details : ";
    // $main_id=intval($_GET['main_id']);

    if (isset($_POST['submit'])) {
        $block_number = $_POST['block_number'];
        $lot_number = $_POST['lot_number'];
                

        // Check if the combination of location, box number, and port number already exists
        $sql = "SELECT * FROM block_lot WHERE block_number = '$block_number' AND lot_number = '$lot_number' ";
        $result = mysqli_query($bd, $sql);
        if (mysqli_num_rows($result) > 0) {
            // If the combination exists, display an error message
               echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Block Number and Lot Number already Exist!",
                            icon: "error"
                        });
                    };
                  </script>';
        }   else {
           


                $status='Unoccupied';

                // If the combination doesn't exist and the client doesn't exist, insert the new client
                $sql = "INSERT INTO `block_lot`(`block_number`, `lot_number`, `status`) VALUES ('$block_number','$lot_number','$status')";



                //   $sql3 = mysqli_query($bd, "INSERT INTO notifications (clients_id,clientname, message, agents_id, agentsname,address,description,status) VALUES ('$clients_id','$clientsname','$noti','$agents_id',' $agentsname ','$Municipality $location_address $sitio_address',' $description $email $contactNo $net_plan ','$stat')");

                //   $sql001 = mysqli_query($bd, "INSERT INTO notificationsadmin (clients_id,clientname, message, agents_id, agentsname,address,description,status) VALUES ('$clients_id','$clientsname','$noti','$agents_id',' $agentsname ','$Municipality $location_address $sitio_address',' $description $email $contactNo $net_plan ','$stat')");

                $result = mysqli_query($bd, $sql);
                if ($result) {
                // JavaScript code to show SweetAlert message
                echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Success!",
                            text: " Block and Lot Successfully Created !!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "unoccupied.php";
                            }
                        });
                    };
                  </script>';
        } else {
            echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Error occurred while creating client.",
                            icon: "error"
                        });
                    };
                  </script>';
            echo "Error: " . $sql . "<br>" . mysqli_error($bd);
        }
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
                <h3 class="card-title">Add Block and Lot Number</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="controls" style="margin-top: 5px;">
                         
                      
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
         <div class="col-md-6">

         <div class="form-group">
           <label for="agents" class="control-label">Block Number</label>
           <input type="text" class="form-control" autocomplete="off" name="block_number" class="span8 tip" autocomplete="off" placeholder="Block Number" required>
        </div>  
      </div>
      
      <div class="col-md-6">
            <div class="form-group">
                        <label for="">Lot Number</label>
                      <input type="text" class="form-control"  name="lot_number" placeholder="Lot Number" class="span8 tip" required>
                       
                        

         
        </div>
      </div>
    </div> 
      
             
            
              
         
             <button type="submit" name="submit" class="btn btn-success">Create</button>
             <button class="btn btn-secondary" type="button" onclick="location.href='unoccupied.php'">Cancel</button>
             </div>
         </div>
         <br>
         <br> 
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
