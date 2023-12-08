document.getElementById("showPostBox").addEventListener("click", function () {
    var postBox = document.getElementById("postBox");
    if (postBox.style.display === "none" || postBox.style.display === "") {
        postBox.style.display = "flex";
    } else {
        postBox.style.display = "none";
    }
});

document.getElementById('postBox').addEventListener('click', function () {
    console.log("e")
});

document.querySelector(".closePostBox").addEventListener("click", function () {
    document.getElementById("postBox").style.display = "none";
});