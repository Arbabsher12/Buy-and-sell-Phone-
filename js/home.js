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

    if (!sidebar || !showSidebarBtn || !hideSidebarBtn) {
        console.error("One or more sidebar elements are missing.");
        return;
    }

    showSidebarBtn.addEventListener("click", () => {
        sidebar.style.transform = "translateX(0)";
        showSidebarBtn.style.display = "none";
    });

    hideSidebarBtn.addEventListener("click", () => {
        sidebar.style.transform = "translateX(-100%)";
        setTimeout(() => {
            showSidebarBtn.style.display = "block";
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

                phoneBox.innerHTML = `
                    <img src="../uploads/${phone.image}" alt="${phone.name}" class="phone-image">
                    <h3>${phone.name}</h3>
                    <p>Price: $${phone.price}</p>
                `;

                container.appendChild(phoneBox);
            });
        })
        .catch(error => console.error("Error fetching phones:", error));
}
