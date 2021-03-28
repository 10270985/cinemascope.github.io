const filmTable = document.getElementById("film-table");
const serverResponse = document.getElementById("serverResponse");
const container = document.getElementsByClassName("messageContainer")[0];

function getFavourites() {
    /* Attempt to skip JSON, doesn't work though 
    let formData = new FormData();
    formData.append('accountid', userId);
    formData.append('action', 'fetch');

    fetch('favourite.php', {
        method: 'post',
        body: formData
    }).then(response => console.log(response.text));
    */

// Function to do an Ajax call
console.log("breakpoint 1");
const doAjax = async () => {
  const response = await fetch('favourite.php'); // Generate the Response object
  if (response.ok) {
    const jsonValue = await response; // Get JSON value from the response body
    return Promise.resolve(jsonValue);
  } else {
    return Promise.reject('*** PHP file not found');
  }
}

// Call the function and output value or error message to console
console.log("FAVOURITE RESPONSE:");
doAjax().then(console.log).catch(console.log);

}

function refreshTable() {
    const tablexhr = new XMLHttpRequest();
    tablexhr.onload = function () {
        filmTable.innerHTML = this.responseText;
    }
        tablexhr.open("POST", "fetch-films.php");
        tablexhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        tablexhr.send(`userfavourites=none`);
        console.log("Table updated");
}

function toggleFavourite(userId, filmName, action) {
    const xhr = new XMLHttpRequest();
    xhr.onload = function () {
        console.log (`Toggle response text: ${this.responseText}`);
    }

    xhr.open("POST", "favourite.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`accountid=${userId}&filmname=${filmName}&action=${action}`);
    xhr.addEventListener("load", refreshTable);
}

function findRow(element) {
    while (element.parentNode) {
        element = element.parentNode;
        if (element.tagName == "TR" || element.tagName == "tr") {
            return element;
        }
    }
}

container.addEventListener('click', (event) => {
    if (event.target.classList.contains("favourite-star")) {
        row = findRow(event.target);
        filmName = row.firstChild.innerHTML;
        if (event.target.classList.contains("fa-star-o")) {
            toggleFavourite(userId, filmName, "add");
        
        } else if (event.target.classList.contains("fa-star")) {
            toggleFavourite(userId, filmName, "remove");
        }
    }
});

window.onload = function() {
   refreshTable();
   userFavourites = getFavourites();
};