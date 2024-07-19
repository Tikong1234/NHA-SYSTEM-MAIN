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

    if (isset($_POST['submit'])) {
        $block_number = $_POST['block_number'];
        $lot_number = $_POST['lot_number'];
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $gender = $_POST['gender'];
        $barangay = $_POST['barangay'];
        $remarks = $_POST['remarks'];
        $status = 'Occupied';

        // Check if the client with the same name already exists
        $sql = "SELECT * FROM profiling WHERE lastname = ? AND firstname = ? AND middlename = ?";
        $stmt = $bd->prepare($sql);
        $stmt->bind_param('sss', $lastname, $firstname, $middlename);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo '<script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "The credentials you entered already exist with a different block number and lot number",
                        icon: "error"
                    });
                };
              </script>';
        } else {
            // Insert the new client into profiling
            $sql1 = "INSERT INTO profiling (block_number, lot_number, lastname, firstname, middlename, gender, barangay, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt1 = $bd->prepare($sql1);
            $stmt1->bind_param('ssssssss', $block_number, $lot_number, $lastname, $firstname, $middlename, $gender, $barangay, $remarks);

            // Update the status of the block and lot in block_lot
            $sql2 = "UPDATE block_lot SET status = ? WHERE block_number = ? AND lot_number = ?";
            $stmt2 = $bd->prepare($sql2);
            $stmt2->bind_param('sss', $status, $block_number, $lot_number);

            if ($stmt1->execute() && $stmt2->execute()) {
                echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Success!",
                            text: "Data Successfully Created!!",
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
                echo "Error: " . $stmt1->error . "<br>" . $stmt2->error;
            }

            $stmt1->close();
            $stmt2->close();
        }
        $stmt->close();
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

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                <input class="au-input au-input--xl" type="text" name="search" placeholder="Search" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <div class="header-button">
                               
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

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
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="block_number" class="control-label">Block Number</label>
                <select class="custom-select" name="block_number" id="block_number" class="span8 tip" required>
                    <option value="">Not Assign</option>
                    <?php 
                    $query1 = mysqli_query($bd, "SELECT DISTINCT block_number FROM block_lot");
                    while($row3 = mysqli_fetch_array($query1)) {
                        echo '<option value="' . $row3['block_number'] . '">' . $row3['block_number'] . '</option>';
                    } 
                    ?>   
                </select>
            </div>  
        </div>
      
        <div class="col-md-6">
            <div class="form-group">
                <label for="lot_number">Lot Number</label>
                <select class="custom-select" name="lot_number" id="lot_number" class="span8 tip" required>
                    <option value="">Not Assign</option>
                    <?php 
                    $status = 'Unoccupied';
                    $query2 = mysqli_query($bd, "SELECT lot_number FROM block_lot WHERE status='$status'");
                    while($row4 = mysqli_fetch_array($query2)) {
                        echo '<option value="' . $row4['lot_number'] . '">' . $row4['lot_number'] . '</option>';
                    } 
                    ?>   
                </select>
            </div>
        </div>
    </div> 
      
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="lastname" class="control-label">Last Name</label>
                <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="firstname" class="control-label">First Name</label>
                <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="middlename" class="control-label">Middle Name</label>
                <input type="text" class="form-control" name="middlename" placeholder="Middle Name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="gender" class="control-label">Gender</label>
                <select class="form-control" name="gender" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="barangay" class="control-label">Barangay</label>
                <select class="form-control" name="barangay" required>
                    <option value="">Select Barangay</option>
                    <option value="Bunakan">Bunakan</option>
                    <option value="Kangwayan">Kangwayan</option>
                    <option value="Kaongkod">Kaongkod</option>
                    <option value="Kodia">Kodia</option>
                    <option value="Maalat">Maalat</option>
                    <option value="Malbago">Malbago</option>
                    <option value="Mancilang">Mancilang</option>
                    <option value="Pili">Pili</option>
                    <option value="Poblacion">Poblacion</option>
                    <option value="San Agustin">San Agustin</option>
                    <option value="Tabagak">Tabagak</option>
                    <option value="Talangnan">Talangnan</option>
                    <option value="Tarong">Tarong</option>
                    <option value="Tugas">Tugas</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="remarks" class="control-label">Remarks</label>
                <input type="text" class="form-control" name="remarks" placeholder="Remarks" required>
            </div>
        </div>
    </div>

    <button type="submit" name="submit" class="btn btn-success">Create</button>
    <button class="btn btn-secondary" type="button" onclick="location.href='profiling.php'">Cancel</button>
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
document.getElementById('block_number').addEventListener('change', function() {
    var blockNumber = this.value;
    var lotNumberSelect = document.getElementById('lot_number');
    lotNumberSelect.innerHTML = '<option value="">Not Assign</option>'; // Clear previous options

    if (blockNumber) {
        // Fetch the lot numbers for the selected block number
        fetch('get_lot_numbers.php?block_number=' + blockNumber)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                data.forEach(function(lot) {
                    var option = document.createElement('option');
                    option.value = lot.lot_number;
                    option.textContent = lot.lot_number;
                    lotNumberSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }
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
