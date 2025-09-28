<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management - ERP System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }
        .btn-primary {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn-primary:hover {
            background: #218838;
        }
        .search-form {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .search-form input {
            padding: 8px;
            margin-right: 10px;
            width: 200px;
        }
        .search-form button {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .search-form button:hover {
            background: #0056b3;
        }
        .clear-search {
            background: #6c757d;
            margin-left: 5px;
        }
        .clear-search:hover {
            background: #545b62;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Customer Management System</h1>
            <a href="create.php" class="btn-primary">+ Add New Customer</a>
        </div>
        
        <!-- Enhanced Search Form -->
        <div class="search-form">
            <form action="index.php" method="GET">
                <input type="text" 
                       name="search" 
                       placeholder="Search by name, contact, district, or email..." 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">🔍 Search</button>
                <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="index.php" class="search-form button clear-search">Clear</a>
                <?php endif; ?>
            </form>
        </div>

        <?php
        include 'db.php';
        
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        if (!empty($search)) {
            // Enhanced search across multiple fields including email
            $sql = "SELECT * FROM customers WHERE 
                    first_name LIKE ? OR 
                    last_name LIKE ? OR 
                    contact_number LIKE ? OR 
                    district LIKE ? OR 
                    email LIKE ? 
                    ORDER BY first_name ASC";
            $stmt = $conn->prepare($sql);
            $search_param = "%$search%";
            $stmt->bind_param("sssss", $search_param, $search_param, $search_param, $search_param, $search_param);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            // Show all customers when no search
            $sql = "SELECT * FROM customers ORDER BY first_name ASC";
            $result = $conn->query($sql);
        }

        // Display customer count after getting results
        $total_customers = $result->num_rows;
        if (!empty($search)) {
            echo "<p><strong>Search Results:</strong> Found $total_customers customer(s) matching '$search'</p>";
        } else {
            echo "<p><strong>Total Customers:</strong> $total_customers</p>";
        }
        ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Contact Number</th>
            <th>District</th>
            <th>Email</th>
            <th>Actions</th>
            
        </tr>
        <?php

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"]. ". " . $row["first_name"]. " " . $row["last_name"]. "</td>";
                echo "<td>" . $row["contact_number"]. "</td>";
                echo "<td>" . $row["district"]. "</td>";
                echo "<td>" . $row["email"]. "</td>";
                echo "<td>
                        <a href='edit_customer.php?id=" . $row["id"] . "'>Edit</a> |
                        <a href='delete_customer.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            $message = !empty($search) ? "No customers found matching '$search'" : "No customers registered yet";
            echo "<tr><td colspan='4'>$message</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    
    </div>
</body>
</html>
