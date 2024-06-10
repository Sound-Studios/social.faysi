<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
       body {
    background-color: #282c34;
    color: #abb2bf;
    font-family: 'Arial', sans-serif;
    text-align: center;
    margin: 0;
    padding: 0;
}

.admin-panel {
    margin: 50px auto;
    max-width: 600px;
    padding: 20px;
    background-color: #3c4048;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

h1, h2 {
    color: #61dafb;
}

.file-list {
    text-align: left;
    margin: 20px auto;
}

.file-list form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #444b56;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.file-list button {
    background-color: #e06c75;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    margin-left: 5px;
}

.file-list button:hover {
    background-color: #be5046;
}

.info {
    color: #e06c75;
    margin: 10px 0;
}

form {
    margin: 20px 0;
}

input[type="password"], input[type="text"], textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #444b56;
    background-color: #444b56;
    color: #abb2bf;
}

input[type="color"] {
    padding: 5px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #444b56;
    background-color: #444b56;
    color: #abb2bf;
}

button[type="submit"] {
    background-color: #61dafb;
    color: #282c34;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
}

button[type="submit"]:hover {
    background-color: #21a1f1;
}

    </style>
</head>
<body>

<div class="admin-panel">
    <h1>Admin Panel</h1>

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

        // Background color form
        echo "<h2>Set Background Gradient Colors</h2>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='admin_password' value='$correctPassword'>";
        echo "<input type='color' name='color1' value='#000000'> Color 1<br><br>";
        echo "<input type='color' name='color2' value='#02746b'> Color 2<br><br>";
        echo "<button type='submit' name='submit_background'>Submit Background</button>";
        echo "</form>";

        // Title update form
        echo "<h2>Update Title</h2>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='admin_password' value='$correctPassword'>";
        echo "<input type='text' name='title' placeholder='Enter new title'><br><br>";
        echo "<button type='submit' name='submit_title'>Update Title</button>";
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

        if (isset($_POST['submit_background']) && !empty($_POST['color1']) && !empty($_POST['color2'])) {
            $color1 = htmlspecialchars($_POST['color1']);
            $color2 = htmlspecialchars($_POST['color2']);
            $backgroundColor = "linear-gradient(to right, $color1, $color2)";
            file_put_contents('background_color.txt', $backgroundColor);
            echo "<div class='info'>Background color has been updated.</div>";
        }

        if (isset($_POST['submit_title']) && !empty($_POST['title'])) {
            $title = htmlspecialchars($_POST['title']);
            file_put_contents('title.txt', $title);
            echo "<div class='info'>Title has been updated.</div>";
        }
    }
    ?>

</div>

</body>
</html>
