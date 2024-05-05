<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Manage Reports</title>
    <style>
        body {
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .admin-panel {
            margin-top: 50px;
        }

        .file-list {
            text-align: left;
            display: inline-block;
            margin: 20px auto;
        }

        .file-list button {
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .info {
            color: red;
        }
    </style>
</head>
<body>

<div class="admin-panel">
    <h1>Admin Panel - Reported Images</h1>

    <?php
    $correctPassword = 'your_admin_password';
    $submittedPassword = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';

    if ($submittedPassword === $correctPassword) {
        echo "<div class='file-list'>";

        $reportedFile = 'reported.txt';
        if (file_exists($reportedFile)) {
            $reportedImages = file($reportedFile, FILE_IGNORE_NEW_LINES);

            if (!empty($reportedImages)) {
                foreach ($reportedImages as $reportedImage) {
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='admin_password' value='$correctPassword'>";  // Beibehalten des Passworts
                    echo "$reportedImage ";
                    echo "<button type='submit' name='delete_reported' value='$reportedImage'>Delete</button>";  // Löschen des Bildes
                    echo "<button type='submit' name='reset_reported' value='$reportedImage'>Reset Report</button>";  // Zurücksetzen des Berichts
                    echo "</form>";
                }
            } else {
                echo "<div class='info'>No reported images.</div>";
            }
        } else {
            echo "<div class='info'>No reported images.</div>";
        }
        echo "</div>";
    } else {
        // Passwort falsch oder nicht angegeben
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $submittedPassword !== '') {
            echo "<div class='info'>Incorrect password!</div>";
        }

        // Passwort-Eingabeformular
        ?>
        <form action="" method="post">
            <input type="password" name="admin_password" placeholder="Enter password">
            <button type="submit">Login</button>
        </form>
        <?php
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['delete_reported'])) {
            $fileToDelete = $_POST['delete_reported'];
            $uploadsDir = __DIR__ . '/uploads/';
            $filePath = $uploadsDir . '/' . $fileToDelete;

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    // Aus der Report-Liste entfernen
                    $reportedFile = 'reported.txt';
                    $reportedImages = file($reportedFile, FILE_IGNORE_NEW_LINES);
                    $updatedReportedImages = array_diff($reportedImages, [$fileToDelete]);
                    file_put_contents($reportedFile, implode("\n", $updatedReportedImages));
                    echo "<div class='info'>$fileToDelete has been deleted.</div>";
                } else {
                    echo "<div class='info'>Error deleting $fileToDelete.</div>";
                }
            } else {
                echo "<div class='info'>$fileToDelete does not exist.</div>";
            }
        }

        if (isset($_POST['reset_reported'])) {
            $fileToReset = $_POST['reset_reported'];
            $reportedFile = 'reported.txt';
            $reportedImages = file($reportedFile, FILE_IGNORE_NEW_LINES);
            $updatedReportedImages = array_diff($reportedImages, [$fileToReset]);
            file_put_contents($reportedFile, implode("\n", $updatedReportedImages));
            echo "<div class='info'>$fileToReset report has been reset.</div>";
        }
    }
    ?>

</div>

</body>
</html>
