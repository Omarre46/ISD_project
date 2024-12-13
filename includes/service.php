<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Floating Button with Form Popup</title>
    <style>
        /* Floating Button Styles */
        #floatingButton {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color:rgb(0, 0, 0);
            color: white;
            border: none;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        #floatingButton:hover {
            background-color:rgb(102, 102, 102);
        }

        /* Modal Styles */
        #popupModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        #popupContent {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        #popupContent h3 {
            margin-top: 0;
        }

        #popupContent label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        #popupContent input, #popupContent select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #popupContent button {
            background-color:rgb(0, 0, 0);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        #popupContent button:hover {
            background-color:rgb(101, 101, 101);
        }

        #closeButton {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        #closeButton:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <button id="floatingButton">+</button>

    <div id="popupModal">
        <div id="popupContent">
            <button id="closeButton">&times;</button>
            <h3>Request Service</h3>
            <form id="serviceForm">
                <label for="roomNumber">Room Number</label>
                <input type="text" id="roomNumber" name="roomNumber" placeholder="Enter your room number" required>

                <label for="serviceType">Service Type</label>
                <select id="serviceType" name="serviceType" required>
                    <option value="">Select a service</option>
                    <option value="housekeeping">Housekeeping</option>
                    <option value="food">Ordering Food</option>
                    <option value="maintenance">Maintenance</option>
                </select>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        const floatingButton = document.getElementById('floatingButton');
        const popupModal = document.getElementById('popupModal');
        const closeButton = document.getElementById('closeButton');

        floatingButton.addEventListener('click', () => {
            popupModal.style.display = 'flex';
        });

        closeButton.addEventListener('click', () => {
            popupModal.style.display = 'none';
        });

        // Optional: Close the modal when clicking outside the form
        popupModal.addEventListener('click', (event) => {
            if (event.target === popupModal) {
                popupModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
