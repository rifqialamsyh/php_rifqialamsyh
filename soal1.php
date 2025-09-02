<?php

session_start();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/soal1.css">
</head>

<body>
    <?php
    // 1a: Ask for Rows & Columns
    if (!isset($_POST['step']) || $_POST['step'] == 1) {
    ?>
        <div class="box">
            <form method="post">
                <label>Inputkan Jumlah Baris:</label>
                <input type="number" name="rows" required>
                Contoh: 1
                <br><br>
                <label>Inputkan Jumlah Kolom:</label>
                <input type="number" name="cols" required>
                Contoh: 3
                <br><br>
                <input type="hidden" name="step" value="2">
                <button type="submit">SUBMIT</button>
            </form>
        </div>
    <?php
    }

    // 1b: Generate fields based on rows & columns
    elseif ($_POST['step'] == 2) {
        $rows = (int) $_POST['rows'];
        $cols = (int) $_POST['cols'];


        $_SESSION['rows'] = $rows;
        $_SESSION['cols'] = $cols;
    ?>
        <div class="box">
            <form method="post">
                <?php
                for ($r = 1; $r <= $rows; $r++) {
                    for ($c = 1; $c <= $cols; $c++) {
                        echo "$r.$c: <input type='text' name='cell[$r][$c]'> &nbsp;";
                    }
                    echo "<br><br>";
                }
                ?>
                <input type="hidden" name="step" value="3">
                <button type="submit">SUBMIT</button>
            </form>
        </div>
    <?php
    }

    // 1c: Show final result
    elseif ($_POST['step'] == 3) {
        $rows = $_SESSION['rows'];
        $cols = $_SESSION['cols'];
        $data = $_POST['cell'];

        echo "<pre>";
        for ($r = 1; $r <= $rows; $r++) {
            for ($c = 1; $c <= $cols; $c++) {
                $value = htmlspecialchars($data[$r][$c]);
                echo "$r.$c : $value\n";
            }
        }
        echo "</pre>";

        session_destroy();
    }
    ?>
</body>

</html>