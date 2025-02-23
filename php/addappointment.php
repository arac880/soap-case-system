<?php
include '../php/db-conn.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $patientName = trim($_POST['patient-name']);
    $contactNumber = trim($_POST['contact-number']);
    $email = trim($_POST['email']);
    $appointmentDate = $_POST['appointment-date'];
    $appointmentTime = $_POST['appointment-time'];
    $reason = $_POST['reason'];

    if ($reason === "Other" && !empty($_POST['custom-reason'])) {
        $reason = trim($_POST['custom-reason']);
    }

    if (!$conn) {
        echo json_encode(["status" => "error", "message" => "Database connection failed."]);
        exit();
    }

    // check if the patient already exists in the Patients table
    $stmt = $conn->prepare("SELECT Patient_ID FROM Patients WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    if ($row = $result->fetch_assoc()) {
        $patientID = $row['Patient_ID'];  // Use existing Patient_ID
    } else {
        // insert new patient if not found
        $insertPatient = $conn->prepare("INSERT INTO Patients (Patient_Number, First_Name, Last_Name, Contact_Number, Email) VALUES (?, ?, ?, ?, ?)");
        $patientNumber = uniqid('PAT-'); 
        $nameParts = explode(" ", $patientName, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        $insertPatient->bind_param("sssss", $patientNumber, $firstName, $lastName, $contactNumber, $email);
        $insertPatient->execute();
        $patientID = $insertPatient->insert_id; 
        $insertPatient->close();
    }

    // insert Appointment
    $sql = "INSERT INTO Appointments (Patient_ID, Appointment_Date, Appointment_Time, Reason) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $patientID, $appointmentDate, $appointmentTime, $reason);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Appointment booked successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error booking appointment: " . $stmt->error]);
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
    <title>SOAP General Clinic - Appointment</title>
    <link rel="stylesheet" href="../CSS/addappointment.css">
</head>
<body>
    <div class="container">
        <h2>Add New Appointment</h2>
        <p>Fill in the details below to schedule an appointment.</p>
        <form id="appointmentForm">
            <label for="patient-name">Patient Full Name:</label>
            <input type="text" id="patient-name" name="patient-name" placeholder="Enter Full Name" required>

            <label for="contact-number">Contact Number:</label>
            <input type="tel" id="contact-number" name="contact-number" placeholder="Enter Contact Number" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email Address" required>

            <label for="appointment-date">Appointment Date:</label>
            <input type="date" id="appointment-date" name="appointment-date" required>

            <label for="appointment-time">Appointment Time:</label>
            <input type="time" id="appointment-time" name="appointment-time" required>

            <label for="reason">Reason for Visit:</label>
            <select id="reason" name="reason" required onchange="toggleCustomReason()">
                <option value="General Checkup">General Checkup</option>
                <option value="Vaccination">Vaccination</option>
                <option value="Follow-up Visit">Follow-up Visit</option>
                <option value="Flu Symptoms">Flu Symptoms</option>
                <option value="Physical Examination">Physical Examination</option>
                <option value="Other">Other</option>
            </select>

            <!-- custom reason input -->
            <input type="text" id="custom-reason" name="custom-reason" placeholder="Enter Custom Reason" style="display: none; margin-top: 10px;">

            <div class="buttons">
                <button type="button" class="cancel" onclick="goBack()">CANCEL</button>
                <button type="submit" class="submit">SUBMIT</button>
            </div>
        </form>
    </div>

    <script>
    function toggleCustomReason() {
        var reasonSelect = document.getElementById("reason");
        var customReasonInput = document.getElementById("custom-reason");

        if (reasonSelect.value === "Other") {
            customReasonInput.style.display = "block";
            customReasonInput.setAttribute("required", "required");
        } else {
            customReasonInput.style.display = "none";
            customReasonInput.removeAttribute("required");
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let today = new Date().toISOString().split("T")[0]; 
        document.getElementById("appointment-date").setAttribute("min", today);
    });

    document.getElementById("appointmentForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch(window.location.href, {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                document.getElementById("appointmentForm").reset();
                toggleCustomReason();
            }
        })
        .catch(error => console.error("Error:", error));
    });

    function goBack() {
        window.history.back();
    }
    </script>
</body>
</html>
