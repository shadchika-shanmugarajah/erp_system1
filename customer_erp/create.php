<?php
include 'db.php';

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $contact_number = trim($_POST['contact_number']);
    $district = trim($_POST['district']);
    $email = trim($_POST['email']);

    // Enhanced Validation
    if (empty($first_name) || empty($last_name)) {
        $error_message = "First name and last name are required!";
    } elseif (empty($contact_number)) {
        $error_message = "Contact number is required!";
    } elseif (!preg_match('/^[0-9]{10}$/', $contact_number)) {
        $error_message = "Please enter a valid 10-digit phone number!";
    } elseif (empty($district)) {
        $error_message = "District is required!";
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address!";
    } else {
        $sql = "INSERT INTO customers (title, first_name, last_name, contact_number, district, email) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $title, $first_name, $last_name, $contact_number, $district, $email);

        if ($stmt->execute()) {
            $success_message = "Customer registered successfully!";
            // Clear form fields after successful registration
            $title = $first_name = $last_name = $contact_number = $district = $email = "";
        } else {
            $error_message = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - ERP System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .navigation {
            margin: 20px 0;
            text-align: center;
        }
        .btn-link {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
        }
        .btn-link:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Customer Registration</h1>
        
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title:</label>
                <select name="title" id="title" required>
                    <option value="Mr" <?php if(isset($title) && $title == 'Mr') echo 'selected'; ?>>Mr</option>
                    <option value="Mrs" <?php if(isset($title) && $title == 'Mrs') echo 'selected'; ?>>Mrs</option>
                    <option value="Miss" <?php if(isset($title) && $title == 'Miss') echo 'selected'; ?>>Miss</option>
                    <option value="Dr" <?php if(isset($title) && $title == 'Dr') echo 'selected'; ?>>Dr</option>
                </select>
            </div>

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="tel" 
                       name="contact_number" 
                       id="contact_number" 
                       value="<?php echo isset($contact_number) ? htmlspecialchars($contact_number) : ''; ?>" 
                       pattern="[0-9]{10}" 
                       maxlength="10"
                       placeholder="e.g., 0771234567"
                       title="Please enter a 10-digit phone number"
                       required>
                <small>Enter 10-digit phone number (e.g., 0771234567)</small>
            </div>

            <div class="form-group">
                <label for="district">District:</label>
                <select name="district" id="district" required>
                    <option value="">Select District</option>
                    <option value="Ampara" <?php if(isset($district) && $district == 'Ampara') echo 'selected'; ?>>Ampara</option>
                    <option value="Anuradhapura" <?php if(isset($district) && $district == 'Anuradhapura') echo 'selected'; ?>>Anuradhapura</option>
                    <option value="Badulla" <?php if(isset($district) && $district == 'Badulla') echo 'selected'; ?>>Badulla</option>
                    <option value="Batticaloa" <?php if(isset($district) && $district == 'Batticaloa') echo 'selected'; ?>>Batticaloa</option>
                    <option value="Colombo" <?php if(isset($district) && $district == 'Colombo') echo 'selected'; ?>>Colombo</option>
                    <option value="Galle" <?php if(isset($district) && $district == 'Galle') echo 'selected'; ?>>Galle</option>
                    <option value="Gampaha" <?php if(isset($district) && $district == 'Gampaha') echo 'selected'; ?>>Gampaha</option>
                    <option value="Hambantota" <?php if(isset($district) && $district == 'Hambantota') echo 'selected'; ?>>Hambantota</option>
                    <option value="Jaffna" <?php if(isset($district) && $district == 'Jaffna') echo 'selected'; ?>>Jaffna</option>
                    <option value="Kalutara" <?php if(isset($district) && $district == 'Kalutara') echo 'selected'; ?>>Kalutara</option>
                    <option value="Kandy" <?php if(isset($district) && $district == 'Kandy') echo 'selected'; ?>>Kandy</option>
                    <option value="Kegalle" <?php if(isset($district) && $district == 'Kegalle') echo 'selected'; ?>>Kegalle</option>
                    <option value="Kilinochchi" <?php if(isset($district) && $district == 'Kilinochchi') echo 'selected'; ?>>Kilinochchi</option>
                    <option value="Kurunegala" <?php if(isset($district) && $district == 'Kurunegala') echo 'selected'; ?>>Kurunegala</option>
                    <option value="Mannar" <?php if(isset($district) && $district == 'Mannar') echo 'selected'; ?>>Mannar</option>
                    <option value="Matale" <?php if(isset($district) && $district == 'Matale') echo 'selected'; ?>>Matale</option>
                    <option value="Matara" <?php if(isset($district) && $district == 'Matara') echo 'selected'; ?>>Matara</option>
                    <option value="Monaragala" <?php if(isset($district) && $district == 'Monaragala') echo 'selected'; ?>>Monaragala</option>
                    <option value="Mullaitivu" <?php if(isset($district) && $district == 'Mullaitivu') echo 'selected'; ?>>Mullaitivu</option>
                    <option value="Nuwara Eliya" <?php if(isset($district) && $district == 'Nuwara Eliya') echo 'selected'; ?>>Nuwara Eliya</option>
                    <option value="Polonnaruwa" <?php if(isset($district) && $district == 'Polonnaruwa') echo 'selected'; ?>>Polonnaruwa</option>
                    <option value="Puttalam" <?php if(isset($district) && $district == 'Puttalam') echo 'selected'; ?>>Puttalam</option>
                    <option value="Ratnapura" <?php if(isset($district) && $district == 'Ratnapura') echo 'selected'; ?>>Ratnapura</option>
                    <option value="Trincomalee" <?php if(isset($district) && $district == 'Trincomalee') echo 'selected'; ?>>Trincomalee</option>
                    <option value="Vavuniya" <?php if(isset($district) && $district == 'Vavuniya') echo 'selected'; ?>>Vavuniya</option>
                </select>
            </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            </div>

            <div class="form-group">
                <button type="submit">Register Customer</button>
            </div>
        </form>

        <div class="navigation">
            <a href="index.php" class="btn-link">View All Customers</a>
        </div>
    </div>

    <?php $conn->close(); ?>

    <script>
        // Real-time phone number validation
        document.getElementById('contact_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            e.target.value = value;
            
            let feedback = document.getElementById('phone-feedback');
            if (!feedback) {
                feedback = document.createElement('small');
                feedback.id = 'phone-feedback';
                feedback.style.color = 'red';
                e.target.parentNode.appendChild(feedback);
            }
            
            if (value.length < 10) {
                feedback.textContent = `Enter ${10 - value.length} more digit(s)`;
                feedback.style.color = 'red';
            } else if (value.length === 10) {
                feedback.textContent = '✓ Valid phone number';
                feedback.style.color = 'green';
            } else if (value.length > 10) {
                e.target.value = value.slice(0, 10); // Limit to 10 digits
                feedback.textContent = '✓ Valid phone number';
                feedback.style.color = 'green';
            }
        });
    </script>
</body>
</html>
