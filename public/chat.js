// Set up listening for new messages
console.log("script running");
Echo.private(`chat.${receiverId}`)
    .listen('MessageSent', (event) => {
        displayMessage(event.message);
    });

// Function to send messages via AJAX
function sendMessage(receiverId, content) {
    axios.post('/send-message', {
        receiver_id: receiverId,
        content: content,
    }).then(response => {
        displayMessage(response.data.message); // Display the sent message in chat UI
    });
}
