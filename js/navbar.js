// Get the button to toggle the navbar
const nav = document.querySelector("nav");
const button = document.querySelector(".hamburgerLabel");
const buttonIcon = document.querySelector(".hamburgerLabel > i");
const closeButton = document.querySelector(".hamburgerClose");

// Assign a callback function for when the button is clicked
button.addEventListener("click", toggleNav);

// Change the icon to green but not the text itself
button.addEventListener("mouseover", function(){
    buttonIcon.style.color = "lime";
})
// Reset the colour to white when not hovering
button.addEventListener("mouseleave", function(){
    buttonIcon.style.color = "white";
})

closeButton.addEventListener("click", toggleNav);


function toggleNav() {
    // If shown, hide the navbar
    if (nav.classList[0] == "visibleNav") {
        buttonIcon.classList.remove("rotate");
        nav.classList.remove("visibleNav");

    // Else show the navbar
    } else {
        buttonIcon.classList.add("rotate");
        nav.classList.add("visibleNav");
    }
}
