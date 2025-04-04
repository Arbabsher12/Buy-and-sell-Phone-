<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: rgba(204, 211, 211, 0.5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: #000;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(100, 100, 100, 0.1);
        }
        
        .btn-primary {
            background-color: rgb(0, 0, 0);
            border-color: #000000;
        }
        
        .btn-primary:hover {
            background-color: #333333;
            border-color: #333333;
        }
        
        .btn-outline-primary {
            color: #000;
            border-color: #000;
        }
        
        .btn-outline-primary:hover {
            background-color: #000;
            color: #fff;
            border-color: #000;
        }
        
        .image-gallery {
            position: relative;
            height: 400px;
            background-color: #f8f9fa;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .gallery-main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .gallery-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #333;
            font-size: 18px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 10;
            border: none;
        }
        
        .gallery-nav:hover {
            background-color: rgba(255, 255, 255, 1);
        }
        
        .gallery-prev {
            left: 15px;
        }
        
        .gallery-next {
            right: 15px;
        }
        
        .thumbnails {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 0;
        }
        
        .thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.2s;
        }
        
        .thumbnail.active {
            border-color: #000;
        }
        
        .condition-stars {
            color: #ddd;
        }
        
        .condition-stars .filled {
            color: #ffc107;
        }
        
        .phone-price {
            font-size: 28px;
            font-weight: 700;
        }
        
        .phone-condition-text {
            font-weight: 500;
        }
        
        .phone-details {
            white-space: pre-line;
            line-height: 1.6;
        }
        
        .seller-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .seller-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .seller-name {
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .seller-rating {
            color: #ffc107;
        }
        
        .listing-info {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }
        
        .listing-info p {
            margin-bottom: 8px;
        }
        
        .similar-phones {
            margin-top: 40px;
        }
        
        .similar-phone-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            height: 100%;
        }
        
        .similar-phone-card:hover {
            transform: translateY(-5px);
        }
        
        .similar-phone-img {
            height: 150px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        
        .breadcrumb {
            margin-bottom: 20px;
        }
        
        .breadcrumb-item a {
            color: #666;
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: #333;
            font-weight: 500;
        }
        
        .specs-table th {
            width: 40%;
            font-weight: 500;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background-color: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1000;
        }
        
        .back-to-top.visible {
            opacity: 1;
        }
        
        @media (max-width: 767px) {
            .image-gallery {
                height: 300px;
            }
            
            .phone-price {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <?php
    
    include '../php/db.php';

    // Get phone ID from URL
    $phone_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

    if ($phone_id <= 0) {
        // Redirect to home page if no valid ID
        header("Location: home.html");
        exit;
    }

    // Get phone details
    $phone_query = "SELECT p.*, u.name as seller_name, u.profile_picture, u.created_at as user_created_at, u.phone as seller_phone 
                    FROM phones p 
                    LEFT JOIN users u ON p.id = u.user_id 
                    WHERE p.id = $phone_id";
    $phone_result = $conn->query($phone_query);

    if ($phone_result->num_rows == 0) {
        // Phone not found
        header("Location: home.html");
        exit;
    }

    $phone = $phone_result->fetch_assoc();
    
    // Parse image paths from the text field (assuming comma-separated or JSON)
    $images = [];
    if (!empty($phone['image_paths'])) {
        // Try to decode as JSON first
        $decoded = json_decode($phone['image_paths'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $images = $decoded;
        } else {
            // If not JSON, try comma-separated
            $images = explode(',', $phone['image_paths']);
        }
    }
    
    // If no images, use a placeholder
    if (empty($images)) {
        $images[] = '../uploads/none.jpg';
    }

    // Get similar phones (same price range)
    $similar_query = "SELECT p.*, 
                      (SELECT SUBSTRING_INDEX(image_paths, ',', 1) FROM phones WHERE id = p.id) as first_image 
                      FROM phones p 
                      WHERE (p.phone_name LIKE '%" . $conn->real_escape_string(explode(' ', $phone['phone_name'])[0]) . "%' 
                      OR (p.phone_price BETWEEN " . ($phone['phone_price'] * 0.8) . " AND " . ($phone['phone_price'] * 1.2) . ")) 
                      AND p.id != $phone_id 
                      LIMIT 4";
    $similar_result = $conn->query($similar_query);
    $similar_phones = [];

    if ($similar_result && $similar_result->num_rows > 0) {
        while ($similar = $similar_result->fetch_assoc()) {
            $similar_phones[] = $similar;
        }
    }

    // Function to calculate time ago
    function time_elapsed_string($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        
        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        }
        if ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        }
        if ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        }
        if ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        }
        if ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        }
        return 'just now';
    }

    // Get condition text based on rating
    function getConditionText($condition) {
        if ($condition >= 9) return "Like New";
        if ($condition >= 7) return "Excellent";
        if ($condition >= 5) return "Good";
        if ($condition >= 3) return "Fair";
        return "Poor";
    }

    // Update view count
    $update_views = "UPDATE phones SET views = views + 1 WHERE id = $phone_id";
    $conn->query($update_views);
    ?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Phone Marketplace</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sell-phone.html">Sell Phone</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="sell-phone.html" class="btn btn-outline-light">+ Sell Your Phone</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Phones</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($phone['phone_name']); ?></li>
            </ol>
        </nav>

        <div class="row">
            <!-- Left Column - Images -->
            <div class="col-lg-7 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="image-gallery">
                            <img src="<?php echo htmlspecialchars($images[0]); ?>" id="mainImage" class="gallery-main-image" alt="<?php echo htmlspecialchars($phone['phone_name']); ?>">
                            <?php if (count($images) > 1): ?>
                                <button class="gallery-nav gallery-prev" onclick="changeImage('prev')">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="gallery-nav gallery-next" onclick="changeImage('next')">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (count($images) > 0): ?>
                            <div class="thumbnails">
                                <?php foreach ($images as $index => $img): ?>
                                    <img src="<?php echo htmlspecialchars($img); ?>" 
                                         class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" 
                                         onclick="setMainImage(this, <?php echo $index; ?>)" 
                                         alt="<?php echo htmlspecialchars($phone['phone_name']) . ' - Image ' . ($index + 1); ?>">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Details -->
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <h1 class="mb-3"><?php echo htmlspecialchars($phone['phone_name']); ?></h1>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="phone-price">$<?php echo number_format($phone['phone_price'], 2); ?></div>
                            <span class="badge bg-success">Available</span>
                        </div>
                        
                        <div class="mb-4">
                            <div class="condition-stars mb-2">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <i class="fas fa-star <?php echo ($i <= $phone['phone_condition']) ? 'filled' : ''; ?>"></i>
                                <?php endfor; ?>
                                <span class="ms-2"><?php echo $phone['phone_condition']; ?>/10</span>
                            </div>
                            <p class="phone-condition-text">Condition: <strong><?php echo getConditionText($phone['phone_condition']); ?></strong></p>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p class="phone-details"><?php echo nl2br(htmlspecialchars($phone['phone_details'] ?? '')); ?></p>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Contact Seller</h5>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary">
                                    <i class="fas fa-comment-alt me-2"></i>Message Seller
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-phone-alt me-2"></i>Show Phone Number
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Seller Information</h5>
                        <div class="seller-info">
                            <?php if (!empty($phone['profile_picture'])): ?>
                                <img src="<?php echo htmlspecialchars($phone['profile_picture']); ?>" class="seller-avatar" alt="Seller">
                            <?php else: ?>
                                <img src="placeholder-user.jpg" class="seller-avatar" alt="Seller">
                            <?php endif; ?>
                            <div>
                                <h6 class="seller-name"><?php echo htmlspecialchars($phone['seller_name'] ?? 'Anonymous'); ?></h6>
                                <small class="text-muted">Member since <?php echo !empty($phone['user_created_at']) ? date('F Y', strtotime($phone['user_created_at'])) : 'N/A'; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Listing Details</h5>
                        <div class="listing-info">
                            <p><i class="far fa-calendar-alt me-2"></i>Listed: <strong><?php echo date('F j, Y', strtotime($phone['created_at'])); ?></strong></p>
                            <p><i class="fas fa-eye me-2"></i>Views: <strong><?php echo $phone['views'] ?? 0; ?></strong></p>
                            <p><i class="fas fa-tag me-2"></i>Category: <strong>Smartphones</strong></p>
                            <p><i class="fas fa-info-circle me-2"></i>Listing ID: <strong>#<?php echo $phone['id']; ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Specifications -->
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="mb-4">Phone Specifications</h4>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table specs-table">
                            <tbody>
                                <?php
                                // Extract brand from phone name (first word usually)
                                $brand = explode(' ', $phone['phone_name'])[0];
                                
                                // Basic specs we can show
                                $specs = [
                                    'Brand' => $brand,
                                    'Model' => $phone['phone_name'],
                                    'Price' => '$' . number_format($phone['phone_price'], 2),
                                    'Condition' => $phone['phone_condition'] . '/10 - ' . getConditionText($phone['phone_condition'])
                                ];
                                
                                // Display first half of specs
                                $half = ceil(count($specs) / 2);
                                $i = 0;
                                
                                foreach ($specs as $key => $value) {
                                    if ($i < $half) {
                                        echo '<tr>
                                                <th>' . htmlspecialchars($key) . '</th>
                                                <td>' . htmlspecialchars($value) . '</td>
                                              </tr>';
                                    }
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table specs-table">
                            <tbody>
                                <?php
                                // Display second half of specs
                                $i = 0;
                                
                                foreach ($specs as $key => $value) {
                                    if ($i >= $half) {
                                        echo '<tr>
                                                <th>' . htmlspecialchars($key) . '</th>
                                                <td>' . htmlspecialchars($value) . '</td>
                                              </tr>';
                                    }
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Similar Phones -->
        <?php if (!empty($similar_phones)): ?>
            <div class="similar-phones">
                <h4 class="mb-4">Similar Phones</h4>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <?php foreach ($similar_phones as $similar): ?>
                        <div class="col">
                            <a href="phoneDetail.php?id=<?php echo $similar['id']; ?>" class="text-decoration-none">
                                <div class="card similar-phone-card">
                                    <?php 
                                    $similar_image = 'placeholder.jpg';
                                    if (!empty($similar['first_image'])) {
                                        $similar_image = trim($similar['first_image']);
                                    } elseif (!empty($similar['image_paths'])) {
                                        // Try to get the first image from image_paths
                                        $img_paths = explode(',', $similar['image_paths']);
                                        if (!empty($img_paths[0])) {
                                            $similar_image = trim($img_paths[0]);
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo htmlspecialchars($similar_image); ?>" class="similar-phone-img" alt="<?php echo htmlspecialchars($similar['phone_name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark"><?php echo htmlspecialchars($similar['phone_name']); ?></h5>
                                        <p class="card-text text-primary fw-bold">$<?php echo number_format($similar['phone_price'], 2); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="condition-stars">
                                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                                    <i class="fas fa-star <?php echo ($i <= $similar['phone_condition']) ? 'filled' : ''; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <span><?php echo $similar['phone_condition']; ?>/10</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5>Phone Marketplace</h5>
                    <p class="text-muted">The best place to buy and sell used phones.</p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">Home</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Browse</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Sell</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Account</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h6>Help & Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted">FAQ</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Contact Us</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Terms of Service</a></li>
                        <li><a href="#" class="text-decoration-none text-muted">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Connect With Us</h6>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-decoration-none text-muted fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-decoration-none text-muted fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-decoration-none text-muted fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-decoration-none text-muted fs-5"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-muted">
                <small>&copy; <?php echo date('Y'); ?> Phone Marketplace. All rights reserved.</small>
            </div>
        </div>
    </footer>
    
    <!-- Back to top button -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Store images array for gallery
        const images = <?php echo json_encode($images); ?>;
        let currentImageIndex = 0;
        
        function setMainImage(thumbnail, index) {
            // Update main image
            document.getElementById('mainImage').src = images[index];
            
            // Update active thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
            
            // Update current index
            currentImageIndex = index;
        }
        
        function changeImage(direction) {
            if (images.length <= 1) return;
            
            let newIndex;
            
            if (direction === 'next') {
                newIndex = (currentImageIndex + 1) % images.length;
            } else {
                newIndex = (currentImageIndex - 1 + images.length) % images.length;
            }
            
            // Update main image
            document.getElementById('mainImage').src = images[newIndex];
            
            // Update active thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails.forEach((thumb, idx) => {
                if (idx === newIndex) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
            
            // Update current index
            currentImageIndex = newIndex;
        }
        
        // Back to top button functionality
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>