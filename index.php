<?php
// Get the requested route
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Define allowed pages
$allowedPages = ['home', 'about', 'contact','login','signup'];

if (in_array($page, $allowedPages)) {
    include "html/$page.html";
} else {
  //  include "pages/404.php"; // Show 404 error page if the page is not found
}
?>
