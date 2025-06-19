<?php
session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="../css/fullcalendar.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
    <link href="../font-awesome/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/jquery.gritter.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!-- Header -->
<div id="header">
    <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>

<!-- Top Header Menu -->
<?php include 'includes/topheader.php'; ?>

<!-- Sidebar Menu -->
<?php $page = 'members-entry'; include 'includes/sidebar.php'; ?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="index.html" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="tip-bottom">Manage Members</a>
            <a href="#" class="current">Add Members</a>
        </div>
        <h1>Member Entry Form</h1>
    </div>
    
    <form role="form" action="index.php" method="POST">
        <?php 
        if (isset($_POST['fullname'])) {
            // Vérification et assainissement des entrées
            $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $dor = mysqli_real_escape_string($conn, $_POST["dor"]);
            $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
            $services = mysqli_real_escape_string($conn, $_POST["services"]);
            $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
            $plan = mysqli_real_escape_string($conn, $_POST["plan"]);
            $address = mysqli_real_escape_string($conn, $_POST["address"]);
            $contact = mysqli_real_escape_string($conn, $_POST["contact"]);

            // Cryptage du mot de passe
            $password = md5($password);

            //$totalamount = $amount * $plan;
            $p_year = date('Y');
            $paid_date = date("Y-m-d");

            include 'dbcon.php';

            // Requête d'insertion dans la base de données
            $qry = "INSERT INTO members (fullname, username, password, dor, gender, services, amount, p_year, paid_date, plan, address, contact) 
                    VALUES ('$fullname', '$username', '$password', '$dor', '$gender', '$services', '$totalamount', '$p_year', '$paid_date', '$plan', '$address', '$contact')";

            $result = mysqli_query($conn, $qry);

            if (!$result) {
                echo "<div class='container-fluid'>
                        <div class='row-fluid'>
                            <div class='span12'>
                                <div class='widget-box'>
                                    <div class='widget-title'> 
                                        <span class='icon'> 
                                            <i class='fas fa-info'></i> 
                                        </span>
                                        <h5>Error Message</h5>
                                    </div>
                                    <div class='widget-content'>
                                        <div class='error_ex'>
                                            <h1 style='color:maroon;'>Error 404</h1>
                                            <h3>Error occurred while entering your details</h3>
                                            <p>Please Try Again</p>
                                            <a class='btn btn-warning btn-big' href='edit-member.php'>Go Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>";
            } else {
                echo "<div class='container-fluid'>
                        <div class='row-fluid'>
                            <div class='span12'>
                                <div class='widget-box'>
                                    <div class='widget-title'> 
                                        <span class='icon'> 
                                            <i class='fas fa-info'></i> 
                                        </span>
                                        <h5>Success Message</h5>
                                    </div>
                                    <div class='widget-content'>
                                        <div class='error_ex'>
                                            <h1>Success</h1>
                                            <h3>Member details have been added!</h3>
                                            <p>The requested details are added. Please click the button to go back.</p>
                                            <a class='btn btn-inverse btn-big' href='members.php'>Go Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>";
            }
        } else {
            echo "<h3>You are not authorized to view this page. Go back to <a href='index.php'>DASHBOARD</a></h3>";
        }
        ?>
    </form>
</div>

<!-- Footer -->
<div class="row-fluid">
    <div id="footer" class="span12"> 
        <?php echo date("Y"); ?> &copy; Developed By Sébastien Daqiq
    </div>
</div>

<style>
    #footer {
        color: white;
    }
</style>

<!-- JavaScript -->
<script src="../js/excanvas.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.ui.custom.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.flot.min.js"></script>
<script src="../js/jquery.flot.resize.min.js"></script>
<script src="../js/jquery.peity.min.js"></script>
<script src="../js/fullcalendar.min.js"></script>
<script src="../js/matrix.js"></script>
<script src="../js/matrix.dashboard.js"></script>
<script src="../js/jquery.gritter.min.js"></script>
<script src="../js/matrix.interface.js"></script>
<script src="../js/matrix.chat.js"></script>
<script src="../js/jquery.validate.js"></script>
<script src="../js/matrix.form_validation.js"></script>
<script src="../js/jquery.wizard.js"></script>
<script src="../js/jquery.uniform.js"></script>
<script src="../js/select2.min.js"></script>
<script src="../js/matrix.popover.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/matrix.tables.js"></script>

<script type="text/javascript">
    // Function to change page URL
    function goPage (newURL) {
        if (newURL != "") {
            if (newURL == "-") {
                resetMenu();
            } else {
                document.location.href = newURL;
            }
        }
    }

    // Function to reset menu selection
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
</script>

</body>
</html>
