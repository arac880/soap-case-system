<?php
include '../php/db-conn.php';

// Insert SOAP case into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $case_number = $_POST['case_number'];
    $patient_number = $_POST['patient_number'];
    $diagnosis = $_POST['diagnosis'];
    $symptoms = $_POST['symptoms'];
    $treatment_plan = $_POST['treatment_plan'];
    $case_status = $_POST['case_status'];
    $admission_date = $_POST['admission_date'];
    $discharge_date = !empty($_POST['discharge_date']) ? $_POST['discharge_date'] : NULL;

    $sql = "INSERT INTO Patient_Cases (Case_Number, Patient_Number, Diagnosis, Symptoms, Treatment_Plan, Case_Status, Admission_Date, Discharge_Date) 
            VALUES ('$case_number', '$patient_number', '$diagnosis', '$symptoms', '$treatment_plan', '$case_status', '$admission_date', '$discharge_date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('SOAP Case Added Successfully!'); window.location.href='add_soap.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add SOAP Case</title>
    <link rel="stylesheet" href="../CSS/addsoapcase.css">
</head>
<body>

<div class="container">
    <h2>Add New SOAP Case</h2>
    <form method="POST" action="add_soap.php">
        <label>Case Number:</label>
        <input type="text" name="case_number" placeholder="Enter Case Number" required>

        <label>Patient Number:</label>
        <input type="text" name="patient_number" placeholder="Enter Patient Number" required>

        <label>Diagnosis:</label>
        <textarea 
        name="diagnosis" placeholder="Enter Diagnosis" required></textarea>

        <label>Symptoms:</label>
        <textarea name="symptoms" placeholder="Enter Symptoms" required></textarea>

        <label>Treatment Plan:</label>
        <textarea name="treatment_plan" placeholder="Enter Treatment Plan" required></textarea>

        <label>Case Status:</label>
        <select name="case_status">
            <option value="Open">Open</option>
            <option value="In Progress">In Progress</option>
            <option value="Closed">Closed</option>
        </select>

        <label>Admission Date:</label>
        <input type="date" name="admission_date" required>

        <label>Discharge Date:</label>
        <input type="date" name="discharge_date">

        <div class="buttons">
            <button type="button" class="cancel" onclick="window.location.href='dashboard.php';">Cancel</button>
            <button type="submit" class="submit">Add SOAP Case</button>
        </div>
    </form>
</div>

</body>
</html>
