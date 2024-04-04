// Function to confirm removal of an item from the cart
function confirmRemoval() {
    // Display a confirmation dialog and return true if the user confirms, otherwise return false
    return confirm('Are you sure you want to remove this item from the cart?');
}

// Function to fetch data from an API
function fetchData() {
    // Get the HTML element where the result will be displayed
    var resultElement = document.getElementById('result');

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure the request: GET request to 'https://api.example.com/data', asynchronous (true)
    xhr.open('GET', 'https://api.example.com/data', true);

    // Define what happens on successful data submission
    xhr.onload = function () {
        // Check if the HTTP request was successful (status code between 200 and 299)
        if (xhr.status >= 200 && xhr.status < 300) {
            // If successful, update the result element with the response text
            resultElement.textContent = xhr.responseText;
        } else {
            // If the request fails, display an error message
            resultElement.textContent = 'Error fetching data';
        }
    };

    // Send the request
    xhr.send();
}

// Attach an event listener to a button with the ID 'myButton'
document.getElementById('myButton').addEventListener('click', function () {
    // Display an alert when the button is clicked
    alert('Button clicked!');
});
