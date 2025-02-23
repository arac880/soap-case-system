<?php
include '../php/db-conn.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Dashboard</h2>
            <button class="menu-btn">All Patient Records</button>
            <button class="menu-btn">All SOAP Cases</button>
            
            <button class="menu-btn">Appointments</button>
            <button class="menu-btn logout-btn">Log out</button>
        </div>

        <div class="main-content">
            <h1>Welcome to the Dashboard</h1>
            <p>Here you can manage all your tasks and patient records.</p>

            <button class="menu-btn">Add New Patient</button>
            <button class="menu-btn">Add New SOAP Case</button>
        </div>
    </div>

</body>
</html>