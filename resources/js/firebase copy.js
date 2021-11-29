import {
    initializeApp
} from 'firebase/app'

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

const firebase = initializeApp(firebaseConfig);

import {
    getMessaging,
    getToken,
    onMessage
} from 'firebase/messaging';

const messaging = getMessaging();

const vapid = "BEfgx025HTlvQjmrhjtmAyU2TNYZWdVD6nHlYCoJCTk5Jd3Un7av8jGiYIVIK3HAbQDQUDhMbbbGYiOxHnwN3UA";

getToken(messaging, {
    vapidKey: vapid
}).then(token => {
    console.log('fmc token: ' + token)
    localStorage.setItem('token', JSON.stringify(token));
   var t = document.getElementById('token');
   t.value = token ? token : '';
    // alert(token)
}).catch(err => {
    console.log(err)
})

onMessage(messaging, (payload) => {
    console.log('Message received. ', payload);
    let n = new Notification(payload.notification.title, {
        body: payload.notification.body,
    });
})



export default messaging;
