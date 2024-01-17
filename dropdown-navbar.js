function toggleDropdown() {
    var dropdownOptions = document.getElementById("dropdownOptions");
    dropdownOptions.style.display = (dropdownOptions.style.display === "block") ? "none" : "block";
}

window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdownOptions = document.getElementById("dropdownOptions");
        if (dropdownOptions.style.display === "block") {
            dropdownOptions.style.display = "none";
        }
    }
}