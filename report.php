<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report an Image</title>
    <style>
        body {
            background-color: #333;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .report-panel {
            margin-top: 50px;
        }

        select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid white;
            background-color: #333;
            color: white;
        }

        button {
            padding: 10px;
            border-radius: 5px;
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }

        .info {
            color: red;
        }
    </style>
</head>
<body>

<div class="report-panel">
    <h1>Report an Image</h1>

    <?php
    $uploadsDir = __DIR__ . '/uploads/';  // Pfad zum Upload-Ordner
    if (is_dir($uploadsDir)) {
        $files = scandir($uploadsDir);

        if (count($files) > 2) {  // Mehr als nur '.' und '..'
            ?>

            <form action="report.php" method="post">
                <select name="file_to_report">
                    <?php
                    foreach ($files as $file) {
                        if ($file !== '.' && $file !== '..') {
                            echo "<option value='$file'>$file</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit">Report</button>
            </form>

            <?php
        } else {
            echo "<div class='info'>No images available to report.</div>";
        }
    } else {
        echo "<div class='info'>Upload directory does not exist.</div>";
    }

    // Wenn ein Bild gemeldet wird, wird es in die Datei 'reported.txt' geschrieben
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['file_to_report'])) {
        $fileToReport = $_POST['file_to_report'];
        $reportedFile = 'reported.txt';

        // Wenn die Datei nicht existiert, wird sie erstellt
        if (!file_exists($reportedFile)) {
            file_put_contents($reportedFile, "");  // Leere Datei erstellen
        }

        // Prüfen, ob das Bild bereits gemeldet wurde
        $reportedImages = file($reportedFile, FILE_IGNORE_NEW_LINES);
        if (!in_array($fileToReport, $reportedImages)) {
            file_put_contents($reportedFile, $fileToReport . "\n", FILE_APPEND);  // Bild zum Report hinzufügen
            echo "<div class='info'>$fileToReport has been reported.</div>";
        } else {
            echo "<div class='info'>$fileToReport has already been reported.</div>";
        }
    }
    ?>

</div>

</body>
</html>
