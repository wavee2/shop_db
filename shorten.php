<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the URL submitted by the user
  $fullUrl = $_POST["url"];

  
  // Generate a short code (you can use a library to create unique short codes)
  $shortCode = substr(md5(uniqid(rand(), true)), 0, 7);

  
  // Save the short URL, full URL, and initial visit count in the database
  $sql = "INSERT INTO short_urls (short_code, full_url, visit_count) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  $visitCount = 0;
  mysqli_stmt_bind_param($stmt, 'ssi', $shortCode, $fullUrl, $visitCount);

  if (mysqli_stmt_execute($stmt)) {
    echo "Short URL: localhost/shopping cart with user login/{$shortCode}";
  } else {
    echo "Error occurred while shortening the URL.";
  }

  // Close the connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  
}
?>
