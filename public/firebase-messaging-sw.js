importScripts('https://www.gstatic.com/firebasejs/8.5.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.5.0/firebase-messaging.js');

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
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler( function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
      );

    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };

    return self.registration.showNotification(
        title,
        options,
    );
});