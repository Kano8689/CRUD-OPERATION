<?php
include "DB.php";

// make mysqli throw exceptions so we can catch them
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$isUpdate = false;

//Update Part
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    // echo "string";
    // Condition to handle id error
    if($id>0){
      // echo "id = $id";
      // exit();
    
      $isUpdate = true;      

      $sql = "SELECT * FROM students WHERE id = $id";
      $result = mysqli_query($conn, $sql);

      if($result && mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_assoc($result);
      }
    }
}

//Insert Part
if(isset($_POST['submit'])) {
    $name        = $_POST['name'];
    $enroll_no   = $_POST['enroll_no'];
    $degree      = $_POST['degree'];
    $prev_degree = $_POST['prev_degree'];
    $prev_clg    = $_POST['prev_clg'];
    $mo_no       = $_POST['mo_no'];
    $hostel      = isset($_POST['hostel']) ? 1 : 0;

    $sql = "INSERT INTO students (name, enroll_no, degree, prev_degree, prev_clg, mo_no, hostel) 
            VALUES ('$name', '$enroll_no', '$degree', '$prev_degree', '$prev_clg', '$mo_no', '$hostel')";

    try {
        if ($conn->query($sql) === TRUE) {
            $success = "✅ Data inserted successfully!";
            header('location: get_all_fields.php');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate enroll_no
            $error_enroll = "⚠️ This Enroll No is already registered.";
        } else {
            $error = "❌ Error: " . $e->getMessage();
        }
    }
}

//Update Part
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $enroll_no = $_POST['enroll_no'];
    $degree = $_POST['degree'];
    $prev_degree = $_POST['prev_degree'];
    $prev_clg = $_POST['prev_clg'];
    $mo_no = $_POST['mo_no'];
    $hostel = isset($_POST['hostel']) ? 1 : 0;

    $update_sql = "UPDATE $tablename SET 
        name='$name', 
        enroll_no='$enroll_no', 
        degree='$degree', 
        prev_degree='$prev_degree', 
        prev_clg='$prev_clg', 
        mo_no='$mo_no', 
        hostel='$hostel' 
        WHERE id=$id";

    if(mysqli_query($conn, $update_sql)){
        header("Location: show_records.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<?php if($isUpdate){?>
  <title>Student Details Update</title>
<?php }else{?>
  <title>Student Registration Form</title>
<?php } ?>
<link rel="stylesheet" href="registration_form.css">
</head>
<body>
<div class="card">
<?php if($isUpdate){?>
  <h1>Student Details Update</h1>
<?php }else{?>
  <h1>Student Registration Form</h1>
<?php } ?>

  <form method="POST" action="">
  <!-- Hidden input for ID -->
  <input type="hidden" name="id" value="<?= isset($row['id']) ? $row['id'] : -999; ?>">

  <div class="form-group">
    <i>👤</i>
    <input type="text" name="name" 
           value="<?php echo isset($row['name']) ? htmlspecialchars($row['name']) : ''; ?>" 
           placeholder=" " required>
    <label>Name</label>
  </div>

  <div class="form-group">
    <i>🆔</i>
    <input type="text" name="enroll_no" 
           value="<?php echo isset($row['enroll_no']) ? htmlspecialchars($row['enroll_no']) : ''; ?>" 
           placeholder=" " required>
    <label>Enroll No</label>
    <?php if(isset($error_enroll)) { ?>
        <small style="color:red;"><?php echo $error_enroll; ?></small>
    <?php } ?>
  </div>

  <div class="form-group">
    <i>🎓</i>
    <input type="text" name="degree" 
           value="<?php echo isset($row['degree']) ? htmlspecialchars($row['degree']) : ''; ?>" 
           placeholder=" " required>
    <label>Degree</label>
  </div>

  <div class="form-group">
    <i>📜</i>
    <input type="text" name="prev_degree" 
           value="<?php echo isset($row['prev_degree']) ? htmlspecialchars($row['prev_degree']) : ''; ?>" 
           placeholder=" " required>
    <label>Previous Degree</label>
  </div>

  <div class="form-group">
    <i>🏫</i>
    <input type="text" name="prev_clg" 
           value="<?php echo isset($row['prev_clg']) ? htmlspecialchars($row['prev_clg']) : ''; ?>" 
           placeholder=" " required>
    <label>Previous School</label>
  </div>

  <div class="form-group">
    <i>📞</i>
    <input type="text" name="mo_no" 
           value="<?php echo isset($row['mo_no']) ? htmlspecialchars($row['mo_no']) : ''; ?>" 
           placeholder=" " required>
    <label>Mobile No</label>
  </div>

  <div class="checkbox-row">
    <input type="checkbox" id="hostel" name="hostel" 
           <?php echo (isset($row['hostel']) && $row['hostel'] == 1) ? "checked" : ""; ?>>
    <label for="hostel">Require Hostel</label>
  </div>

  <div class="actions">
    <?php if($isUpdate){ ?>
      <button class="backB" type="button" onclick="window.location.href='show_records.php'">Back</button>
      <button type="submit" name="update" class="primary">Update</button>
    <?php } else { ?>
      <button class="backB" type="button" onclick="window.location.href='index.php'">Back</button>
      <button type="reset" class="ghost">Reset</button>
      <button type="submit" name="submit" class="primary">Submit</button>
    <?php } ?>
  </div>
</form>
</div>
</body>
</html>
