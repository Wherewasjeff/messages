<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Contact Form</title>
</head>
<body>
<div class="bg">
    <div class="ievade">
        <h1>Enter your message</h1>
        <div class="form-container">
            <form id="messageForm">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
    <div class="sort">
        <h1>Messages</h1>
        <div class="sort-buttons">
            <button class="button" onclick="sortMessagesByDate()">Sort by Date</button>
            <button class="button" onclick="sortMessagesByName()">Sort by Name</button>
        </div>
        <div class="search-bar">
            <label for="search">Search:</label>
            <input type="text" id="search" oninput="searchMessages()">
        </div>
    </div>
    <div id="messages-container"></div>
</div>

<script>
    // Function to handle form submission
    document.getElementById('messageForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission behavior

        // Fetch and display messages using JavaScript (AJAX)
        var messagesContainer = document.getElementById('messages-container');
        var form = event.target;

        fetch('process_form.php', {
            method: 'POST',
            body: new FormData(form)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // If submission is successful, fetch and display messages
                    fetchAndDisplayMessages();
                    // Clear input fields
                    form.reset();
                }
            })
            .catch(error => console.error('Error submitting form:', error));
    });

    // Fetch and display messages using JavaScript (AJAX) on page load
    function fetchAndDisplayMessages() {
        var messagesContainer = document.getElementById('messages-container');
        fetch('get_messages.php')
            .then(response => response.json())
            .then(data => {
                messagesContainer.innerHTML = '<ul>';
                data.forEach(message => {
                    messagesContainer.innerHTML += `<li>${message.name} - ${message.email} - ${message.message} - ${message.date}</li>`;
                });
                messagesContainer.innerHTML += '</ul>';
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    function sortMessagesByDate() {
        fetch('get_messages.php?sort=date')
            .then(response => response.json())
            .then(data => displaySortedMessages(data))
            .catch(error => console.error('Error sorting messages by date:', error));
    }

    function sortMessagesByName() {
        fetch('get_messages.php?sort=name')
            .then(response => response.json())
            .then(data => displaySortedMessages(data))
            .catch(error => console.error('Error sorting messages by name:', error));
    }

    function searchMessages() {
        var searchQuery = document.getElementById('search').value.trim().toLowerCase();
        if (searchQuery !== '') {
            fetch(`get_messages.php?search=${searchQuery}`)
                .then(response => response.json())
                .then(data => displaySortedMessages(data))
                .catch(error => console.error('Error searching messages:', error));
        } else {
            // If the search bar is empty, fetch and display all messages
            fetchAndDisplayMessages();
        }
    }

    function displaySortedMessages(data) {
        var messagesContainer = document.getElementById('messages-container');
        messagesContainer.innerHTML = '<ul>';
        data.forEach(message => {
            messagesContainer.innerHTML += `<li>${message.name} - ${message.email} - ${message.message} - ${message.date}</li>`;
        });
        messagesContainer.innerHTML += '</ul>';
    }

    // Fetch and display messages on page load
    fetchAndDisplayMessages();
</script>
</body>
</html>
