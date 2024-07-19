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
    $id=intval($_GET['id']);

    if (isset($_POST['submit'])) {
        $block_number = $_POST['block_number'];
        $lot_number = $_POST['lot_number'];
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $gender = $_POST['gender'];
        $barangay = $_POST['barangay'];
        $remarks = $_POST['remarks'];
        $civil_status = $_POST['civil_status'];
        $spouse = $_POST['spouse'];
        $family_member = $_POST['family_member'];
        $occupation = $_POST['occupation'];
        $contact = $_POST['contact'];
        $place_of_birth = $_POST['place_of_birth'];
       

                // If the combination doesn't exist and the client doesn't exist, insert the new client
                $sql = "UPDATE `profiling` SET `block_number`='$block_number',`lot_number`='$lot_number',`lastname`='$lastname',`firstname`='$firstname',`middlename`='$middlename',`gender`='$gender',`barangay`='$barangay',`remarks`='$remarks',`civil_status`='$civil_status',`spouse`='$spouse',`family_member`='$family_member',`occupation`='$occupation',`contact`='$contact',`place_of_birth`='$place_of_birth' WHERE id='$id'";



                //   $sql3 = mysqli_query($bd, "INSERT INTO notifications (clients_id,clientname, message, agents_id, agentsname,address,description,status) VALUES ('$clients_id','$clientsname','$noti','$agents_id',' $agentsname ','$Municipality $location_address $sitio_address',' $description $email $contactNo $net_plan ','$stat')");

                //   $sql001 = mysqli_query($bd, "INSERT INTO notificationsadmin (clients_id,clientname, message, agents_id, agentsname,address,description,status) VALUES ('$clients_id','$clientsname','$noti','$agents_id',' $agentsname ','$Municipality $location_address $sitio_address',' $description $email $contactNo $net_plan ','$stat')");

                $result = mysqli_query($bd, $sql);
                if ($result) {
                // JavaScript code to show SweetAlert message
                echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Data Successfully Updated !!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "profiling.php";
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
                    <form action="" method="post" enctype="multipart/form-data">
                    <?php
             $id=intval($_GET['id']);
             $query=mysqli_query($bd, "select * from profiling where id='$id'");
             while($row=mysqli_fetch_array($query))
             {
             ?> 
        <div class="row">
         <div class="col-md-6">

         <div class="form-group">
           <label for="agents" class="control-label">Block Number</label>
           <input type="text" class="form-control" value="<?php echo $row['block_number']; ?>" name="block_number" class="span8 tip" autocomplete="off" placeholder="Block Number" readonly>
        </div>  
      </div>
      
      <div class="col-md-6">
            <div class="form-group">
                        <label for="">Lot Number</label>
                      <input type="text" class="form-control"  name="lot_number" value="<?php echo $row['lot_number']; ?>" placeholder="Lot Number" class="span8 tip" readonly>
                       
                        

         
        </div>
      </div>
    </div> 
      
        <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="" class="control-label">Last Name</label>
                 <input type="text" class="form-control" autocomplete="off" name="lastname" class="span8 tip" value="<?php echo $row['lastname']; ?>" placeholder="Last Name"required>
            </div>
          </div>

          <div class="col-md-6">
                    <div class="form-group">
                     <label for="" class="control-label">First Name</label>
                       <input type="text" class="form-control" value="<?php echo $row['firstname']; ?>" name="firstname" placeholder="Firstname" class="span8 tip" required>
                 </div>
          </div>
             </div>

          
             <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="" class="control-label">Middle Name</label>
                 <input type="text" class="form-control"  name="middlename" class="span8 tip" value="<?php echo $row['middlename']; ?>" placeholder="Middle Name" required>
            </div>
          </div>

          <div class="col-md-6">
                    <div class="form-group">
                     <label for="gender" class="control-label">Gender</label>
                     <select class="form-control" name="gender">
                         <option value="" <?php if ($row['gender'] == '') echo 'selected'; ?>>Select</option>
                       <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                       <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                       
                    </select>
                 </div>
          </div>
             </div>

             <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label for="barangay" class="control-label">Barangay</label>
                <select class="form-control" name="barangay">
                         <option value="" <?php if ($row['barangay'] == '') echo 'selected'; ?>>Select</option>
                       <option value="Bunakan" <?php if ($row['barangay'] == 'Bunakan') echo 'selected'; ?>>Bunakan</option>
                       <option value="Kangwayan" <?php if ($row['barangay'] == 'Kangwayan') echo 'selected'; ?>>Kangwayan</option>
                       <option value="Kaongkod" <?php if ($row['barangay'] == 'Kaongkod') echo 'selected'; ?>>Kaongkod</option>
                       <option value="Kodia" <?php if ($row['barangay'] == 'Kodia') echo 'selected'; ?>>Kodia</option>
                       <option value="Maalat" <?php if ($row['barangay'] == 'Maalat') echo 'selected'; ?>>Maalat</option>
                       <option value="Malbago" <?php if ($row['barangay'] == 'Malbago') echo 'selected'; ?>>Malbago</option>
                       <option value="Mancilang" <?php if ($row['barangay'] == 'Mancilang') echo 'selected'; ?>>Mancilang</option>
                       <option value="Pili" <?php if ($row['barangay'] == 'Pili') echo 'selected'; ?>>Pili</option>
                       <option value="Poblacion" <?php if ($row['barangay'] == 'Poblacion') echo 'selected'; ?>>Poblacion</option>
                       <option value="San Agustin" <?php if ($row['barangay'] == 'San Agustin') echo 'selected'; ?>>San Agustin</option>
                       <option value="Tabagak" <?php if ($row['barangay'] == 'Tabagak') echo 'selected'; ?>>Tabagak</option>
                       <option value="Talangnan" <?php if ($row['barangay'] == 'Talangnan') echo 'selected'; ?>>Talangnan</option>
                       <option value="Tarong" <?php if ($row['barangay'] == 'Tarong') echo 'selected'; ?>>Tarong</option>
                       <option value="Tugas" <?php if ($row['barangay'] == 'Tugas') echo 'selected'; ?>>Tugas</option>
                       
                    </select>
            </div>
          </div>

          <div class="col-md-6">
                    <div class="form-group">
                     <label for="" class="control-label">Place of Birth</label>
                     <input type="text" class="form-control" name="place_of_birth" value="<?php echo $row['place_of_birth']; ?>" placeholder="Place of Birth" >
                      
                 </div>
          </div>
             </div>
             <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="civil_status" class="control-label">Civil Status</label>
                        <select class="form-control" name="civil_status">
                         <option value="" <?php if ($row['civil_status'] == '') echo 'selected'; ?>>Select</option>
                       <option value="Single" <?php if ($row['civil_status'] == 'Single') echo 'selected'; ?>>Single</option>
                       <option value="Married" <?php if ($row['civil_status'] == 'Married') echo 'selected'; ?>>Married</option>
                       <option value="Separated" <?php if ($row['civil_status'] == 'Separated') echo 'selected'; ?>>Separated</option>
                       <option value="Divorced" <?php if ($row['civil_status'] == 'Divorced') echo 'selected'; ?>>Divorced</option>
                       <option value="Widowed" <?php if ($row['civil_status'] == 'Widowed') echo 'selected'; ?>>Widowed</option>
                    </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Spouse Name</label>
                            <input type="text" class="form-control" name="spouse" value="<?php echo $row['spouse']; ?>" placeholder="Spouse Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Family Member</label>
                            <input type="text" class="form-control"  name="family_member" value="<?php echo $row['family_member']; ?>" placeholder="Family Member" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Occupation</label>
                            <input type="text" class="form-control" name="occupation" value="<?php echo $row['occupation']; ?>" placeholder="Occupation">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                <label for="" class="control-label">Contact</label>
                <input type="text" class="form-control" name="contact" id="contact" value="<?php echo htmlspecialchars($row['contact']); ?>" placeholder="Contact" maxlength="11" required pattern="^09\d{9}$" title="Please enter exactly 11 digits">
                </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Remarks</label>
                            <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>" name="remarks" placeholder="Remarks" class="span8 tip" >
                        </div>
                    </div>
                </div>
            
              
         
             <button type="submit" name="submit" class="btn btn-success">Update</button>
             <button class="btn btn-secondary" type="button" onclick="location.href='profiling.php'">Cancel</button>
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
document.addEventListener("DOMContentLoaded", function() {
    const contactInput = document.getElementById('contact');

    contactInput.addEventListener('input', function (e) {
        // Remove non-digit characters
        this.value = this.value.replace(/\D/g, '');

        // Ensure the input starts with '09'
        if (this.value.length > 0 && !this.value.startsWith('09')) {
            this.value = '09' + this.value.replace(/^0+/, '').substring(0, 9); // Ensure it starts with 09 and is at most 11 digits
        }

        // Restrict the input to 11 digits
        if (this.value.length > 11) {
            this.value = this.value.substring(0, 11);
        }
    });

    contactInput.addEventListener('blur', function (e) {
        // Check if the value is a valid 11-digit Philippine mobile number
        if (!/^09\d{9}$/.test(this.value)) {
            alert('Please enter a valid 11-digit Philippine mobile number starting with 09.');
            this.value = ''; // Clear the input if invalid
        }
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
<?php }?>
</html>
<!-- end document-->
