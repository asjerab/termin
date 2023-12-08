<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ced2e054c6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ced2e054c6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheet.css">
    <title>Login</title>
</head>

<body>



    <?php

    // Check if user is logged in
    if(!isset($_SESSION['brukernavn'])) {
        // Redirect the user to the login page or handle the situation accordingly
        header('Location: login.php');
        exit();
    }

    //Denne koden kobles til databasen
    $dbc = mysqli_connect('localhost', 'root', 'admin', 'chattapp')
        or die('Error connecting to Mysql server');

    // Fetch posts from the database
    $query = "SELECT * FROM posts ORDER BY datePosted DESC"; // Change this query as needed
    $result = mysqli_query($dbc, $query) or die('Error fetching posts');

// Display posts in the specified format
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="post-flex">
        <div class="post-wrapper">
            <div class="nav-wrapper">';
    
    // Display the username associated with the post
    echo htmlspecialchars($row['brukernavn']);

    echo '<p>Delete</p>
            </div>
            <div class="text-wrapper">
                <p>' . htmlspecialchars($row['post']) . '</p>
            </div>
            <div class="interaction-wrapper">
                <i class="fa-solid fa-heart"></i>
                <span>' . date('M d, Y - H:i', strtotime($row['datePosted'])) . '</span>
            </div>
        </div>
    </div>';
    
    echo '<hr class="br-post">';
}


    // Check if the form is submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the post content from the textarea
        $postContent = $_POST['postContent'];

        if(empty($postContent)) {
            $errors[] = 'The post content cannot be empty';
        } else {
            // Get the current date and time formatted as 'YYYY-MM-DD HH:MM:SS'
            $currentDateTime = date('Y-m-d H:i:s');

            // Get the logged-in user's username from the session
            $loggedInUser = $_SESSION['brukernavn'];

            // Insert the post into the database with the current date, time, and associated username
            $query = "INSERT INTO posts (post, likes, datePosted, brukernavn) 
                  VALUES ('$postContent', 0, '$currentDateTime', '$loggedInUser')";
            mysqli_query($dbc, $query) or die('Error inserting post into the database');

            // Redirect to the home page or display a success message
            header('Location: homePage.php');
            exit();
        }
    }

    ?>




    <?php

    // Check if the form is submitted
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the post content from the textarea
        $postContent = $_POST['postContent'];

        if(empty($postContent)) {
            $errors[] = 'The post content cannot be empty';
        }

        // Get the current date and time formatted as 'YYYY-MM-DD HH:MM:SS'
        $currentDateTime = date('Y-m-d H:i:s');

        // Insert the post into the database with the current date and time
        $query = "INSERT INTO posts (post, likes, datePosted) VALUES ('$postContent', 0, '$currentDateTime')";
        mysqli_query($dbc, $query) or die('Error inserting post into the database');

        // Redirect to the home page or display a success message
        header('Location: homePage.php');
        exit();
    }
    ?>

    <form action="homePage.php" method="POST">
        <div class="post-box" id="postBox">
            <textarea name="postContent" id="postTextArea" cols="30" rows="10"
                placeholder="Write your post here."></textarea>
            <button type="submit" class="post-button">Post</button>
        </div>
    </form>

    <!-- <div>
        <button class="closePostBox">X</button>
    </div> -->





    <div class="menu">
        <i class="fa-regular fa-user"></i>
        <i class="fa-solid fa-plus" id="showPostBox"></i>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>


    <script src="./script.js"></script>
</body>

</html>