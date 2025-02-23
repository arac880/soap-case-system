<?php
include '../php/db-conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $patientNumber = trim($_POST['patient-number']);
    $diagnosis = trim($_POST['diagnosis']);
    $symptoms = trim($_POST['symptoms']);
    $treatmentPlan = trim($_POST['treatment-plan']);
    $caseStatus = $_POST['case-status'];
    $admissionDate = $_POST['admission-date'];
    $dischargeDate = !empty($_POST['discharge-date']) ? $_POST['discharge-date'] : null;

    // generate a unique Case Number
    $caseNumber = uniqid('CASE-');

    // required fields
    if (empty($patientNumber) || empty($diagnosis) || empty($symptoms) || empty($caseStatus) || empty($admissionDate)) {
        echo json_encode(["status" => "error", "message" => "All required fields must be filled."]);
        exit();
    }

    // validate Patient exists
    $checkPatientQuery = "SELECT Patient_Number FROM Patients WHERE Patient_Number = ?";
    $checkStmt = $conn->prepare($checkPatientQuery);
    $checkStmt->bind_param("s", $patientNumber);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(["status" => "error", "message" => "Patient not found."]);
        exit();
    }
    $checkStmt->close();

    // prevemt future discharge dates for closed cases
    if ($caseStatus === "Closed" && empty($dischargeDate)) {
        echo json_encode(["status" => "error", "message" => "Discharge Date is required for closed cases."]);
        exit();
    }

    // insert SOAP Case
    $sql = "INSERT INTO Patient_Cases (Case_Number, Patient_Number, Diagnosis, Symptoms, Treatment_Plan, Case_Status, Admission_Date, Discharge_Date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $caseNumber, $patientNumber, $diagnosis, $symptoms, $treatmentPlan, $caseStatus, $admissionDate, $dischargeDate);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "SOAP case added successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
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
            <label for="patient-number">Patient Number:</label>
            <input type="text" id="patient-number" name="patient-number" placeholder="Enter Patient Number" required>

            <label for="diagnosis">Diagnosis:</label>
            <textarea id="diagnosis" name="diagnosis" placeholder="Enter Diagnosis" required></textarea>

            <label for="symptoms">Symptoms:</label>
            <textarea id="symptoms" name="symptoms" placeholder="Enter Symptoms" required></textarea>

            <label for="treatment-plan">Treatment Plan:</label>
            <textarea id="treatment-plan" name="treatment-plan" placeholder="Enter Treatment Plan"></textarea>

            <label for="case-status">Case Status:</label>
            <select id="case-status" name="case-status" required onchange="toggleDischargeDate()">
                <option value="Open">Open</option>
                <option value="In Progress">In Progress</option>
                <option value="Closed">Closed</option>
            </select>

            <label for="admission-date">Admission Date:</label>
            <input type="date" id="admission-date" name="admission-date" required>

            <label for="discharge-date">Discharge Date:</label>
            <input type="date" id="discharge-date" name="discharge-date" disabled>

            <div class="buttons">
                <button type="button" class="cancel" onclick="goback()">CANCEL</button>
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

    function toggleDischargeDate() {
        let caseStatus = document.getElementById("case-status").value;
        let dischargeDate = document.getElementById("discharge-date");
        dischargeDate.disabled = (caseStatus !== "Closed");
        if (dischargeDate.disabled) dischargeDate.value = "";
    }

    function goback() {
        window.history.back();
    }
    </script>
</body>
</html>

