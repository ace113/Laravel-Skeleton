// Import the functions you need from the SDKs you need
import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js'
import { getMessaging, getToken, onMessage } from 'https://www.gstatic.com/firebasejs/9.15.0/firebase-messaging.js'
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyC-4NHNS7NmE8ATmyglufesNiN7p7mA8Z0",
  authDomain: "laravel-skeleton-50ef9.firebaseapp.com",
  projectId: "laravel-skeleton-50ef9",
  storageBucket: "laravel-skeleton-50ef9.appspot.com",
  messagingSenderId: "1091942871448",
  appId: "1:1091942871448:web:541e81f076d41c42c5fbed",
  measurementId: "G-7Q8JC9T9Y2"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging();

const vapid =
    "BEfgx025HTlvQjmrhjtmAyU2TNYZWdVD6nHlYCoJCTk5Jd3Un7av8jGiYIVIK3HAbQDQUDhMbbbGYiOxHnwN3UA";

getToken(messaging, {
    vapidKey: vapid,
})
    .then((token) => {
        console.log("fmc token: " + token);
        localStorage.setItem("fmc_token", JSON.stringify(token));
        var t = document.getElementById("token");
        if(t){
            t.value = token ? token : "";
        }
        // alert(token)
    })
    .catch((err) => {
        console.log(err);
    });

onMessage(messaging, (payload) => {
    console.log("Message received. ", payload);
    let n = new Notification(payload.notification.title, {
        body: payload.notification.body,
    });
    n.onclick = function(e) {
        e.preventDefault();
        window.open(payload.notification.click_action, '_blank');
        notification.close();
    }
});

export default {messaging};
