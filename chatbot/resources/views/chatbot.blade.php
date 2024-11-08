<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Ensure the CSRF token is included in the request headers
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
    </script>
</head>
<body>

    <div>
        <h1>Ask the Chatbot</h1>
        <input type="text" id="message" placeholder="Ask a question...">
        <button onclick="sendMessage()">Send</button>
    </div>

    <div id="response">
        <!-- The chatbot's response will be shown here -->
    </div>

    <script>
        function sendMessage() {
            const message = document.getElementById('message').value;

            // Show loading message while waiting for the response
            document.getElementById('response').innerText = 'Loading...';

            // Send the message to the Laravel controller using AJAX (axios)
            axios.post('/ask-question', {
                message: message  // Changed to 'message' to match the backend
            })
            .then(function (response) {
                // Log the response to verify its content
                console.log(response.data);
                
                // Display the model's response in the response div
                document.getElementById('response').innerText = 'Chatbot: ' + response.data.answer;
            })
            .catch(function (error) {
                // Handle error and show in the response div
                console.error(error);  // Log error for debugging
                document.getElementById('response').innerText = 'Error: ' + error.message;
            });
        }
    </script>

</body>
</html>
