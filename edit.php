<style>
        body {
            background-color: #ffffff;
            background: linear-gradient(0deg, #000000 0%, #000000 80%, #0b4703 80%, #036408 100%);
            padding: 30px;
            height: 100%;
            color: white;
        }
		form {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #1b3f0b;
			border-radius: 5px;
            margin-top: 150px;
		}
		input[type="text"], input[type="email"], input[type="tel"] {
			display: block;
			margin-bottom: 10px;
			width: 100%;
			padding: 10px;
			border-radius: 3px;
			border: none;
			box-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            color: white:
		}
		input[type="submit"] {
			background-color: black;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 3px;
			cursor: pointer;
		}
		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
	</style>

<?php
// set database connection parameters
// Set database connection parameters
$database_host = "localhost";
$database_user = "root";
$database_password = "";
$database_name = "studentdatabase";

// Connect to the database
$conn = mysqli_connect($database_host, $database_user, $database_password, $database_name);

// Check if the user is logged in as admin
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
    // Redirect to login page or display error message
    header("Location: login.html");
    exit;
}

// Check if the form has been submitted
if(isset($_POST["submit"])) {
    // Get form data
    $id = $_POST["id"];
    $name = $_POST["name"];
    $matric_no = $_POST["matricNum"];
    $current_address = $_POST["currAddress"];
    $email = $_POST["email"];
    $mobile_phone = $_POST["phone"];
    $home_phone = $_POST["homePhone"];

    // Update the data in the database
    $query = "UPDATE studentform SET name='$name', matricNum='$matric_no', currAddress='$current_address', email='$email', phone='$mobile_phone', homePhone='$home_phone' WHERE id=$id";
    mysqli_query($conn, $query);

    // Redirect to data page
    header("Location: privilege.php");
    exit;
}

// Get the ID parameter from the URL
$id = $_GET["id"];

// Fetch data for the selected ID from the database
$query = "SELECT * FROM studentform WHERE id=$id";
$result = mysqli_query($conn, $query);

// Check if the query returned any rows
if(mysqli_num_rows($result) > 0) {
    // Access the data from the row as needed
    $row = mysqli_fetch_assoc($result);

    // Display the form for editing the data
    echo "<form method='POST'>";
    
    echo "<input type='hidden' name='id' value='" . $row["id"] . "'/>";
    
    echo "Name: <input type='text' name='name' value='" . $row["name"] . "' size='40'/><br/>";
    
    echo "Matric No: <input type='text' name='matricNum' value='" . $row["matricNum"] . "' size='40'/><br/>";
    
    echo "Current Address: <input type='text' name='currAddress' value='" . $row["currAddress"] . "' size='60'/><br/>";
    
    echo "Email: <input type='email' name='email' value='" . $row["email"] . "' size='40'/><br/>";
    
    echo "Mobile Phone: <input type='tel' name='phone' value='" . $row["phone"] . "' size='40'/><br/>";
    
    echo "Home Phone: <input type='tel' name='homePhone' value='" . $row["homePhone"] . "' size='40'/><br/>";
    
    echo "<input type='submit' name='submit' value='Save Changes'/>";
        
    echo "</form>";
    
} else {
    // Handle the case where no row was returned
    echo "No data found for ID: $id";
}

// Close database connection
mysqli_close($conn);

?>
