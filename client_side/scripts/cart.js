function updateCart(roomId, roomPrice) {
    const adults = document.getElementById("adults").value;
    const children = document.getElementById("children").value;
    const checkInDate = document.getElementById("check-in-date").dataset.date;
    const checkOutDate = document.getElementById("check-out-date").dataset.date;

    if (!checkInDate || !checkOutDate || adults == "0") {
        alert("Please select valid dates and at least one adult.");
        return;
    }

    const checkIn = new Date(checkInDate);
    const checkOut = new Date(checkOutDate);
    const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));

    if (nights <= 0) {
        alert("Invalid date range.");
        return;
    }

    const totalPrice = nights * roomPrice;
    
    document.getElementById("room-number").textContent = roomId;
    document.getElementById("cart-items").textContent = "1";
    document.getElementById("cart-adults").textContent = `${adults} Adults`;
    document.getElementById("cart-children").textContent = `${children} Children`;
    document.getElementById("cart-dates").textContent = `${checkIn.toDateString()} to ${checkOut.toDateString()}`;
    document.getElementById("cart-total").textContent = totalPrice.toFixed(2);
}
