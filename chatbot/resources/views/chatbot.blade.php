<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>

    <!-- External Google Fonts (for nice typography) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styling -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .chat-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 400px;
        }

        h1 {
            text-align: center;
            color: #4A90E2;
            font-size: 24px;
            margin-bottom: 20px;
        }

        #message {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #4A90E2;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #357ABD;
        }

        #response {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
            min-height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loading {
            font-style: italic;
            color: #888;
        }
        
        .error {
            color: red;
        }

        .chat-box {
            max-height: 250px;
            overflow-y: auto;
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
            flex-grow: 1;
        }

        .chat-bubble {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            background-color: #4A90E2;
            color: white;
            max-width: 70%;
        }

        .chat-bubble.user {
            background-color: #E3E3E3;
            color: black;
            align-self: flex-end;
        }

    </style>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Ensure the CSRF token is included in the request headers
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
    </script>
</head>
<body>

    <div class="chat-container">
        <h1>Ask the Chatbot</h1>

        <!-- Chat Box for conversation -->
        <div id="chat-box" class="chat-box">
            <!-- Chat messages will be dynamically added here -->
        </div>

        <input type="text" id="message" placeholder="Ask a question..." onkeydown="if(event.key === 'Enter'){ sendMessage(); }">
        <button onclick="sendMessage()">Send</button>

        <div id="response">
            <!-- The chatbot's response will be shown here -->
        </div>
    </div>

    <script>
        function sendMessage() {
            const message = document.getElementById('message').value;

            if (!message.trim()) return; // Ignore empty messages

            // Display user's message in the chat box
            const chatBox = document.getElementById('chat-box');
            const userMessage = document.createElement('div');
            userMessage.classList.add('chat-bubble', 'user');
            userMessage.innerText = message;
            chatBox.appendChild(userMessage);

            // Scroll to the bottom of the chat box
            chatBox.scrollTop = chatBox.scrollHeight;

            // Clear the input field
            document.getElementById('message').value = '';

            // Show loading message while waiting for the response
            const responseDiv = document.getElementById('response');
            responseDiv.classList.add('loading');
            responseDiv.innerText = 'Loading...';

            // Send the message to the Laravel controller using AJAX (axios)
            axios.post('/ask-question', {
                message: message
            })
            .then(function (response) {
                // Display chatbot's response
                const chatbotMessage = document.createElement('div');
                chatbotMessage.classList.add('chat-bubble');
                chatbotMessage.innerText = response.data.answer;
                chatBox.appendChild(chatbotMessage);

                // Scroll to the bottom of the chat box
                chatBox.scrollTop = chatBox.scrollHeight;

                // Clear loading state and update response
                responseDiv.innerText = '';
                responseDiv.classList.remove('loading');
            })
            .catch(function (error) {
                // Handle error
                responseDiv.classList.add('error');
                responseDiv.innerText = 'Error: ' + error.message;
            });
        }
    </script>

</body>
</html>
