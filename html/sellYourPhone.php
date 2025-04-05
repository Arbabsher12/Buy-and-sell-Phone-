<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Your Phone | Phone Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .sell-phone-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-section {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-color);
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .upload-container {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .upload-container:hover {
            border-color: var(--primary-color);
        }
        
        .upload-icon {
            font-size: 40px;
            color: #888;
            margin-bottom: 10px;
        }
        
        #imagePreview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
            gap: 15px;
        }
        
        .image-preview-item {
            position: relative;
            width: 100px;
            height: 100px;
        }
        
        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        
        .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #dc3545;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 14px;
        }
        
        .brand-option {
            display: flex;
            align-items: center;
            padding: 8px 12px;
        }
        
        .brand-logo {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            object-fit: contain;
        }
        
        .condition-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .form-floating > .form-control {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
        
        .progress-container {
            margin-bottom: 30px;
        }
        
        .progress-step {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 30px;
        }
        
        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            z-index: 2;
        }
        
        .step.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .step.completed {
            background-color: var(--success-color);
            color: white;
        }
        
        .progress-line {
            position: absolute;
            top: 15px;
            left: 30px;
            right: 30px;
            height: 2px;
            background-color: #e9ecef;
            z-index: 1;
        }
        
        .progress-line-fill {
            height: 100%;
            background-color: var(--success-color);
            width: 0%;
            transition: width 0.3s ease;
        }
        
        .step-label {
            position: absolute;
            top: 35px;
            font-size: 0.8rem;
            transform: translateX(-50%);
            text-align: center;
            width: 100px;
        }
        
        #phoneImages {
            display: none;
        }
        
        .custom-model-input {
            display: none;
            margin-top: 15px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        
        .required-field::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
    </style>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables
            let uploadedFiles = [];
            const maxFiles = 7;
            
            // Elements
            const brandSelect = document.getElementById('brand_id');
            const modelSelect = document.getElementById('model_id');
            const customModelCheck = document.getElementById('customModelCheck');
            const customModelInput = document.getElementById('customModelInput');
            const conditionSlider = document.getElementById('phoneCondition');
            const conditionValue = document.getElementById('conditionValue');
            const uploadContainer = document.getElementById('uploadContainer');
            const phoneImagesInput = document.getElementById('phoneImages');
            const browseButton = document.getElementById('browseButton');
            const imagePreview = document.getElementById('imagePreview');
            const CheckboxDiv = document.getElementById('customModel');
            
            // Navigation buttons
            const nextToPhotosBtn = document.getElementById('nextToPhotos');
            const backToDetailsBtn = document.getElementById('backToDetails');
            const nextToContactBtn = document.getElementById('nextToContact');
            const backToPhotosBtn = document.getElementById('backToPhotos');
            const nextToReviewBtn = document.getElementById('nextToReview');
            const backToContactBtn = document.getElementById('backToContact');
            const submitListingBtn = document.getElementById('submitListing');
            
            // Sections
            const phoneDetailsSection = document.getElementById('phoneDetailsSection');
            const uploadPhotosSection = document.getElementById('uploadPhotosSection');
            const contactInfoSection = document.getElementById('contactInfoSection');
            const reviewSection = document.getElementById('reviewSection');
            const successMessage = document.getElementById('successMessage');
            
            // Progress steps
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');
            const step4 = document.getElementById('step4');
            const progressLine = document.getElementById('progressLine');
            
            // Update condition value display
            conditionSlider.addEventListener('input', function() {
                conditionValue.textContent = this.value;
            });
            
            // Brand selection changes
            brandSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    modelSelect.disabled = true;
                    customModelCheck.checked = true;
                    customModelInput.style.display = 'block';
                    document.getElementById('custom_model').required = true;
                    modelSelect.required = false;
                } else {
                    // Fetch models for the selected brand
                    fetchModels(this.value);
                    modelSelect.disabled = false;
                    customModelInput.style.display = 'none';
                    customModelCheck.checked = false;
                    
                    if (!customModelCheck.checked) {
                        modelSelect.required = true;
                        document.getElementById('custom_model').required = false;
                    }
                }
            });
            
            // Custom model checkbox
            customModelCheck.addEventListener('change', function() {
                if (this.checked) {
                    customModelInput.style.display = 'block';
                    document.getElementById('custom_model').required = true;
                    modelSelect.required = false;
                } else {
                    customModelInput.style.display = 'none';
                    document.getElementById('custom_model').required = false;
                    if (brandSelect.value !== 'other') {
                        modelSelect.required = true;
                    }
                }
            });
            
            // Fetch models for a brand
            function fetchModels(brandId) {
                modelSelect.innerHTML = '<option value="" selected disabled>Loading models...</option>';
                
                fetch(`../php/sellPhone.php?action=getModels&brand_id=${brandId}`)
                    .then(response => response.json())
                    .then(data => {
                        modelSelect.innerHTML = '<option value="" selected disabled>Select Model</option>';
                        
                        data.forEach(model => {
                            const option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.model_name;
                            modelSelect.appendChild(option);
                        });
                        
                        if (data.length === 0) {
                            modelSelect.innerHTML = '<option value="" selected disabled>No models found</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching models:', error);
                        modelSelect.innerHTML = '<option value="" selected disabled>Error loading models</option>';
                    });
            }

            modelSelect.addEventListener("change", function () {
              if ( modelSelect.value ) {
              customModel.style.display = "none";
              }     
              else {
            // Show checkbox again if no brand selected
            customModel.style.display = "block";
        }
       
    });
            
            // Image upload handling
            browseButton.addEventListener('click', function() {
                phoneImagesInput.click();
            });
            
            // Drag and drop functionality
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-primary');
            });
            
            uploadContainer.addEventListener('dragleave', function() {
                this.classList.remove('border-primary');
            });
            
            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');
                
                if (e.dataTransfer.files.length > 0) {
                    handleFiles(e.dataTransfer.files);
                }
            });
            
            phoneImagesInput.addEventListener('change', function() {
                handleFiles(this.files);
            });
            
            function handleFiles(files) {
                const newFiles = Array.from(files);
                
                // Check if adding these files would exceed the limit
                if (uploadedFiles.length + newFiles.length > maxFiles) {
                    alert(`You can upload a maximum of ${maxFiles} images. You've selected ${uploadedFiles.length + newFiles.length} images.`);
                    return;
                }
                
                newFiles.forEach(file => {
                    // Check if file is an image
                    if (!file.type.match('image.*')) {
                        alert('Please upload only image files.');
                        return;
                    }
                    
                    // Check if file is already in the list
                    const isDuplicate = uploadedFiles.some(f => 
                        f.name === file.name && 
                        f.size === file.size && 
                        f.lastModified === file.lastModified
                    );
                    
                    if (!isDuplicate) {
                        uploadedFiles.push(file);
                        displayImage(file);
                    }
                });
                
                updateFileInput();
            }
            
            function displayImage(file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'image-preview-item';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    
                    const removeBtn = document.createElement('span');
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', function() {
                        uploadedFiles = uploadedFiles.filter(f => f !== file);
                        previewItem.remove();
                        updateFileInput();
                    });
                    
                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    imagePreview.appendChild(previewItem);
                };
                
                reader.readAsDataURL(file);
            }
            
            function updateFileInput() {
                const dataTransfer = new DataTransfer();
                uploadedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                phoneImagesInput.files = dataTransfer.files;
            }
            
            // Navigation between steps
            nextToPhotosBtn.addEventListener('click', function() {
                if (validatePhoneDetails()) {
                    phoneDetailsSection.style.display = 'none';
                    uploadPhotosSection.style.display = 'block';
                    updateProgress(2);
                }
            });
            
            backToDetailsBtn.addEventListener('click', function() {
                uploadPhotosSection.style.display = 'none';
                phoneDetailsSection.style.display = 'block';
                updateProgress(1);
            });
            
            nextToContactBtn.addEventListener('click', function() {
                if (validatePhotos()) {
                    uploadPhotosSection.style.display = 'none';
                    contactInfoSection.style.display = 'block';
                    updateProgress(3);
                }
            });
            
            backToPhotosBtn.addEventListener('click', function() {
                contactInfoSection.style.display = 'none';
                uploadPhotosSection.style.display = 'block';
                updateProgress(2);
            });
            
            nextToReviewBtn.addEventListener('click', function() {
                if (validateContactInfo()) {
                    contactInfoSection.style.display = 'none';
                    populateReviewSection();
                    reviewSection.style.display = 'block';
                    updateProgress(4);
                }
            });
            
            backToContactBtn.addEventListener('click', function() {
                reviewSection.style.display = 'none';
                contactInfoSection.style.display = 'block';
                updateProgress(3);
            });
            // Validation functions
            function validatePhoneDetails() {
                const form = document.getElementById('sellPhoneForm');
                
                // Check brand
                if (!brandSelect.value) {
                    alert('Please select a brand.');
                    brandSelect.focus();
                    return false;
                }
                
                // Check model or custom model
                if (customModelCheck.checked) {
                    if (!document.getElementById('custom_model').value.trim()) {
                        alert('Please enter your phone model.');
                        document.getElementById('custom_model').focus();
                        return false;
                    }
                } else if (brandSelect.value !== 'other' && !modelSelect.value) {
                    alert('Please select a phone model.');
                    modelSelect.focus();
                    return false;
                }
                
                // Check storage
                if (!document.getElementById('phoneStorage').value) {
                    alert('Please select storage capacity.');
                    document.getElementById('phoneStorage').focus();
                    return false;
                }
                
                // Check color
                if (!document.getElementById('phoneColor').value.trim()) {
                    alert('Please enter the phone color.');
                    document.getElementById('phoneColor').focus();
                    return false;
                }
                
                // Check price
                if (!document.getElementById('phonePrice').value || document.getElementById('phonePrice').value <= 0) {
                    alert('Please enter a valid price.');
                    document.getElementById('phonePrice').focus();
                    return false;
                }
                
                return true;
            }
            
            function validatePhotos() {
                if (uploadedFiles.length === 0) {
                    alert('Please upload at least one photo of your phone.');
                    return false;
                }
                
                return true;
            }
            
            function validateContactInfo() {
                // Check name
                if (!document.getElementById('sellerName').value.trim()) {
                    alert('Please enter your name.');
                    document.getElementById('sellerName').focus();
                    return false;
                }
                
                // Check email
                const email = document.getElementById('sellerEmail').value.trim();
                if (!email || !/^\S+@\S+\.\S+$/.test(email)) {
                    alert('Please enter a valid email address.');
                    document.getElementById('sellerEmail').focus();
                    return false;
                }
                
                // Check phone
                if (!document.getElementById('sellerPhone').value.trim()) {
                    alert('Please enter your phone number.');
                    document.getElementById('sellerPhone').focus();
                    return false;
                }
                
                // Check location
                if (!document.getElementById('sellerLocation').value.trim()) {
                    alert('Please enter your location.');
                    document.getElementById('sellerLocation').focus();
                    return false;
                }
                
                return true;
            }
            
            // Update progress indicator
            function updateProgress(step) {
                // Reset all steps
                [step1, step2, step3, step4].forEach(s => {
                    s.classList.remove('active', 'completed');
                });
                
                // Set active step
                if (step >= 1) step1.classList.add(step > 1 ? 'completed' : 'active');
                if (step >= 2) step2.classList.add(step > 2 ? 'completed' : 'active');
                if (step >= 3) step3.classList.add(step > 3 ? 'completed' : 'active');
                if (step >= 4) step4.classList.add('active');
                
                // Update progress line
                const progressPercentage = (step - 1) * 33.33;
                progressLine.style.width = `${progressPercentage}%`;
            }
            
            // Populate review section
            function populateReviewSection() {
                // Get brand name
                const brandText = brandSelect.options[brandSelect.selectedIndex].text;
                document.getElementById('reviewBrand').textContent = brandText;
                
                // Get model name
                let modelText = '';
                if (customModelCheck.checked) {
                    modelText = document.getElementById('custom_model').value;
                } else if (modelSelect.selectedIndex > 0) {
                    modelText = modelSelect.options[modelSelect.selectedIndex].text;
                }
                document.getElementById('reviewModel').textContent = modelText;
                
                // Other details
                document.getElementById('reviewStorage').textContent = document.getElementById('phoneStorage').value;
                document.getElementById('reviewColor').textContent = document.getElementById('phoneColor').value;
                document.getElementById('reviewPrice').textContent = '$' + parseFloat(document.getElementById('phonePrice').value).toFixed(2);
                
                const conditionVal = document.getElementById('phoneCondition').value;
                let conditionText = '';
                if (conditionVal >= 9) conditionText = 'Like New (10/10)';
                else if (conditionVal >= 7) conditionText = 'Excellent (' + conditionVal + '/10)';
                else if (conditionVal >= 5) conditionText = 'Good (' + conditionVal + '/10)';
                else if (conditionVal >= 3) conditionText = 'Fair (' + conditionVal + '/10)';
                else conditionText = 'Poor (' + conditionVal + '/10)';
                
                document.getElementById('reviewCondition').textContent = conditionText;
                
                // Contact info
                document.getElementById('reviewName').textContent = document.getElementById('sellerName').value;
                document.getElementById('reviewEmail').textContent = document.getElementById('sellerEmail').value;
                document.getElementById('reviewPhone').textContent = document.getElementById('sellerPhone').value;
                document.getElementById('reviewLocation').textContent = document.getElementById('sellerLocation').value;
                
                // Details
                const details = document.getElementById('phoneDetails').value.trim();
                document.getElementById('reviewDetails').textContent = details || 'No additional details provided.';
                
                // Photos
                const reviewPhotos = document.getElementById('reviewPhotos');
                reviewPhotos.innerHTML = '';
                
                if (uploadedFiles.length > 0) {
                    uploadedFiles.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Phone photo';
                            img.style.width = '80px';
                            img.style.height = '80px';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '4px';
                            reviewPhotos.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    reviewPhotos.innerHTML = '<p class="text-muted">No photos uploaded.</p>';
                }
            }
            
            // Form submission
            document.getElementById('sellPhoneForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!document.getElementById('termsCheck').checked) {
                    alert('Please agree to the Terms and Conditions to proceed.');
                    return;
                }
           
                
                const formData = new FormData(this);
                
                // Show loading state
                submitListingBtn.disabled = true;
                submitListingBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Submitting...';
                
                fetch('../php/sellPhone.php', {
                    method: 'POST',
                    body: formData
                    
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        reviewSection.style.display = 'none';
                        successMessage.style.display = 'block';
                    } else {
                        alert('Error: ' + data.message);
                        submitListingBtn.disabled = false;
                        submitListingBtn.innerHTML = 'Submit Listing';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while submitting your listing. Please try again.');
                    submitListingBtn.disabled = false;
                    submitListingBtn.innerHTML = 'Submit Listing';
                });
            });
                 
        });
    </script>
</body>
</html>

