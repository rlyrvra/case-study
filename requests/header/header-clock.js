var dayType = 'Regular Day';
async function fetchDayType() {
    try {
        const response = await fetch('requests/header/header-api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-By': 'getDayType'
            },
            //body: new URLSearchParams({ action: 'getDayType' }) // Modify as needed
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json(); // Parse JSON response
        return data; // Return the fetched JSON data
    } catch (error) {
        console.error('Fetch error:', error);
        return null; // Return null in case of an error
    }
}

// function fetchDayType() {
//     fetch('requests/header/header-api', {
//         method: 'POST', 
//         headers: {
//             'Accept': '*/*',
//             'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
//             'X-Requested-With': 'XMLHttpRequest',
//             'X-Requested-By': 'getDayType' // Custom header
//         },
//         body: new URLSearchParams({
            
//         })
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error(`HTTP error! Status: ${response.status}`);
//         }
//         return response.text(); // Convert response to HTML text
//     })
//     .then(html => {
//         document.getElementById('response-test').innerHTML = html; // Inject HTML into the element
//     })
//     .catch(error => console.error("Fetch Error:", error));
// }

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
    dayType = fetchDayType().then(dayType => {
        if (dayType) {
            const dayTypeElement = $('#day-type');
            dayTypeElement.text(dayType.dayType);
        } else {
            console.log('Failed to fetch day type');
        }
    });
    //fetchDayTypeAjax();
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