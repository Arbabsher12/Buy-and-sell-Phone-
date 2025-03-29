// Load navbar and sidebar dynamically
fetch("/navbar.html")
    .then(response => response.text())
    .then(data => {
        document.getElementById("navbar-container").innerHTML = data;
        return fetch("/sidebar.html"); // Load sidebar next
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("sidebar-container").innerHTML = data;
        setTimeout(setupSidebar, 0); // Initialize sidebar after loading
    })
    .catch(error => console.error("Error loading components:", error));

// Sidebar toggle functions
function setupSidebar() {
    const sidebar = document.getElementById("sidebar");
    const showSidebarBtn = document.getElementById("show"); // From navbar.html
    const hideSidebarBtn = document.getElementById("hideSidebar");
    const mainContent = document.querySelector(".main-content");
    const navbar = document.getElementById("navbar-container");

    if (!sidebar || !showSidebarBtn || !hideSidebarBtn) {
        console.error("One or more sidebar elements are missing.");
        return;
    }

    showSidebarBtn.addEventListener("click", () => {
        sidebar.style.transform = "translateX(0)";
        showSidebarBtn.style.display = "none";
        mainContent.style.marginLeft = "250px";
        navbar.style.marginLeft = "250px";
    });

    hideSidebarBtn.addEventListener("click", () => {
        sidebar.style.transform = "translateX(-100%)";
        setTimeout(() => {
            showSidebarBtn.style.display = "block";
            mainContent.style.marginLeft = "0";
            navbar.style.marginLeft = "0";
        }, 300);
    });
}

// Fetch and display phones
document.addEventListener("DOMContentLoaded", function () {
    fetchPhones();
});

function fetchPhones() {
    fetch("../php/fetchDataPhone.php")
        .then(response => response.json())
        .then(phones => {
            console.log("Fetched phones:", phones); // Debugging

            const container = document.getElementById("phone-container");
            container.innerHTML = ""; // Clear previous content

            phones.forEach(phone => {
                const phoneBox = document.createElement("div");
                phoneBox.className = "phone-box";

                // Use 'none.jpg' if the image is missing or empty
                const imagePath = phone.image && phone.image.trim() !== "" 
                    ? `../uploads/${phone.image}` 
                    : "../uploads/none.jpg";

                phoneBox.innerHTML = `
                    <img src="${imagePath}" alt="${phone.name}" class="phone-image" onerror="this.onerror=null;this.src='../uploads/none.jpg';">
                    <h3>${phone.name}</h3>
                    <p>Price: $${phone.price}</p>
                `;

                container.appendChild(phoneBox);
            });
        })
        .catch(error => console.error("Error fetching phones:", error));
}
