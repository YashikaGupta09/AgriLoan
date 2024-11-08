<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

<h1>Chatbot</h1>
<div>
    <label for="message">Type your message:</label>
    <input type="text" id="message" />
    <button onclick="sendMessage()">Send</button>
</div>

<div id="response"></div>

<script>
    function sendMessage() {
        const message = document.getElementById('message').value;

        axios.post('/ask', { message: message })
            .then(function (response) {
                document.getElementById('response').innerText = 'Chatbot: ' + response.data.reply;
            })
            .catch(function (error) {
                console.log(error);
                document.getElementById('response').innerText = 'Error: ' + error.message;
            });
    }
</script>

</body>
</html>
