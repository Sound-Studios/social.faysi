<?php
session_start();
?>
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
    <h1>Admin Panel - Reported Files</h1>

    <?php
    $correctPassword = '09876Jason.';
    $submittedPassword = isset($_POST['admin_password']) ? $_POST['admin_password'] : '';

    if ($submittedPassword === $correctPassword) {
        echo "<div class='file-list'>";

        $reportedFile = 'reported.txt';
        if (file_exists($reportedFile)) {
            $reportedImages = file($reportedFile, FILE_IGNORE_NEW_LINES);

            if (!empty($reportedImages)) {
                foreach ($reportedImages as $reportedImage) {
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='admin_password' value='$correctPassword'>";
                    echo "$reportedImage ";
                    echo "<button type='submit' name='delete_reported' value='$reportedImage'>Delete</button>";
                    echo "<button type='submit' name='reset_reported' value='$reportedImage'>Reset Report</button>";
                    echo "</form>";
                }
            } else {
                echo "<div class='info'>No reported images.</div>";
            }
        } else {
            echo "<div class='info'>No reported images.</div>";
        }

        // News submission form
        echo "<h2>Submit News</h2>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='admin_password' value='$correctPassword'>";
        echo "<textarea name='news_content' rows='4' cols='50' placeholder='Enter news here...'></textarea><br>";
        echo "<button type='submit' name='submit_news'>Submit News</button>";
        echo "</form>";

        echo "</div>";
    } else {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $submittedPassword !== '') {
            echo "<div class='info'>Incorrect password!</div>";
        }

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

        if (isset($_POST['submit_news']) && !empty($_POST['news_content'])) {
            $newsContent = htmlspecialchars($_POST['news_content']);
            file_put_contents('news.txt', $newsContent);
            echo "<div class='info'>News has been updated.</div>";
        }
    }
    ?>

</div>

</body>
</html>
