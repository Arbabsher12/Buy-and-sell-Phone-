<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Fetch brands for the dropdown
function getBrands() {
    global $conn;
    $brands = [];
    
    $sql = "SELECT id, name, logo FROM brands ORDER BY name";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }
    }
    return $brands;
}
// Get brands for the dropdown
$brands = getBrands();

// Fetch phone models by brand
if (isset($_GET['action']) && $_GET['action'] == 'getModels' && isset($_GET['brand_id'])) {
    $brand_id = intval($_GET['brand_id']);
    
    $stmt = $conn->prepare("SELECT id, model_name FROM phone_models WHERE brand_id = ? ORDER BY model_name");
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $models = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $models[] = $row;
        }
    }
    
    echo json_encode($models);
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand_id = $_POST["brand_id"];
    $model_id = $_POST["model_id"];
    $custom_model = isset($_POST["custom_model"]) ? $_POST["custom_model"] : null;
    $phonePrice = $_POST["phonePrice"];
    $phoneStorage = $_POST["phoneStorage"];
    $phoneColor = $_POST["phoneColor"];
    $phoneCondition = $_POST["phoneCondition"];
    $phoneDetails = $_POST["phoneDetails"];
    $sellerName = $_POST["sellerName"];
    $sellerEmail = $_POST["sellerEmail"];
    $sellerPhone = $_POST["sellerPhone"];
    $sellerLocation = $_POST["sellerLocation"];

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
                    $imagePaths[] = $fileName; // Store only the filename, not the full path
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

    // Determine the phone name (either from model or custom input)
    $phoneName = $custom_model;
    if (empty($custom_model) && !empty($model_id)) {
        $modelStmt = $conn->prepare("SELECT model_name FROM phone_models WHERE id = ?");
        $modelStmt->bind_param("i", $model_id);
        $modelStmt->execute();
        $modelResult = $modelStmt->get_result();
        if ($modelRow = $modelResult->fetch_assoc()) {
            $phoneName = $modelRow['model_name'];
        }
        $modelStmt->close();
    }

    $stmt = $conn->prepare("INSERT INTO phones (brand_id, model_id, phone_name, phone_price, phone_storage, phone_color, phone_condition, phone_details, image_paths, seller_name, seller_email, seller_phone, seller_location, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "SQL Prepare failed: " . $conn->error]));
    }

    $stmt->bind_param("iisdsssssssss", $brand_id, $model_id, $phoneName, $phonePrice, $phoneStorage, $phoneColor, $phoneCondition, $phoneDetails, $imagePathsStr, $sellerName, $sellerEmail, $sellerPhone, $sellerLocation);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Your phone listing has been successfully created!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to store data: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}


?>

