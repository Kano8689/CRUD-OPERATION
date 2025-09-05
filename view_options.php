<?php
include_once("DB.php"); // connection file

$table = "students";
$columns = [];

// Query for column names
$sql = "SHOW COLUMNS FROM $table";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field']; // Column name
    }
}

// Handle back button
if(isset($_POST['back'])){
    header("location: index.php");
    exit;
}

// Handle submit button and selected fields
$selectedFields = [];
if(isset($_POST['submit']) && !empty($_POST['fields'])){
    $_SESSION['selectedFields'] = $_POST['fields']; // Store array in session
    header("location: show_records.php"); // redirect to next page
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Columns</title>
  <link rel="stylesheet" href="view_options.css">
</head>
<body>
  <div class="box">
    <h2>📋 Choose Fields</h2>
    <form method="post" action="">
      <div class="checkbox-list">
        <?php foreach ($columns as $col): ?>
          <label>
            <input type="checkbox" name="fields[]" value="<?= $col ?>"
            <?php 
              // Default checked or preserve selection
              if (!empty($selectedFields)) {
                  echo in_array($col, $selectedFields) ? 'checked' : '';
              } else {
                  echo 'checked';
              }
            ?>> <?= ucfirst($col) ?>
          </label>
        <?php endforeach; ?>
      </div>
      <div class="actions">
        <button type="submit" name="submit">Submit</button>
        <button class="backB" name="back">Back</button>
      </div>
    </form>

    <!-- <?php
    // Display selected fields
    if(!empty($selectedFields)){
        echo "<h3>✅ You selected:</h3><ul>";
        foreach($selectedFields as $field){
            echo "<li>" . htmlspecialchars($field) . "</li>";
        }
        echo "</ul>";
    }
    ?> -->
  </div>
</body>
</html>
