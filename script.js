// Legger til en hendelseslytter på et element med ID "showPostBox"
document.getElementById("showPostBox").addEventListener("click", function () {
    // Henter referansen til postboks-elementet
    var postBox = document.getElementById("postBox");

    // Sjekker om postboksen er skjult eller ikke synlig
    if (postBox.style.display === "none" || postBox.style.display === "") {
        // Hvis den er skjult eller ikke synlig, endrer vi display-stilen til "flex" for å vise den
        postBox.style.display = "flex";
    } else {
        // Hvis den allerede er synlig, skjuler vi postboksen ved å endre display-stilen til "none"
        postBox.style.display = "none";
    }
});

// Legger til en hendelseslytter på postboks-elementet
document.getElementById('postBox').addEventListener('click', function () {
    // Logger meldingen "e" til konsollen når postboksen klikkes
    console.log("e");
});

// Legger til en hendelseslytter på elementet med klassen "closePostBox"
document.querySelector(".closePostBox").addEventListener("click", function () {
    // Skjuler postboksen når lukkeknappen klikkes ved å endre display-stilen til "none"
    document.getElementById("postBox").style.display = "none";
});
