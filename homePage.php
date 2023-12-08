<?php
// Starter en PHP-sesjon
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet"> 
    <script src="https://kit.fontawesome.com/ced2e054c6.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="stylesheet.css"> 

    <!-- Tittel på nettsiden -->
    <title>Login</title>
</head>

<body>
    <?php
    // Sjekker om brukeren er logget inn
    if (!isset($_SESSION['brukernavn'])) {
        // Omdirigerer brukeren til innloggingssiden eller håndterer situasjonen på passende vis
        header('Location: login.php');
        exit();
    }

    // Kobler til databasen
    $dbc = mysqli_connect('localhost', 'root', 'admin', 'chattapp')
        or die('Error connecting to MySQL server');

    // Henter poster fra databasen
    $query = "SELECT * FROM posts ORDER BY datePosted DESC"; // Endre denne spørringen etter behov
    $result = mysqli_query($dbc, $query) or die('Error fetching posts');

    // Viser poster i angitt format
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="post-flex">
            <div class="post-wrapper">
                <div class="nav-wrapper">';
        
        // Viser brukernavnet tilknyttet posten
        echo htmlspecialchars($row['brukernavn']);
        if ($row['brukernavn'] == $_SESSION['brukernavn']) {
            echo '<p>Delete</p>';
        }
        echo '</div>
                <div class="text-wrapper">
                    <p>' . htmlspecialchars($row['post']) . '</p>
                </div>
                <div class="interaction-wrapper">
                    <i class="fa-solid fa-heart"></i>
                    <span>' . date('M d, Y - H:i', strtotime($row['datePosted'])) . '</span>
                </div>
            </div>
        </div>';
    }

    // Sjekker om skjemaet er sendt
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Henter innholdet fra textarea
        $postContent = $_POST['postContent'];

        if (empty($postContent)) {
            $errors[] = 'The post content cannot be empty';
        } else {
            // Henter gjeldende dato og tid på formatet 'YYYY-MM-DD HH:MM:SS'
            $currentDateTime = date('Y-m-d H:i:s');

            // Henter brukernavnet til innlogget bruker fra sesjonen
            $loggedInUser = $_SESSION['brukernavn'];

            // Setter inn posten i databasen med gjeldende dato, tid og tilknyttet brukernavn
            $query = "INSERT INTO posts (post, likes, datePosted, brukernavn) 
                      VALUES ('$postContent', 0, '$currentDateTime', '$loggedInUser')";
            mysqli_query($dbc, $query) or die('Error inserting post into the database');

            // Omdirigerer til hjemmesiden eller viser en suksessmelding
            header('Location: homePage.php');
            exit();
        }
    }
    ?>

    <!-- Skjema for å legge til en ny post -->
    <form action="homePage.php" method="POST">
        <div class="post-box" id="postBox">
            <textarea name="postContent" id="postTextArea" cols="30" rows="10" placeholder="Write your post here."></textarea>
            <button type="submit" class="post-button">Post</button>
        </div>
    </form>

    <!-- Meny med ulike ikoner -->
    <div class="menu">
        <i class="fa-regular fa-user"></i>
        <i class="fa-solid fa-plus" id="showPostBox"></i>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>

    <!-- Javascript-fil -->
    <script src="./script.js"></script>
</body>

</html>
