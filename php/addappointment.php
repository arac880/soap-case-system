<?php
include '../php/db-conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientName = $_POST['patient-name'];
    $contactNumber = $_POST['contact-number'];
    $email = $_POST['email'];
    $appointmentDate = $_POST['appointment-date'];
    $appointmentTime = $_POST['appointment-time'];
    
    // if custom reason is selected, use the custom reason value
    $reason = $_POST['reason'];
    if ($reason === "Other" && !empty($_POST['custom-reason'])) {
        $reason = $_POST['custom-reason']; 
    }

    $sql = "INSERT INTO Appointments (Patient_Name, Contact_Number, Email, Appointment_Date, Appointment_Time, Reason) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $patientName, $contactNumber, $email, $appointmentDate, $appointmentTime, $reason);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Appointment booked successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error booking appointment: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Clinic - Appointment</title>
    <link rel="stylesheet" href="../CSS/addappointment.css">
</head>
<body>
    <div class="container">
        <h2>Book an Appointment</h2>
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

            <!-- custome reason input -->
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

        fetch("process_appointment.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                document.getElementById("appointmentForm").reset();
                toggleCustomReason(); // Reset custom reason field
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
