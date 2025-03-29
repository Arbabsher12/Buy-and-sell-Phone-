<?php
header("Content-Type: application/json");

include 'db.php';


// Fetch phone details
$sql = "SELECT id, phoneName, phonePrice, phoneImages FROM phones";
$result = $conn->query($sql);

$phones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Handle multiple images, select the first one
        $images = explode(",", $row["phoneImages"]);
        $firstImage = $images[0] ?? ''; // Default empty string if no image

        $phones[] = [
            "id" => $row["id"],
            "name" => $row["phoneName"],
            "price" => $row["phonePrice"],
            "image" => $firstImage
        ];
    }
}

// Return JSON response
echo json_encode($phones);
$conn->close();
?>
