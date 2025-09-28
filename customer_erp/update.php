<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $contact_number = trim($_POST['contact_number']);
    $district = $_POST['district'];
    $email = trim($_POST['email']);

    // Validate phone number
    if (!preg_match('/^[0-9]{10}$/', $contact_number)) {
        echo "<script>alert('Please enter a valid 10-digit phone number!'); history.back();</script>";
        exit();
    }

    // Validate email if provided
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address!'); history.back();</script>";
        exit();
    }

    $sql = "UPDATE customers SET title=?, first_name=?, last_name=?, contact_number=?, district=?, email=? WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $title, $first_name, $last_name, $contact_number, $district, $email, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>
