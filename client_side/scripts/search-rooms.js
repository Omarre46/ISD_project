let searchClicked = false;

function showRooms() {
    if (!searchClicked) {
        const roomsContainer = document.getElementById('searched-rooms');
        roomsContainer.style.display = 'block'; 
        searchClicked = true;
    }
}

function resetValues() {
    const roomsContainer = document.getElementById('searched-rooms');
    roomsContainer.style.display = 'none';
    searchClicked = false;
}
