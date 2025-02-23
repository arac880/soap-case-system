<?php
include '../php/db-conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $caseNumber = $_POST['case-number'];
    $patientNumber = $_POST['patient-number'];
    $diagnosis = $_POST['diagnosis'];
    $symptoms = $_POST['symptoms'];
    $treatmentPlan = $_POST['treatment-plan'];
    $caseStatus = $_POST['case-status'];
    $admissionDate = $_POST['admission-date'];
    $dischargeDate = $_POST['discharge-date'];

    $sql = "INSERT INTO Patient_Cases (Case_Number, Patient_Number, Diagnosis, Symptoms, Treatment_Plan, Case_Status, Admission_Date, Discharge_Date) 
            VALUES ('$caseNumber', '$patientNumber', '$diagnosis', '$symptoms', '$treatmentPlan', '$caseStatus', '$admissionDate', '$dischargeDate')";

    if (mysqli_query($conn, $sql)) {
        $response = array("status" => "success", "message" => "SOAP case added successfully.");
    } else {
        $response = array("status" => "error", "message" => "Error: " . $sql . "<br>" . mysqli_error($conn));
    }

    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP General Medical Clinic - Add SOAP Case</title>
    <link rel="stylesheet" href="../CSS/addSoapCase.css">
</head>
<body>
    <div class="container">
        <h2>Add SOAP Case</h2>
        <p>Fill in the information below to add a SOAP case.</p>
        <form id="soapCaseForm">
            <label for="case-number">Case Number:</label>
            <input type="text" id="case-number" name="case-number" placeholder="Enter Case Number" required>

            <label for="patient-number">Patient Number:</label>
            <input type="text" id="patient-number" name="patient-number" placeholder="Enter Patient Number" required>

            <label for="diagnosis">Diagnosis:</label>
            <textarea id="diagnosis" name="diagnosis" placeholder="Enter Diagnosis" required></textarea>

            <label for="symptoms">Symptoms:</label>
            <textarea id="symptoms" name="symptoms" placeholder="Enter Symptoms" required></textarea>

            <label for="treatment-plan">Treatment Plan:</label>
            <textarea id="treatment-plan" name="treatment-plan" placeholder="Enter Treatment Plan"></textarea>

            <label for="case-status">Case Status:</label>
            <select id="case-status" name="case-status" required>
                <option value="Open">Open</option>
                <option value="In Progress">In Progress</option>
                <option value="Closed">Closed</option>
            </select>

            <label for="admission-date">Admission Date:</label>
            <input type="date" id="admission-date" name="admission-date" required>

            <label for="discharge-date">Discharge Date:</label>
            <input type="date" id="discharge-date" name="discharge-date">

            <div class="buttons">
            <button type="button" class="cancel" onclick="goback()">CANCEL</button></a>
                <button type="submit" class="submit">SUBMIT</button>
            </div>
        </form>
    </div>

    <script>
    document.getElementById("soapCaseForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("addsoapcase.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                document.getElementById("soapCaseForm").reset();
            }
        })
        .catch(error => console.error("Error:", error));
    });
    function goback(){
        window.history.back();
    }
    </script>
</body>
</html>
