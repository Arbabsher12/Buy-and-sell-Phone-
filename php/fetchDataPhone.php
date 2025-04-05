<?php
header("Content-Type: application/json");

include 'db.php';

// Initialize variables
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$price_ranges = isset($_GET['price_range']) ? $_GET['price_range'] : [];
$brands = isset($_GET['brands']) ? $_GET['brands'] : [];
$conditions = isset($_GET['conditions']) ? $_GET['conditions'] : [];
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;

// Build query
$query = "SELECT p.*, 
          (SELECT COUNT(*) FROM phones WHERE id = p.id) as image_count
          FROM phones p
          WHERE 1=1";

// Add search condition
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query .= " AND (p.phone_name LIKE '%$search%' OR p.phone_details LIKE '%$search%')";
}

// Add price range conditions
if (!empty($price_ranges)) {
    $price_conditions = [];
    foreach ($price_ranges as $range) {
        $range_parts = explode('-', $range);
        if (count($range_parts) == 2) {
            $min = (float)$range_parts[0];
            $max = (float)$range_parts[1];
            $price_conditions[] = "(p.phone_price BETWEEN $min AND $max)";
        }
    }
    if (!empty($price_conditions)) {
        $query .= " AND (" . implode(" OR ", $price_conditions) . ")";
    }
}

// Add brand conditions
if (!empty($brands)) {
    $brand_conditions = [];
    foreach ($brands as $brand) {
        $brand = $conn->real_escape_string($brand);
        $brand_conditions[] = "p.phone_name LIKE '%$brand%'";
    }
    if (!empty($brand_conditions)) {
        $query .= " AND (" . implode(" OR ", $brand_conditions) . ")";
    }
}

// Add condition filters
if (!empty($conditions)) {
    $condition_ranges = [];
    foreach ($conditions as $condition) {
        switch ($condition) {
            case 'new':
                $condition_ranges[] = "p.phone_condition = 10";
                break;
            case 'like_new':
                $condition_ranges[] = "p.phone_condition BETWEEN 9 AND 10";
                break;
            case 'excellent':
                $condition_ranges[] = "p.phone_condition BETWEEN 7 AND 8";
                break;
            case 'good':
                $condition_ranges[] = "p.phone_condition BETWEEN 5 AND 6";
                break;
            case 'fair':
                $condition_ranges[] = "p.phone_condition < 5";
                break;
        }
    }
    if (!empty($condition_ranges)) {
        $query .= " AND (" . implode(" OR ", $condition_ranges) . ")";
    }
}

// Add sorting
switch ($sort) {
    case 'price_high':
        $query .= " ORDER BY p.phone_price DESC";
        break;
    case 'price_low':
        $query .= " ORDER BY p.phone_price ASC";
        break;
    case 'popularity':
        $query .= " ORDER BY p.views DESC";
        break;
    case 'oldest':
        $query .= " ORDER BY p.created_at ASC";
        break;
    case 'newest':
    default:
        $query .= " ORDER BY p.created_at DESC";
        break;
}

// Add limit
$query .= " LIMIT $limit";

// Execute query
$result = $conn->query($query);

$phones = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Handle multiple images, select the first one
        $images = [];
        if (!empty($row["image_paths"])) {
            // Try to decode as JSON first
            $decoded = json_decode($row["image_paths"], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $images = $decoded;
            } else {
                // If not JSON, try comma-separated
                $images = explode(',', $row["image_paths"]);
            }
        }
        
        $firstImage = !empty($images) ? trim($images[0]) : '../uploads/none.jpg';

        $phones[] = [
            "id" => $row["id"],
            "name" => $row["phone_name"],
            "price" => $row["phone_price"],
            "condition" => $row["phone_condition"],
            "details" => $row["phone_details"],
            "image" => $firstImage,
            "created_at" => $row["created_at"],
            "views" => $row["views"]
        ];
    }
}

// Return JSON response
echo json_encode($phones);
$conn->close();
?>