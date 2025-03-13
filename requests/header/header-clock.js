function updateDateTime() {
    const now = moment();
    
    document.getElementById('time').innerText = now.format('hh:mm:ss A'); 
    document.getElementById('date').innerText = now.format('dddd, MMMM DD, YYYY'); 
}

function getFormattedDateTime() {
    return moment().format('YYYY-MM-DD HH:mm:ss'); // 2025-01-01 08:00:00
}

$(document).ready(function(){
    setInterval(updateDateTime, 1000);
    updateDateTime();
});


function searchNav() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let subItems = document.querySelectorAll(".menu-sub .menu-item a");
    let mainItems = document.querySelectorAll("aside > .menu-inner > .menu-item > a");
    let resultsContainer = document.getElementById("searchResults");
    let hasResults = false;
    
    resultsContainer.innerHTML = "";
    
    // Search sub-menu items
    subItems.forEach(item => {
        let parentMenuElement = item.closest(".menu-sub").previousElementSibling.querySelector("div");
        let parentMenu = parentMenuElement ? parentMenuElement.textContent : "";
        let text = item.textContent.toLowerCase();
        if (text.includes(input) && input !== "") {
            let listItem = document.createElement("li");
            listItem.classList.add("list-group-item");
            let link = document.createElement("a");
            link.classList.add("nav-link");
            link.href = item.href;
            link.textContent = parentMenu ? `${parentMenu} > ${item.textContent}` : item.textContent;
            listItem.appendChild(link);
            resultsContainer.appendChild(listItem);
            hasResults = true;
        }
    });
    
    // Search main menu items (excluding menu toggles like "Attendance")
    mainItems.forEach(item => {
        let text = item.textContent.toLowerCase();
        if (text.includes(input) && input !== "" && item.href !== "javascript:void(0);") {
            let listItem = document.createElement("li");
            listItem.classList.add("list-group-item");
            let link = document.createElement("a");
            link.classList.add("nav-link");
            link.href = item.href;
            link.textContent = item.textContent;
            listItem.appendChild(link);
            resultsContainer.appendChild(listItem);
            hasResults = true;
        }
    });
    
    resultsContainer.style.display = hasResults ? "block" : "none";
}