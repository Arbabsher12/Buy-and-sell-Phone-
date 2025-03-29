<?php
header("Content-Type: application/json");

include 'db.php';


// Fetch phone details
$sql = "SELECT id, phone_name, phone_price, image_paths FROM phones";
$result = $conn->query($sql);

$phones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Handle multiple images, select the first one
        $images = explode(",", $row["image_paths"]);
        $firstImage = $images[0] ?? ''; // Default empty string if no image

        $phones[] = [
            "id" => $row["id"],
            "name" => $row["phone_name"],
            "price" => $row["phone_price"],
            "image" => $firstImage
        ];
    }
}

// Return JSON response
echo json_encode($phones);
$conn->close();
?>
