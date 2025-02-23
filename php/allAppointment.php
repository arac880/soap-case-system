<?php
include '../php/db-conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP General Medical Clinic - All Appointments</title>
    <link rel="stylesheet" href="../CSS/allStyles.css">
</head>
<body>
    <div class="container">
        <h2>All Appointments</h2>
        <button class="back-btn" onclick="goBack()">Go Back</button>
        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient ID</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM Appointments";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['Appointment_ID']}</td>
                                <td>{$row['Patient_ID']}</td>
                                <td>{$row['Appointment_Date']}</td>
                                <td>{$row['Appointment_Time']}</td>
                                <td>{$row['Reason']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No appointments found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function goBack() {
        if (document.referrer) {
        window.history.back();
        } else {
            window.location.href = "index.php"; 
        }
    }
    </script>
</body>
</html>
