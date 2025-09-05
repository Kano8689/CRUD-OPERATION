<?php
include "DB.php";

//Retrieve the array from session
$selectedFields = $_SESSION['selectedFields'] ?? []; // default to empty array if not set
$fieldsStr = implode(", ", $selectedFields);

if(isset($_POST['goback'])) {
    header('location: view_options.php');
}

if(!empty($selectedFields)){
    $sql = "SELECT $fieldsStr, id FROM $tablename"; // include id for action buttons
    $result = mysqli_query($conn, $sql);
} else {
    $result = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selected Fields</title>
    <link rel="stylesheet" href="show_records.css">
    <style>
    .search-container {
        margin: 15px;
        text-align: center;
    }
    .search-container select,
    .search-container input {
        padding: 6px;
        margin-right: 8px;
        font-size: 14px;
    }
    .search-container input {
        width: 300px;
    }
</style>

</head>
<body>

<?php if($result && mysqli_num_rows($result) > 0): ?>

    <!-- 🔎 Search bar + dropdown -->
    <div class="search-container">
        <label for="searchInput">Search:</label>
        <input type="text" id="searchInput" placeholder="Type to search...">
        
        <label for="column">in</label>
        <select id="column">
            <?php foreach($selectedFields as $index => $field): ?>
                <option value="<?= $index ?>"><?= htmlspecialchars(ucfirst($field)) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <table align="center" id="studentTable">
        <thead>
            <tr>
                <?php foreach($selectedFields as $field): ?>
                    <th style="text-align: center;"><?= htmlspecialchars(ucfirst($field)) ?></th>
                <?php endforeach; ?>
                <th style="text-align: center;" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <?php foreach($selectedFields as $field): ?>
                        <?php if($field=="hostel"){ ?>
                            <?php if($row[$field] == 0) { ?>
                                <td>❌</td>
                            <?php } else { ?>
                                <td>✔️</td>
                            <?php } ?>
                        <?php } else { ?>
                            <td><?= htmlspecialchars($row[$field]) ?></td>
                        <?php } ?>
                    <?php endforeach; ?>
                    <td>
                        <!-- Update button -->
                        <form method="post" action="registration_form.php" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">✏️</button>
                        </form>
                    </td>
                    <td>
                        <!-- Delete button -->
                        <form method="post" action="delete_record.php" style="display:inline-block; margin-left:5px;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this record?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="<?= (count($selectedFields)+2) ?>">
                    <form action="index.php" method="get">
                        <button type="submit" style="width: 100%; padding: 10px; font-size: 16px;">
                            Go Back
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <script>
        const searchInput = document.getElementById("searchInput");
        const columnSelect = document.getElementById("column");
        const table = document.getElementById("studentTable").getElementsByTagName("tbody")[0];

        searchInput.addEventListener("keyup", function () {
            let filter = searchInput.value.toLowerCase();
            let colIndex = parseInt(columnSelect.value);

            for (let row of table.rows) {
                let cell = row.cells[colIndex];
                if (cell) {
                    let text = cell.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? "" : "none";
                }
            }
        });
    </script>

<?php else: ?>
    <p>No records found or no fields selected.</p>
<?php endif; ?>
</body>
</html>
