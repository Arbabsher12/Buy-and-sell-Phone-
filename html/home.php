<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$profile_picture = "none.jpg"; // Default image

if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];

    // Database connection
    include '../php/db.php';

    // Fetch user details
    $query = "SELECT profile_picture FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($profile_picture);
    $stmt->fetch();
    $stmt->close();

    // Set default profile picture if none is found
    if (empty($profile_picture)) {
        $profile_picture = "none.jpg";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Marketplace</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
                   
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-mobile-alt me-2"></i>Phone Marketplace
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Buy
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">New Phones</a></li>
                            <li><a class="dropdown-item" href="#">Used Phones</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">All Phones</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Sell
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="sellNewPhone.html">Sell New Phone</a></li>
                            <li><a class="dropdown-item" href="sellYourPhone.html">Sell Your Phone</a></li>
                        </ul>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <?php if ($isLoggedIn): ?>
                        <div class="dropdown me-3">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile" class="profile-pic me-2">
                                <span class="d-none d-sm-inline text-light">My Account</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="my-listings.php"><i class="fas fa-list me-2"></i>My Listings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Log Out</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary me-2">Log In</a>
                        <a href="signup.php" class="btn btn-success">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-content">
        <!-- Hero Section -->
        <section class="hero-section mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Find Your Perfect Phone</h1>
                    <p class="lead mb-4">Browse thousands of used and new phones at great prices. Buy and sell with confidence on our secure platform.</p>
                    <div class="d-flex gap-3">
                        <a href="#phone-listings" class="btn btn-primary btn-lg">Browse Phones</a>
                        <a href="#" class="btn btn-outline-dark btn-lg">Sell Your Phone</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <img src="../components/home.jpg" alt="Smartphones" class="img-fluid rounded hero-image">
                </div>
            </div>
        </section>

        <!-- Search Section -->
        <section class="search-section mb-5">
            <div class="card">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search for phones by name, brand, or features...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button id="searchButton" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Phone Listings Section -->
        <section id="phone-listings" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title">Available Phones</h2>
                <div class="d-flex gap-2">
                    <!-- Filter Button -->
                    <button id="filterButton" class="btn btn-outline-primary">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    
                    <!-- Sort Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sort me-2"></i>Sort by: Newest
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item" href="#" data-sort="newest">Newest</a></li>
                            <li><a class="dropdown-item" href="#" data-sort="oldest">Oldest</a></li>
                            <li><a class="dropdown-item" href="#" data-sort="price_low">Price: Low to High</a></li>
                            <li><a class="dropdown-item" href="#" data-sort="price_high">Price: High to Low</a></li>
                            <li><a class="dropdown-item" href="#" data-sort="popularity">Popularity</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Phone Grid -->
            <div class="row" id="phone-container">
                <!-- Phone cards will be dynamically inserted here -->
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Loading phones...</p>
                </div>
            </div>
        </section>

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Phones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Price Range Filter -->
                        <div class="filter-section">
                            <h4>Price Range</h4>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="priceRange1">
                                <label class="form-check-label" for="priceRange1">
                                    Under $200
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="priceRange2">
                                <label class="form-check-label" for="priceRange2">
                                    $200 - $500
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="priceRange3">
                                <label class="form-check-label" for="priceRange3">
                                    $500 - $800
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="priceRange4">
                                <label class="form-check-label" for="priceRange4">
                                    $800 - $1200
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="priceRange5">
                                <label class="form-check-label" for="priceRange5">
                                    $1200+
                                </label>
                            </div>
                        </div>
                        
                        <!-- Brand Filter -->
                        <div class="filter-section">
                            <h4>Brand</h4>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brandApple">
                                <label class="form-check-label" for="brandApple">
                                    Apple
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brandSamsung">
                                <label class="form-check-label" for="brandSamsung">
                                    Samsung
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brandXiaomi">
                                <label class="form-check-label" for="brandXiaomi">
                                    Xiaomi
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brandGoogle">
                                <label class="form-check-label" for="brandGoogle">
                                    Google
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="brandOnePlus">
                                <label class="form-check-label" for="brandOnePlus">
                                    OnePlus
                                </label>
                            </div>
                        </div>
                        
                        <!-- Condition Filter -->
                        <div class="filter-section">
                            <h4>Condition</h4>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="conditionNew">
                                <label class="form-check-label" for="conditionNew">
                                    New
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="conditionLikeNew">
                                <label class="form-check-label" for="conditionLikeNew">
                                    Like New
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="conditionExcellent">
                                <label class="form-check-label" for="conditionExcellent">
                                    Excellent
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="conditionGood">
                                <label class="form-check-label" for="conditionGood">
                                    Good
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="conditionFair">
                                <label class="form-check-label" for="conditionFair">
                                    Fair
                                </label>
                            </div>
                        </div>
                        
                        <!-- Sort Options -->
                        <div class="filter-section">
                            <h4>Sort By</h4>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="sortOption" id="sortPopularity" checked>
                                <label class="form-check-label" for="sortPopularity">
                                    Popularity
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="sortOption" id="sortPriceLow">
                                <label class="form-check-label" for="sortPriceLow">
                                    Price: Low to High
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sortOption" id="sortPriceHigh">
                                <label class="form-check-label" for="sortPriceHigh">
                                    Price: High to Low
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="clearFilters">Clear All</button>
                        <button type="button" class="btn btn-primary" id="applyFilters">Apply Filters</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <section class="mb-5">
            <h2 class="section-title mb-4">Popular Categories</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <h3>iPhones</h3>
                        <p>Browse the latest and classic Apple iPhone models at competitive prices.</p>
                        <a href="#" class="btn btn-outline-primary">View iPhones</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fab fa-android"></i>
                        </div>
                        <h3>Android Phones</h3>
                        <p>Explore a wide range of Android smartphones from top manufacturers.</p>
                        <a href="#" class="btn btn-outline-primary">View Android</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <h3>Budget Phones</h3>
                        <p>Find affordable smartphones that offer great value for your money.</p>
                        <a href="#" class="btn btn-outline-primary">View Budget</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="mb-5">
            <h2 class="section-title mb-4">Why Choose Us</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Secure Transactions</h3>
                        <p>Our platform ensures your payments and personal information are always protected.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>Verified Sellers</h3>
                        <p>All sellers on our platform are verified to ensure a safe buying experience.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3>Fast Shipping</h3>
                        <p>Get your purchased phones delivered quickly with our reliable shipping partners.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <h3>Easy Returns</h3>
                        <p>Not satisfied with your purchase? Return it within 7 days for a full refund.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5>Phone Marketplace</h5>
                    <p>The best place to buy and sell phones online. Join our community of phone enthusiasts today!</p>
                    <div class="social-icons d-flex gap-2 mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Browse</a></li>
                        <li><a href="#">Sell</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Categories</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">iPhones</a></li>
                        <li><a href="#">Samsung</a></li>
                        <li><a href="#">Google Pixel</a></li>
                        <li><a href="#">OnePlus</a></li>
                        <li><a href="#">Xiaomi</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to our newsletter for the latest updates and offers.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your Email" aria-label="Your Email">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2023 Phone Marketplace. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#">Terms of Service</a></li>
                        <li class="list-inline-item"><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../js/home.js"></script>
</body>
</html>