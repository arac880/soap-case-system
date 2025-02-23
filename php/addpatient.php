<?php
include '../php/db-conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $contactNumber = trim($_POST['contact-phone']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];

    // generate a unique Patient Number
    $patientNumber = uniqid('PAT-');

    // validate
    if (empty($firstName) || empty($lastName) || empty($age) || empty($dob) || empty($email) || empty($gender)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit();
    }

    // insert Patient
    $sql = "INSERT INTO Patients (Patient_Number, First_Name, Last_Name, Age, Date_of_Birth, Contact_Number, Address, Email, Gender) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisssss", $patientNumber, $firstName, $lastName, $age, $dob, $contactNumber, $address, $email, $gender);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Patient added successfully."]);
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
    <title>SOAP General Medical Clinic - Add Patient</title>
    <link rel="stylesheet" href="../CSS/addPatient.css">
</head>
<body>
    <div class="container">
        <h2>SOAP Medical Clinic</h2>
        <p>Fill in the information below to add a patient.</p>
        <form id="patientForm">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name" placeholder="Enter First Name" required>

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name" placeholder="Enter Last Name" required>
            
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" placeholder="Enter Age" required>
            
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="contact-phone">Contact Number:</label>
            <input type="tel" id="contact-phone" name="contact-phone" placeholder="Enter Contact Number" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter Address" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>

            <label>Gender:</label>
            <div class="gender">
                <input type="radio" id="male" name="gender" value="Male" required> <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="Female" required> <label for="female">Female</label>
            </div>

            <div class="buttons">
                <button type="button" class="cancel" onclick="goback()">CANCEL</button>
                <button type="submit" class="submit">SUBMIT</button>
            </div>
        </form>
    </div>

    <script>
    document.getElementById("patientForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("addpatient.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                document.getElementById("patientForm").reset();
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
