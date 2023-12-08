<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ced2e054c6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
    <script src="script.js" defer></script>
    <title>Login</title>
</head>

<body>

<?php
session_start();
$feil = "";
if (isset($_POST['submit'])) {
    //Gjør om POST fra formen til variabler
    $Username = $_POST['brukernavn'];
    $Password = md5($_POST['passord']);

    //Denne koden kobles til databasen
    $dbc = mysqli_connect('localhost', 'root', 'admin', 'chattapp')
        or die('Error connecting to Mysql server');

    //Gjør klar SQL-strengen
    $query = "SELECT * from users where brukernavn='$Username' and passord='$Password'";

    //Gjør en spørring 
    $result = mysqli_query($dbc, $query)
        or die(' Error querying databases. ');

    //while ($row = mysqli_fetch_assoc($result)) {
    //    $_SESSION = $row;
    //}
    //koble fra databasen
    mysqli_close($dbc);

    //sjekk om spørring gir resultater
	if ($result->num_rows > 0) {
        //login success
        $_SESSION['brukernavn'] = $Username;
        header('location: homePage.php');
    }

}
?>


    <div class="form-flex">
        <div class="form-wrapper">
            <p class="welcome-title">Welcome</p>
            <div class="feil-wrapper">
                <?php echo $feil; ?>
            </div>
            <form method="post">
                <div class="input-wrapper">
                <input class="user-input" type="text" name="brukernavn" placeholder="Username" required /><br />
                <input class="user-input" type="password" name="passord" placeholder="Password" required /><br />

                <a href="registration.php"><button class="user-button" type="submit" value="Logg inn" name="submit">Log
                        in</button></a>
                <p class="redirection-regi" style="text-align: center; padding: 30px 0 0 0; color: #333;">Har ikke
                    bruker?
                    klikk <a href="registration.php"> Her </a>for å registrere ny bruker</p>
                    </div>
            </form>
        </div>
    </div>

</body>

</html>
       


