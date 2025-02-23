<?php
include '../php/db-conn.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link rel="stylesheet" href="../CSS/addpatient.css">
    
</head>
<body>
    <div class="container">
        <h2>Add Patient</h2>
        <p>Fill in the information below to add a patient.</p>
        <form id="patientForm">
            <label for="name">Patient ID:</label>
            <input type="text" id="patient-id" name="patient-id" placeholder="Enter Patient ID" required>

            <label for="name">First Name:</label>
            <input type="text" id="first-name" name="first-name" placeholder="Enter First Name" required>

            <label for="name">Last Name:</label>
            <input type="text" id="last-name" name="first-name" placeholder="Enter Last Name" required>
            
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" placeholder="Enter Age" required>
            
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="phone">Conatct Number:</label>
            <input type="tel" id="conatct-phone" name="conatct-phone" placeholder="Enter Contact Number" required>

            <label for="name">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter Address" required>

            <label for="email">Email: </label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>

            <label>Gender:</label>
            <div class="gender">
                <input type="radio" id="male" name="gender" value="Male" required> <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="Female" required> <label for="female">Female</label>
            </div>

            <div class="buttons">
                <button type="reset" class="cancel">CANCEL</button>
                <button type="submit" class="submit">SUBMIT</button>
            </div>
        </form>
    </div>

    <script>
    document.getElementById("patientForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("http://localhost/CCS112/group-ni-ara/add_patient.php", {
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
    </script>
</body>
</html>
