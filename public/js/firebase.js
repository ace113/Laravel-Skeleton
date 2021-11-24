// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
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
const analytics = getAnalytics(app);