document.addEventListener('DOMContentLoaded', function() {
    // Fetch phones from the database
    fetchPhones();
    
    // Search functionality
    const searchButton = document.getElementById('searchButton');
    const searchInput = document.getElementById('searchInput');
    
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', function() {
            const searchTerm = searchInput.value.trim();
            if (searchTerm) {
                fetchPhones(searchTerm);
            }
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    fetchPhones(searchTerm);
                }
            }
        });
    }
    
    // Sort functionality
    const sortLinks = document.querySelectorAll('[data-sort]');
    sortLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sortBy = this.getAttribute('data-sort');
            document.getElementById('sortDropdown').textContent = this.textContent;
            fetchPhones(null, sortBy);
        });
    });
    
    // Filter button functionality
    const filterButton = document.getElementById('filterButton');
    const filterModalElement = document.getElementById('filterModal');
    const filterModal = filterModalElement ? new bootstrap.Modal(filterModalElement, {
        keyboard: false
    }) : null;
    
    if (filterButton && filterModal) {
        filterButton.addEventListener('click', function() {
            filterModal.show();
        });
    }
    
    // Apply filters button
    const applyFiltersBtn = document.getElementById('applyFilters');
    if (applyFiltersBtn && filterModal) {
        applyFiltersBtn.addEventListener('click', function() {
            const filters = getSelectedFilters();
            fetchPhones(null, null, filters);
            filterModal.hide();
        });
    }
    
    // Clear filters button
    const clearFiltersBtn = document.getElementById('clearFilters');
    if (clearFiltersBtn && filterModal) {
        clearFiltersBtn.addEventListener('click', function() {
            clearFilters();
            fetchPhones();
            filterModal.hide();
        });
    }
});

function fetchPhones(searchTerm = null, sortBy = null, filters = null) {
    // Show loading state
    const phoneContainer = document.getElementById('phone-container');
    phoneContainer.innerHTML = `
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading phones...</p>
        </div>
    `;
    
    // Build query parameters
    let url = '../php/fetchDataPhone.php';
    const params = new URLSearchParams();
    
    if (searchTerm) {
        params.append('search', searchTerm);
    }
    
    if (sortBy) {
        params.append('sort', sortBy);
    }
    
    if (filters) {
        for (const key in filters) {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(value => {
                    params.append(`${key}[]`, value);
                });
            } else {
                params.append(key, filters[key]);
            }
        }
    }
    
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    console.log("Fetching phones from URL:", url);
    
    // Fetch phones from the server
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(phones => {
            console.log("Fetched phones:", phones);
            displayPhones(phones);
        })
        .catch(error => {
            console.error('Error fetching phones:', error);
            phoneContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Error loading phones. Please try again later.
                    </div>
                </div>
            `;
        });
}

function displayPhones(phones) {
    const phoneContainer = document.getElementById('phone-container');
    
    // Clear previous content
    phoneContainer.innerHTML = '';
    
    if (phones.length === 0) {
        phoneContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    No phones found matching your criteria.
                </div>
            </div>
        `;
        return;
    }
    
    // Display each phone
    phones.forEach(phone => {
        // Get condition text based on condition value
        let conditionText = 'Unknown';
        let conditionClass = 'bg-secondary';
        
        if (phone.condition) {
            const condition = parseInt(phone.condition);
            if (condition >= 9) {
                conditionText = 'Like New';
                conditionClass = 'bg-success';
            } else if (condition >= 7) {
                conditionText = 'Excellent';
                conditionClass = 'bg-info';
            } else if (condition >= 5) {
                conditionText = 'Good';
                conditionClass = 'bg-primary';
            } else if (condition >= 3) {
                conditionText = 'Fair';
                conditionClass = 'bg-warning';
            } else {
                conditionText = 'Poor';
                conditionClass = 'bg-danger';
            }
        }
        
        // Debug image path
        console.log(`Phone ${phone.id} image path:`, phone.image);
        
        // Use default image if none provided
        const imagePath = phone.image && phone.image.trim() !== '' 
            ? `../uploads/${phone.image}` 
            : '../uploads/none.jpg';
            
        console.log(`Phone ${phone.id} final image path:`, imagePath);
        
        // Create phone card
        const phoneCard = document.createElement('div');
        phoneCard.className = 'col-sm-6 col-md-4 col-lg-3 mb-4';
        phoneCard.innerHTML = `
            <div class="phone-card">
                <div class="phone-image-container">
                    <img src="${imagePath}" alt="${phone.name}" class="phone-image" onerror="this.onerror=null;this.src='../uploads/none.jpg';">
                    ${phone.condition ? `<span class="phone-condition ${conditionClass}">${conditionText}</span>` : ''}
                </div>
                <div class="phone-details">
                    <h3 class="phone-name">${phone.name}</h3>
                    <div class="phone-price">$${parseFloat(phone.price).toFixed(2)}</div>
                    <div class="phone-meta">
                        <span><i class="far fa-clock me-1"></i>${formatDate(phone.created_at || new Date())}</span>
                        <span><i class="far fa-eye me-1"></i>${phone.views || 0} views</span>
                    </div>
                </div>
            </div>
        `;
        
        // Add click event to redirect to phone detail page
        phoneCard.addEventListener('click', function() {
            window.location.href = `phoneDetail.php?id=${phone.id}`;
        });
        
        phoneContainer.appendChild(phoneCard);
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    
    if (diffDays === 0) {
        return 'Today';
    } else if (diffDays === 1) {
        return 'Yesterday';
    } else if (diffDays < 7) {
        return `${diffDays} days ago`;
    } else if (diffDays < 30) {
        const weeks = Math.floor(diffDays / 7);
        return `${weeks} ${weeks === 1 ? 'week' : 'weeks'} ago`;
    } else {
        return date.toLocaleDateString();
    }
}

function getSelectedFilters() {
    const filters = {};
    
    // Price range filters
    const priceRanges = [];
    if (document.getElementById('priceRange1') && document.getElementById('priceRange1').checked) priceRanges.push('0-200');
    if (document.getElementById('priceRange2') && document.getElementById('priceRange2').checked) priceRanges.push('200-500');
    if (document.getElementById('priceRange3') && document.getElementById('priceRange3').checked) priceRanges.push('500-800');
    if (document.getElementById('priceRange4') && document.getElementById('priceRange4').checked) priceRanges.push('800-1200');
    if (document.getElementById('priceRange5') && document.getElementById('priceRange5').checked) priceRanges.push('1200-999999');
    
    if (priceRanges.length > 0) {
        filters.price_range = priceRanges;
    }
    
    // Brand filters
    const brands = [];
    if (document.getElementById('brandApple') && document.getElementById('brandApple').checked) brands.push('Apple');
    if (document.getElementById('brandSamsung') && document.getElementById('brandSamsung').checked) brands.push('Samsung');
    if (document.getElementById('brandXiaomi') && document.getElementById('brandXiaomi').checked) brands.push('Xiaomi');
    if (document.getElementById('brandGoogle') && document.getElementById('brandGoogle').checked) brands.push('Google');
    if (document.getElementById('brandOnePlus') && document.getElementById('brandOnePlus').checked) brands.push('OnePlus');
    
    if (brands.length > 0) {
        filters.brands = brands;
    }
    
    // Condition filters
    const conditions = [];
    if (document.getElementById('conditionNew') && document.getElementById('conditionNew').checked) conditions.push('new');
    if (document.getElementById('conditionLikeNew') && document.getElementById('conditionLikeNew').checked) conditions.push('like_new');
    if (document.getElementById('conditionExcellent') && document.getElementById('conditionExcellent').checked) conditions.push('excellent');
    if (document.getElementById('conditionGood') && document.getElementById('conditionGood').checked) conditions.push('good');
    if (document.getElementById('conditionFair') && document.getElementById('conditionFair').checked) conditions.push('fair');
    
    if (conditions.length > 0) {
        filters.conditions = conditions;
    }
    
    // Sort option
    if (document.getElementById('sortPopularity') && document.getElementById('sortPopularity').checked) {
        filters.sort = 'popularity';
    } else if (document.getElementById('sortPriceLow') && document.getElementById('sortPriceLow').checked) {
        filters.sort = 'price_low';
    } else if (document.getElementById('sortPriceHigh') && document.getElementById('sortPriceHigh').checked) {
        filters.sort = 'price_high';
    }
    
    return filters;
}

function clearFilters() {
    // Clear price range checkboxes
    if (document.getElementById('priceRange1')) document.getElementById('priceRange1').checked = false;
    if (document.getElementById('priceRange2')) document.getElementById('priceRange2').checked = false;
    if (document.getElementById('priceRange3')) document.getElementById('priceRange3').checked = false;
    if (document.getElementById('priceRange4')) document.getElementById('priceRange4').checked = false;
    if (document.getElementById('priceRange5')) document.getElementById('priceRange5').checked = false;
    
    // Clear brand checkboxes
    if (document.getElementById('brandApple')) document.getElementById('brandApple').checked = false;
    if (document.getElementById('brandSamsung')) document.getElementById('brandSamsung').checked = false;
    if (document.getElementById('brandXiaomi')) document.getElementById('brandXiaomi').checked = false;
    if (document.getElementById('brandGoogle')) document.getElementById('brandGoogle').checked = false;
    if (document.getElementById('brandOnePlus')) document.getElementById('brandOnePlus').checked = false;
    
    // Clear condition checkboxes
    if (document.getElementById('conditionNew')) document.getElementById('conditionNew').checked = false;
    if (document.getElementById('conditionLikeNew')) document.getElementById('conditionLikeNew').checked = false;
    if (document.getElementById('conditionExcellent')) document.getElementById('conditionExcellent').checked = false;
    if (document.getElementById('conditionGood')) document.getElementById('conditionGood').checked = false;
    if (document.getElementById('conditionFair')) document.getElementById('conditionFair').checked = false;
    
    // Reset sort option
    if (document.getElementById('sortPopularity')) document.getElementById('sortPopularity').checked = true;
}