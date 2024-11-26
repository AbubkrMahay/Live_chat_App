/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
// window.Pusher = require('pusher-js');
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

//console.log(window.userId);
//Pusher.logToConsole = true;

const receiverId = window.receiverId; // This will be the receiver_id passed from Blade
const groupId = window.groupId;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});
//console.log(window.userId);
window.Echo.channel(`chat.${receiverId}`).listen(".message.sent", (e) => {
    // console.log('Message received for user:', e.message);
    const messagesContainer = document.getElementById("messages");

    // Create a new message element
    const newMessage = document.createElement("p");
    newMessage.innerHTML = `<strong>${e.message.sender.name}:</strong> ${e.message.content}`;

    // Append the new message
    messagesContainer.appendChild(newMessage);

    // Scroll to the bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    //console.log(newMessage);
});
window.Echo.channel(`chat.group.${groupId}`).listen(".message.sent", (e) => {
    // console.log('Message received for user:', e.message);
    const messagesContainer = document.getElementById("messages");

    // Create a new message element
    const newMessage = document.createElement("p");
    newMessage.innerHTML = `<strong>${e.message.sender.name}:</strong> ${e.message.content}`;

    // Append the new message
    messagesContainer.appendChild(newMessage);

    // Scroll to the bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    //console.log(newMessage);
});
document.getElementById("send-button").addEventListener("click", function () {
    const messageContent = document.getElementById("message-input").value;

    // Display the sent message in the sender's chat window immediately
    const messagesContainer = document.getElementById("messages");
    const newMessage = document.createElement("p");
    newMessage.innerHTML = `<strong>You:</strong> ${messageContent}`;
    messagesContainer.appendChild(newMessage);

    // Scroll to the bottom of the container
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Send the message via an AJAX request to the backend (no need to store in DB again)
    axios.post("/send-message", {
            content: messageContent,
            receiver_id: receiverId, // Dynamically set the receiver
            group_id: groupId,
        })
        .then((response) => {
            console.log("Message sent!");
        })
        .catch((error) => {
            console.error("Error sending message:", error);
        }); 
});
