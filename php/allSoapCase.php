<?php
include '../php/db-conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP General Medical Clinic - All SOAP Cases</title>
    <link rel="stylesheet" href="../CSS/allStyles.css">
</head>
<body>
    <div class="container">
        <h2>All SOAP Cases</h2>
        <button class="back-btn" onclick="goBack()">Go Back</button>
        <table>
            <thead>
                <tr>
                    <th>Case Number</th>
                    <th>Patient Number</th>
                    <th>Diagnosis</th>
                    <th>Symptoms</th>
                    <th>Treatment Plan</th>
                    <th>Status</th>
                    <th>Admission Date</th>
                    <th>Discharge Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM Patient_Cases";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['Case_Number']}</td>
                                <td>{$row['Patient_Number']}</td>
                                <td>{$row['Diagnosis']}</td>
                                <td>{$row['Symptoms']}</td>
                                <td>{$row['Treatment_Plan']}</td>
                                <td>{$row['Case_Status']}</td>
                                <td>{$row['Admission_Date']}</td>
                                <td>{$row['Discharge_Date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No SOAP cases found.</td></tr>";
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
