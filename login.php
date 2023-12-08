<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ced2e054c6.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body>

<?php
// Starter en PHP-sesjon
session_start();

// Initialiserer en variabel for feilmeldinger
$feil = "";

// Sjekker om skjemaet er sendt (submit-knappen er trykket)
if (isset($_POST['submit'])) {
    // Henter innloggingsdata fra skjemaet
    $Username = $_POST['brukernavn'];
    $Password = $_POST['passord'];

    // Kobler til databasen
    $dbc = mysqli_connect('localhost', 'root', 'admin', 'chattapp')
        or die('Error connecting to MySQL server');

    // Lager en SQL-spørring for å hente brukerinformasjon fra databasen basert på brukernavn og passord
    $query = "SELECT * FROM users WHERE brukernavn='$Username' AND passord='$Password'";

    // Utfører SQL-spørringen
    $result = mysqli_query($dbc, $query)
        or die('Error querying databases.');

    // Sjekker om spørringen returnerte minst én rad (dvs. gyldig innlogging)
    if ($result->num_rows > 0) {
        // Innlogging vellykket: Lagrer brukernavnet i en sesjonsvariabel og omdirigerer til hjemmesiden
        $_SESSION['brukernavn'] = $Username;
        header('location: homePage.php');
        exit(); // Avslutter skriptet etter omdirigering
    } else {
        // Innlogging mislyktes: Setter en feilmelding
        $feil = "Feil brukernavn eller passord.";
    }

    // Lukker tilkoblingen til databasen
    mysqli_close($dbc);
}
?>

<!-- HTML-skjema for innlogging -->
<div class="form-flex">
    <div class="form-wrapper">
        <p class="welcome-title">Welcome</p>
        <div class="feil-wrapper">
            <?php echo $feil; ?> <!-- Viser eventuelle feilmeldinger her -->
        </div>
        <form method="post">
            <div class="input-wrapper">
                <!-- Skjemafelt for brukernavn og passord -->
                <input class="user-input" type="text" name="brukernavn" placeholder="Username" required /><br />
                <input class="user-input" type="password" name="passord" placeholder="Password" required /><br />

                <!-- Innsending av skjemaet for innlogging -->
                <button class="user-button" type="submit" value="Logg inn" name="submit">Log in</button>

                <!-- Lenke for å registrere ny bruker -->
                <p class="redirection-regi" style="text-align: center; padding: 30px 0 0 0; color: #333;">Har ikke bruker? Klikk <a href="registration.php">Her</a> for å registrere ny bruker</p>
            </div>
        </form>
    </div>
</div>

<!-- Slutten av HTML-dokumentet -->
</body>

</html>
