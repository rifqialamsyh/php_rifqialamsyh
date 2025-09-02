<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "testdb");

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Get search keyword
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Build SQL with optional filter
$sql = "SELECT hobi, COUNT(DISTINCT person_id) AS jumlah_orang
        FROM hobi";

if ($search !== "") {
    $searchEscaped = $mysqli->real_escape_string($search);
    $sql .= " WHERE hobi LIKE '%$searchEscaped%'";
}

$sql .= " GROUP BY hobi ORDER BY jumlah_orang DESC";

$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Banyaknya Hobi</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/soal2.css">
</head>

<body>
    <h2>Banyaknya Hobi</h2>
    <a href="/">Home</a>
    <hr>

    <form method="get" class="search-box">
        <input type="text" name="search" placeholder="Search hobby..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>Hobi</th>
            <th>Jumlah Orang</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['hobi']) ?></td>
                    <td align="center"><?= $row['jumlah_orang'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No hobbies found</td>
            </tr>
        <?php endif; ?>
    </table>

    <?php $mysqli->close(); ?>

</body>

</html>