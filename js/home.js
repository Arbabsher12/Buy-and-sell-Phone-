 // Load navbar first
 fetch('/navbar.html')
 .then(response => response.text())
 .then(data => {
     document.getElementById('navbar-container').innerHTML = data;
     return fetch('/sidebar.html'); // Load sidebar after navbar
 })
 .then(response => response.text())
 .then(data => {
     document.getElementById('sidebar-container').innerHTML = data;

     // Now that navbar & sidebar are loaded, add event listeners
     setTimeout(setupSidebar, 0);
 })
 .catch(error => console.error('Error loading components:', error));

function setupSidebar() {
 const sidebar = document.getElementById("sidebar");
 const showSidebarBtn = document.getElementById("show"); // Inside navbar.html
 const hideSidebarBtn = document.getElementById("hideSidebar");

 // Debugging: Log elements
 console.log("Sidebar:", sidebar);
 console.log("Show Sidebar Button:", showSidebarBtn);
 console.log("Hide Sidebar Button:", hideSidebarBtn);

 if (!sidebar || !showSidebarBtn || !hideSidebarBtn) {
     console.error("One or more sidebar elements are missing.");
     return;
 }

 // Show Sidebar
 showSidebarBtn.addEventListener("click", () => {
     sidebar.style.transform = "translateX(0)";
     showSidebarBtn.style.display = "none"; // Hide button in navbar
 });

 // Hide Sidebar
 hideSidebarBtn.addEventListener("click", () => {
     sidebar.style.transform = "translateX(-100%)";
     setTimeout(() => {
         showSidebarBtn.style.display = "block"; // Show button in navbar
     }, 300); // Adding delay for smooth transition
 });
}