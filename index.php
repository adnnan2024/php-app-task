<?php
include 'db.php';
$conn = connectDB();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT message FROM messages";
$result = $conn->query($sql);
$message = "Hello World!";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $message = $row["message"];
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $message; ?></h1>
    </div>
</body>
</html>
