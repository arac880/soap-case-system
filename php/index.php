<?php
include '../php/db-conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP General Medical Clinic - Dashboard</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Dashboard</h2>
            <button class="menu-btn">All Patient Records</button>
            <button class="menu-btn">All SOAP Cases</button>
            <button class="menu-btn">All Appointments</button>
            <button class="menu-btn logout-btn" onclick="showConfirmDialog();">Log out</button>
        </div>

        <div class="main-content">
            <h1>Welcome to the Dashboard</h1>
            <p>Here you can manage all your tasks and patient records.</p>
            <div class="addBtnContainer">
                <a href="addpatient.php"><button class="menu-btn">Add New Patient</button></a>
                <a href="addsoapcase.php"><button class="menu-btn">Add New SOAP Case</button></a>
                <a href="addappointment.php"><button class="menu-btn">Add New Appointment</button></a>
            </div>       
        </div>
    </div>

    <div class="confirm-overlay" id="confirm-overlay"></div>
    <div class="confirm-dialog" id="confirm-dialog">
        <p>Are you sure you want to log out?</p>
        <div class="confirm-buttons">
            <button onclick="confirmLogout()">Yes</button>
            <button onclick="hideConfirmDialog()">No</button>
        </div>
    </div>

    <script>
        function showConfirmDialog() {
            document.getElementById('confirm-overlay').style.display = 'block';
            document.getElementById('confirm-dialog').style.display = 'flex';
        }

        function hideConfirmDialog() {
            document.getElementById('confirm-overlay').style.display = 'none';
            document.getElementById('confirm-dialog').style.display = 'none';
        }

        function confirmLogout() {
            hideConfirmDialog();
            window.location.href = 'login.php'; 
        }
    </script>
</body>
</html>