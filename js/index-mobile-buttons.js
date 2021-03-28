// Code for buttons on mobile view
// This enables/disables the slideshow and youtube
function slideshowToggle(subprocess) {
    // Disable the other media to free up screen space
    document.querySelector(".youtube").style.display = "none";
    youtubeEnable.innerText = "View our YouTube";

    if (slideshowEnable.innerText == "Hide images") {
        document.querySelector(".slideshow").style.display = "none";
        slideshowEnable.innerText = "View images";
    }

    else {
        document.querySelector(".slideshow").style.display = "block";
        slideshowEnable.innerText = "Hide images";
    }
}

function youtubeToggle(subprocess) {
    // Disable the other media to free up screen space
    document.querySelector(".slideshow").style.display = "none";
    slideshowEnable.innerText = "View images";

    if (youtubeEnable.innerText == "Hide YouTube") {
        document.querySelector(".youtube").style.display = "none";
        youtubeEnable.innerText = "View our YouTube";
    }

    else {
        document.querySelector(".youtube").style.display = "block";
        youtubeEnable.innerText = "Hide YouTube";
    }
}

youtubeEnable.addEventListener("click", youtubeToggle);
slideshowEnable.addEventListener("click", slideshowToggle);
