<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phoneName = $_POST["phoneName"];
    $phonePrice = $_POST["phonePrice"];
    $phoneCondition = $_POST["phoneCondition"];
    $phoneDetails = $_POST["phoneDetails"];

    $uploadDir = "../uploads/"; // Ensure folder exists inside the current directory

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die(json_encode(["status" => "error", "message" => "Failed to create upload directory."]));
        }
    }

    $imagePaths = [];


    if (!empty($_FILES["phoneImages"]["name"][0])) {
        foreach ($_FILES["phoneImages"]["tmp_name"] as $key => $tmpName) {
            if ($_FILES["phoneImages"]["error"][$key] == 0) {
                $fileName = time() . "_" . basename($_FILES["phoneImages"]["name"][$key]);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $imagePaths[] = $targetPath;
                } else {
                    echo json_encode(["status" => "error", "message" => "Error uploading file: " . $_FILES["phoneImages"]["name"][$key]]);
                    exit;
                }
            }
        }
    }

    if (empty($imagePaths)) {
        echo json_encode(["status" => "error", "message" => "No images were uploaded."]);
        exit;
    }

    $imagePathsStr = implode(",", $imagePaths); // Store multiple paths as a comma-separated string

    $stmt = $conn->prepare("INSERT INTO phones (phone_name, phone_price, phone_condition, phone_details, image_paths) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "SQL Prepare failed: " . $conn->error]));
    }

    $stmt->bind_param("sdiss", $phoneName, $phonePrice, $phoneCondition, $phoneDetails, $imagePathsStr);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Data stored successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to store data: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
