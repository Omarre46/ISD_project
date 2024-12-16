let selectedField = '';
let checkInDate = null;
let checkOutDate = null;

function togglePopup() {
    const popup = document.getElementById("guest-popup");
    popup.classList.toggle("visible");
}

function closePopup() {
    const popup = document.getElementById("guest-popup");
    popup.classList.remove("visible");
}

function applyChanges() {
    const adults = document.getElementById("adults").value;
    const children = document.getElementById("children").value;

    const guestInfo = document.getElementById("guest-info");
    guestInfo.textContent = `${adults} Adults, ${children} Children`;

    closePopup();
}

function handleSectionClick(section) {
    highlightSection(section);
    showCalendar(section);
}

function showCalendar(field) {
    selectedField = field;

    document.querySelector('.check-in').classList.remove('highlighted');
    document.querySelector('.check-out').classList.remove('highlighted');
    if (field === 'check-in') {
        document.querySelector('.check-in').classList.add('highlighted');
    } else if (field === 'check-out') {
        document.querySelector('.check-out').classList.add('highlighted');
    }

    generateCalendar();
}

function generateCalendar() {
    const today = new Date();
    const calendarContainer = document.getElementById('calendar-container');
    calendarContainer.innerHTML = '';

    const months = [
        new Date(today.getFullYear(), today.getMonth(), 1),
        new Date(today.getFullYear(), today.getMonth() + 1, 1)
    ];

    months.forEach(month => {
        const calendar = document.createElement('div');
        calendar.className = 'calendar';
        calendar.innerHTML = buildMonth(month);
        calendarContainer.appendChild(calendar);
    });
}

function buildMonth(date) {
    const month = date.getMonth();
    const year = date.getFullYear();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let minDate = today;
    if (selectedField === 'check-out' && checkInDate) {
        minDate = checkInDate;
    }

    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    let html = `<table>
        <thead>
            <tr><th colspan="7">${monthNames[month]} ${year}</th></tr>
            <tr>
                <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
            </tr>
        </thead>
        <tbody>`;

    let day = 1;
    for (let i = 0; i < 6; i++) {
        html += '<tr>';
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                html += '<td></td>';
            } else if (day > daysInMonth) {
                break;
            } else {
                const currentDate = new Date(year, month, day);
                const isDisabled = currentDate < minDate;
                const isSelected =
                    (checkInDate && currentDate.getTime() === checkInDate.getTime()) ||
                    (checkOutDate && currentDate.getTime() === checkOutDate.getTime());
                const isInRange =
                    checkInDate &&
                    checkOutDate &&
                    currentDate > checkInDate &&
                    currentDate < checkOutDate;

                let classes = '';
                if (isDisabled) classes += 'disabled ';
                if (isSelected) classes += 'selected-date ';
                if (isInRange) classes += 'highlighted-range ';

                html += `<td 
                            class="${classes.trim()}" 
                            data-year="${year}" 
                            data-month="${month}" 
                            onclick="${isDisabled ? '' : `selectDate(${year}, ${month}, ${day})`}">
                            ${day}
                        </td>`;
                day++;
            }
        }
        html += '</tr>';
    }
    html += '</tbody></table>';
    return html;
}

function selectDate(year, month, day) {
    const date = new Date(year, month, day);
    const messageContainer = document.getElementById('message-container');
    messageContainer.textContent = "";  // Clear previous messages

    // Handle check-in selection
    if (selectedField === 'check-in') {
        checkInDate = date;
        checkOutDate = null; // Reset check-out when a new check-in is selected
        document.getElementById('check-in-date').textContent = date.toDateString();
        document.getElementById('check-in-date').dataset.date = date.toISOString();
    } 
    // Handle check-out selection
    else if (selectedField === 'check-out') {
        if (checkInDate && date > checkInDate) {
            checkOutDate = date;
            document.getElementById('check-out-date').textContent = date.toDateString();
            document.getElementById('check-out-date').dataset.date = date.toISOString();
        } else {
            messageContainer.textContent = "You can't select check out before check in";
            messageContainer.style.color = "red";
            return;
        }
    }

    // Now send the selected dates to the URL
    updateUrlWithDates();

    // Re-render the calendar to reflect changes
    generateCalendar();
}

// Function to update the URL with the check-in and check-out dates
function updateUrlWithDates() {
    if (checkInDate) {
        const checkInDateStr = checkInDate.toISOString().split('T')[0];  // Format as YYYY-MM-DD
        if (checkOutDate) {
            const checkOutDateStr = checkOutDate.toISOString().split('T')[0];  // Format as YYYY-MM-DD
            // Update the URL with both checkIn and checkOut dates
            window.history.replaceState(null, '', `reservation.php?checkIn=${encodeURIComponent(checkInDateStr)}&checkOut=${encodeURIComponent(checkOutDateStr)}`);
        } else {
            // Update the URL with only checkIn date
            window.history.replaceState(null, '', `reservation.php?checkIn=${encodeURIComponent(checkInDateStr)}`);
        }
    }
}

function highlightSection(section) {
    const sections = document.querySelectorAll('.guests, .check-in, .check-out');
    sections.forEach(sec => sec.classList.remove('active'));

    document.querySelector(`.${section}`).classList.add('active');
}

window.onload = function () {
    generateCalendar();
};

function resetValues() {
    document.getElementById('check-in-date').textContent = "Select Date";
    document.getElementById('check-out-date').textContent = "Select Date";
    document.getElementById('searched-rooms').style.display = "none";
}
