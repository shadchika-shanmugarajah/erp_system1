<?php
include 'db.php';
$id = $_GET['id'];
$sql = "SELECT * FROM customers WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <h2>Edit Customer</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label>Title:</label>
        <select name="title" required>
            <option value="Mr" <?php if($row['title'] == 'Mr') echo 'selected'; ?>>Mr</option>
            <option value="Mrs" <?php if($row['title'] == 'Mrs') echo 'selected'; ?>>Mrs</option>
            <option value="Miss" <?php if($row['title'] == 'Miss') echo 'selected'; ?>>Miss</option>
            <option value="Dr" <?php if($row['title'] == 'Dr') echo 'selected'; ?>>Dr</option>
        </select>

        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>

        <label>Contact Number:</label>
        <input type="tel" 
               name="contact_number" 
               value="<?php echo $row['contact_number']; ?>" 
               pattern="[0-9]{10}" 
               maxlength="10"
               title="Please enter a 10-digit phone number"
               required>

        <label>District:</label>
        <select name="district" required>
            <option value="">Select District</option>
            <option value="Ampara" <?php if($row['district'] == 'Ampara') echo 'selected'; ?>>Ampara</option>
            <option value="Anuradhapura" <?php if($row['district'] == 'Anuradhapura') echo 'selected'; ?>>Anuradhapura</option>
            <option value="Badulla" <?php if($row['district'] == 'Badulla') echo 'selected'; ?>>Badulla</option>
            <option value="Batticaloa" <?php if($row['district'] == 'Batticaloa') echo 'selected'; ?>>Batticaloa</option>
            <option value="Colombo" <?php if($row['district'] == 'Colombo') echo 'selected'; ?>>Colombo</option>
            <option value="Galle" <?php if($row['district'] == 'Galle') echo 'selected'; ?>>Galle</option>
            <option value="Gampaha" <?php if($row['district'] == 'Gampaha') echo 'selected'; ?>>Gampaha</option>
            <option value="Hambantota" <?php if($row['district'] == 'Hambantota') echo 'selected'; ?>>Hambantota</option>
            <option value="Jaffna" <?php if($row['district'] == 'Jaffna') echo 'selected'; ?>>Jaffna</option>
            <option value="Kalutara" <?php if($row['district'] == 'Kalutara') echo 'selected'; ?>>Kalutara</option>
            <option value="Kandy" <?php if($row['district'] == 'Kandy') echo 'selected'; ?>>Kandy</option>
            <option value="Kegalle" <?php if($row['district'] == 'Kegalle') echo 'selected'; ?>>Kegalle</option>
            <option value="Kilinochchi" <?php if($row['district'] == 'Kilinochchi') echo 'selected'; ?>>Kilinochchi</option>
            <option value="Kurunegala" <?php if($row['district'] == 'Kurunegala') echo 'selected'; ?>>Kurunegala</option>
            <option value="Mannar" <?php if($row['district'] == 'Mannar') echo 'selected'; ?>>Mannar</option>
            <option value="Matale" <?php if($row['district'] == 'Matale') echo 'selected'; ?>>Matale</option>
            <option value="Matara" <?php if($row['district'] == 'Matara') echo 'selected'; ?>>Matara</option>
            <option value="Monaragala" <?php if($row['district'] == 'Monaragala') echo 'selected'; ?>>Monaragala</option>
            <option value="Mullaitivu" <?php if($row['district'] == 'Mullaitivu') echo 'selected'; ?>>Mullaitivu</option>
            <option value="Nuwara Eliya" <?php if($row['district'] == 'Nuwara Eliya') echo 'selected'; ?>>Nuwara Eliya</option>
            <option value="Polonnaruwa" <?php if($row['district'] == 'Polonnaruwa') echo 'selected'; ?>>Polonnaruwa</option>
            <option value="Puttalam" <?php if($row['district'] == 'Puttalam') echo 'selected'; ?>>Puttalam</option>
            <option value="Ratnapura" <?php if($row['district'] == 'Ratnapura') echo 'selected'; ?>>Ratnapura</option>
            <option value="Trincomalee" <?php if($row['district'] == 'Trincomalee') echo 'selected'; ?>>Trincomalee</option>
            <option value="Vavuniya" <?php if($row['district'] == 'Vavuniya') echo 'selected'; ?>>Vavuniya</option>
        </select>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>">

        <button type="submit">Update</button>
    </form>

</body>
</html>
