<?php
include '../php/db-conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP General Medical Clinic - All Patients</title>
    <link rel="stylesheet" href="../CSS/allStyles.css">
</head>
<body>
    <div class="container">
        <h2>All Patients</h2>
        <button class="back-btn" onclick="goBack()">Go Back</button>
        <table>
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Patient Number</th>
                    <th>Full Name</th>
                    <th>Date of Birth</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM Patients";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['Patient_ID']}</td>
                                <td>{$row['Patient_Number']}</td>
                                <td>{$row['First_Name']} {$row['Last_Name']}</td>
                                <td>{$row['Date_of_Birth']}</td>
                                <td>{$row['Contact_Number']}</td>
                                <td>{$row['Email']}</td>
                                <td>{$row['Gender']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No patients found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function goBack() {
        window.history.back();
    }
    </script>
</body>
</html>
