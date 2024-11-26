import "./bootstrap";
import "../sass/app.scss";

//window.Pusher = require('pusher-js'); // If using a CDN, this line is not needed
//var Pusher = require("pusher");
// import Echo from "laravel-echo";

// import Pusher from "pusher-js";
// window.Pusher = Pusher;

// function sendMessage(receiverId, messageContent) {
//     if (!messageContent) {
//         console.error("Message content is empty.");
//         return;
//     }

//     fetch("/send-message", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": "{{ csrf_token() }}",
//         },
//         body: JSON.stringify({
//             receiver_id: receiverId, // Use JavaScript variable here
//             content: messageContent,
//         }),
//     });
// }

// window.Echo.connector.pusher.connection.bind("state_change", function (states) {
//     console.log("Previous state: " + states.previous);
//     console.log("Current state: " + states.current);
// });
