<?php
$shortCode = $_GET['code'];

include 'config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  // Get the short code from the URL query parameter
  $shortCode = $_GET['code'];
  
  // Prepare the query to select the full URL from the database
  $sql = "SELECT full_url FROM short_urls WHERE short_code = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 's', $shortCode);
  mysqli_stmt_execute($stmt);
  
  // Bind the result
  mysqli_stmt_bind_result($stmt, $fullUrl);
  
  // Fetch the result
  mysqli_stmt_fetch($stmt);
  
  // Close the statement
  mysqli_stmt_close($stmt);
  
  if ($fullUrl) {
    // Update the visit count in the database
    $sqlUpdateCount = "UPDATE short_urls SET visit_count = visit_count + 1 WHERE short_code = ?";
    $stmtUpdateCount = mysqli_prepare($conn, $sqlUpdateCount);
    mysqli_stmt_bind_param($stmtUpdateCount, 's', $shortCode);
    mysqli_stmt_execute($stmtUpdateCount);
  
    // Close the statement
    mysqli_stmt_close($stmtUpdateCount);
  
    // Redirect the user to the full URL
    header("Location: $fullUrl");
    exit();
  } else {
    echo "Short URL not found.";
  }
  
  // Close the connection
  mysqli_close($conn);
  
?>