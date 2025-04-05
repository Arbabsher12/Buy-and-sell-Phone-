<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Your Phone | Phone Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/sellPhone.css">
   
</head>
<body>
    <?php include '../php/db.php';  ?>
    <!-- Navbar (Include your existing navbar here) -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <i class="fas fa-mobile-alt me-2"></i>Phone Marketplace
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="sellYourPhone.html">Sell</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="https://via.placeholder.com/36" alt="Profile" class="profile-pic">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-content">
        <div class="sell-phone-container">
            <h1 class="text-center mb-4">Sell Your Phone</h1>
            <p class="text-center text-muted mb-5">Get the best price for your used phone in just a few simple steps</p>
            
            <!-- Progress Steps -->
            <div class="progress-container">
                <div class="progress-step">
                    <div class="progress-line">
                        <div class="progress-line-fill" id="progressLine"></div>
                    </div>
                    <div class="step active" id="step1">1
                        <div class="step-label">Phone Details</div>
                    </div>
                    <div class="step" id="step2">2
                        <div class="step-label">Upload Photos</div>
                    </div>
                    <div class="step" id="step3">3
                        <div class="step-label">Contact Info</div>
                    </div>
                    <div class="step" id="step4">4
                        <div class="step-label">Review & Submit</div>
                    </div>
                </div>
            </div>
            <?php include '../php/sellPhone.php' ?>
            <form id="sellPhoneForm" action="../php/sellPhone.php" method="POST" enctype="multipart/form-data">
                <!-- Step 1: Phone Details -->
                <div class="form-section" id="phoneDetailsSection">
                    <h3 class="section-title">Phone Details</h3>
                       <div class="mb-3">
                        <label for="brand_id" class="form-label required-field">Brand</label>
                        <select class="form-select" id="brand_id" name="brand_id" required>
                         <option value="" selected disabled>Select Brand</option>
                          <?php foreach ($brands as $brand): ?>
                         <option value="<?php echo $brand['id']; ?>" data-logo="">
                         <?php echo $brand['name']; ?>
                         </option>
                         <?php endforeach; ?>
                         <option value="other">Other</option>
                        </select>

                    </div>
                    
                    <div class="mb-3">
                        <label for="model_id" class="form-label required-field">Phone Model</label>
                        <select class="form-select" id="model_id" name="model_id" required disabled>
                            <option value="" selected disabled>Select Brand First</option>
                        </select>
                        
                        <div class="form-check mt-2" id="customModel" >
                            <input class="form-check-input" type="checkbox" id="customModelCheck">
                            <label class="form-check-label" for="customModelCheck">
                                My model is not listed
                            </label>
                        </div>
                        
                        <div class="custom-model-input" id="customModelInput">
                            <input type="text" class="form-control" id="custom_model" name="custom_model" placeholder="Enter your phone model">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phoneStorage" class="form-label required-field">Storage Capacity</label>
                            <select class="form-select" id="phoneStorage" name="phoneStorage" required>
                                <option value="" selected disabled>Select Storage</option>
                                <option value="16GB">16GB</option>
                                <option value="32GB">32GB</option>
                                <option value="64GB">64GB</option>
                                <option value="128GB">128GB</option>
                                <option value="256GB">256GB</option>
                                <option value="512GB">512GB</option>
                                <option value="1TB">1TB</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phoneColor" class="form-label required-field">Color</label>
                            <input type="text" class="form-control" id="phoneColor" name="phoneColor" placeholder="e.g. Black, White, Gold" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phonePrice" class="form-label required-field">Price ($)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="phonePrice" name="phonePrice" placeholder="Enter your asking price" min="1" step="0.01" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phoneCondition" class="form-label required-field">Condition: <span id="conditionValue">5</span>/10</label>
                        <input type="range" class="form-range" id="phoneCondition" name="phoneCondition" min="1" max="10" step="1" value="5" required>
                        <div class="condition-labels">
                            <span>Poor</span>
                            <span>Fair</span>
                            <span>Good</span>
                            <span>Excellent</span>
                            <span>Like New</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phoneDetails" class="form-label">Additional Details</label>
                        <textarea class="form-control" id="phoneDetails" name="phoneDetails" rows="4" placeholder="Describe your phone's condition, included accessories, reason for selling, etc."></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" id="nextToPhotos">Next: Upload Photos</button>
                    </div>
                </div>
                
                <!-- Step 2: Upload Photos -->
                <div class="form-section" id="uploadPhotosSection" style="display: none;">
                    <h3 class="section-title">Upload Photos</h3>
                    
                    <div class="mb-4">
                        <p class="text-muted">Upload clear photos of your phone from different angles. Include photos of any damage or wear. Maximum 7 photos.</p>
                        
                        <div class="upload-container" id="uploadContainer">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <h5>Drag & Drop Photos Here</h5>
                            <p class="text-muted">or</p>
                            <button type="button" class="btn btn-outline-primary" id="browseButton">Browse Files</button>
                            <input type="file" id="phoneImages" name="phoneImages[]" multiple accept="image/*">
                        </div>
                        
                        <div id="imagePreview" class="mt-4"></div>
                        
                        <div class="text-muted mt-2">
                            <small><i class="fas fa-info-circle me-1"></i> Tip: Include photos of the front, back, sides, and any accessories.</small>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" id="backToDetails">Back</button>
                        <button type="button" class="btn btn-primary" id="nextToContact">Next: Contact Info</button>
                    </div>
                </div>
                
                <!-- Step 3: Contact Information -->
                <div class="form-section" id="contactInfoSection" style="display: none;">
                    <h3 class="section-title">Contact Information</h3>
                    
                    <div class="mb-3">
                        <label for="sellerName" class="form-label required-field">Your Name</label>
                        <input type="text" class="form-control" id="sellerName" name="sellerName" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sellerEmail" class="form-label required-field">Email Address</label>
                        <input type="email" class="form-control" id="sellerEmail" name="sellerEmail" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sellerPhone" class="form-label required-field">Phone Number</label>
                        <input type="tel" class="form-control" id="sellerPhone" name="sellerPhone" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sellerLocation" class="form-label required-field">Location</label>
                        <input type="text" class="form-control" id="sellerLocation" name="sellerLocation" placeholder="City, State" required>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" id="backToPhotos">Back</button>
                        <button type="button" class="btn btn-primary" id="nextToReview">Next: Review</button>
                    </div>
                </div>
                
                <!-- Step 4: Review & Submit -->
                <div class="form-section" id="reviewSection" style="display: none;">
                    <h3 class="section-title">Review Your Listing</h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Phone Details</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Brand:</strong></td>
                                            <td id="reviewBrand"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Model:</strong></td>
                                            <td id="reviewModel"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Storage:</strong></td>
                                            <td id="reviewStorage"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Color:</strong></td>
                                            <td id="reviewColor"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Price:</strong></td>
                                            <td id="reviewPrice"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Condition:</strong></td>
                                            <td id="reviewCondition"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Contact Information</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td id="reviewName"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td id="reviewEmail"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td id="reviewPhone"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Location:</strong></td>
                                            <td id="reviewLocation"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Photos</h5>
                        <div id="reviewPhotos" class="d-flex flex-wrap gap-2"></div>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Additional Details</h5>
                        <p id="reviewDetails" class="p-3 bg-light rounded"></p>
                    </div>
                    
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck">
                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> and confirm that all information provided is accurate.
                        </label>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" id="backToContact">Back</button>
                        <button type="submit" class="btn btn-success" id="submitListing">Submit Listing</button>
                    </div>
                </div>
            </form>
            
            <!-- Success Message (initially hidden) -->
            <div class="alert alert-success text-center p-4" id="successMessage" style="display: none;">
                <i class="fas fa-check-circle fa-3x mb-3"></i>
                <h4>Your listing has been submitted successfully!</h4>
                <p>We'll review your listing and it will be live on our marketplace soon.</p>
                <div class="mt-4">
                    <a href="home.php" class="btn btn-primary me-2">Go to Homepage</a>
                    <a href="sellYourPhone.html" class="btn btn-outline-primary">Sell Another Phone</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Listing Policies</h6>
                    <p>By submitting a listing, you confirm that:</p>
                    <ul>
                        <li>You are the rightful owner of the device or authorized to sell it</li>
                        <li>The information provided is accurate and complete</li>
                        <li>The photos uploaded are of the actual device being sold</li>
                        <li>You will respond to inquiries from potential buyers in a timely manner</li>
                    </ul>
                    
                    <h6>2. Prohibited Items</h6>
                    <p>The following items are prohibited:</p>
                    <ul>
                        <li>Stolen devices</li>
                        <li>Counterfeit or replica devices</li>
                        <li>Devices with illegal modifications</li>
                        <li>Devices with iCloud/Google account locks</li>
                    </ul>
                    
                    <h6>3. Fees and Payments</h6>
                    <p>Our platform charges a 5% fee on successful sales. Payment processing is handled securely through our payment partners.</p>
                    
                    <h6>4. Privacy Policy</h6>
                    <p>Your contact information will be shared with potential buyers. We do not sell your personal data to third parties.</p>
                    
                    <h6>5. Listing Removal</h6>
                    <p>We reserve the right to remove listings that violate our policies or receive multiple complaints from users.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (Include your existing footer here) -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="../js/sellPhone.js"></script>
</body>
</html>

