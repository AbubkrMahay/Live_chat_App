//window.Pusher = require('pusher-js'); // If using a CDN, this line is not needed
//var Pusher = require("pusher");
// import Echo from "laravel-echo";

// import Pusher from "pusher-js";
// window.Pusher = Pusher;

let csrfToken = '{{ csrf_token() }}';
let receiverId = window.receiverId; // This will be the receiver_id passed from Blade
let groupId = window.groupId;
console.log("Receiver ID: ", receiverId);
console.log("Group ID: ", groupId);
function sendMessage(receiverId, messageContent, groupId, token) {
    if (!messageContent) {
        console.error("Message content is empty.");
        return;
    }
    fetch("/send-message", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": window.csrfToken
        },
        body: JSON.stringify({
            receiver_id: receiverId, // Use JavaScript variable here
            group_id: groupId,
            content: messageContent,
        }),
    });
}


/* window.Echo.connector.pusher.connection.bind("state_change", function (states) {
    console.log("Previous state: " + states.previous);
   console.log("Current state: " + states.current);
 }); */
