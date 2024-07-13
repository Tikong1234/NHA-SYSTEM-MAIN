<?php
session_start();
include('include/config.php');
include("include/header.php");

if (strlen($_SESSION['alogin']) == 0) { 
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Manila');
    $currentTime = date('d-m-Y h:i:s A', time());
  

    if (isset($_GET['del'])) {
         $query = mysqli_query($bd, "SELECT * FROM profiling");
    if ($query) {
        $row = mysqli_fetch_array($query);  
        if ($row) {
         
           
    
         

                mysqli_query($bd, "DELETE FROM profiling WHERE id = '".$_GET['id']."'");
               
                  echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Success!",
                            text: "User Data Successfully deleted !!",
                            icon: "success"
                        });
                    };
                  </script>';
            } else {
                // Handle case when no row is fetched
                $_SESSION['erroMsg'] = "Error: No data found for deletion.";
            }
        } else {
            // Handle case when query execution fails
            $_SESSION['erroMsg'] = "Error: Failed to execute query.";
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
       <?php include 'include/mobile.php';?>

        <!-- MENU SIDEBAR-->
       <?php include 'include/sidebar.php'; ?>
        <!-- END MENU SIDEBAR-->

            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                               <div class="card"style="width: 104%;">
              <div class="card-header">
                <h3 class="card-title">Unoccupied Blocks And Lot</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="controls" style="margin-top: 5px;">
                 <button class="btn-sm btn-success" type="button" onclick="location.href='add-blocklot.php'"><i class="fa fa-plus"></i> New </button> 
                      
                    </div>

                    <br>

                <table id="example2"  class="table table-bordered table-striped">

                   <thead>
                 <tr>
               <th>#</th>
                <th>BLOCK NUMBER</th>
                <th>LOT NUMBER</th>
                <th>Action</th>     
               </tr> 
                  </thead>
                  <tbody>
               <?php 
               $cnt=1;
               $status ='Unoccupied';
                   $query=mysqli_query($bd,"select * from block_lot WHERE status='$status' ORDER BY block_number");
                   while($row=mysqli_fetch_array($query))
              {
                ?>  
                  <tr>
                     <td><?php echo htmlentities($cnt);?></td>
                    <td><?php echo htmlentities($row['block_number']);?></td>
                    <td><?php echo htmlentities($row['lot_number']);?></td>
                   
          
                 <td class="text-center">
         <!--  <a class="btn-sm btn-primary" style="margin : 5px" href="list-internetplan.php?id=<?php echo $row['id']?>&del=delete"><i class="fa fa-trash"></i> Edit</a> -->
        
         <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action</button>
                                  <div class="dropdown-menu" role="menu">
                                    <div class="dropdown-divider"></div>
                                     <a class="dropdown-item edit_data" href="edit-profiling.php?id=<?php echo $row['id']?>" ><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                   <a class="dropdown-item delete_data" href="profiling.php?id=<?php echo $row['id']?>&del=delete"><span class="fa fa-trash text-danger"></span> Delete</a>
                                  </div>
 
        </td>
          </tr>
          <?php $cnt=$cnt+1; } ?>
                  </tbody>
                 
              

                
                  
                </table>
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
        <?php include 'include/footer.php' ?>
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
</script>
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
