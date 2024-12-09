import { initializeApp } from 'firebase/app';
import { getAuth } from 'firebase/auth';

const firebaseConfig = {
    // Your Firebase config object from the firebase dashboard
    apiKey: "AIzaSyDdIUlizdi1uCYR0a3EA7cLz_Pca8E_yAE",
    authDomain: "bookmarking-a8924.firebaseapp.com",
    projectId: "bookmarking-a8924",
    storageBucket: "bookmarking-a8924.firebasestorage.app",
    messagingSenderId: "442425353071",
    appId: "1:442425353071:web:b2d8fda6912df375817e9a"
};

const app = initializeApp(firebaseConfig);
export const auth = getAuth(app);