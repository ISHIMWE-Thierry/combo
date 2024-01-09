function getuser () {
var firebaseConfig = {
    apiKey: "AIzaSyCorFNM5iUJRGwi4KJ0a3OfothEjDu5kwQ",
    authDomain: "user45-e2f5a.firebaseapp.com",
    databaseURL: "https://user45-e2f5a-default-rtdb.firebaseio.com",
    projectId: "user45-e2f5a",
    storageBucket: "user45-e2f5a.appspot.com",
    messagingSenderId: "1060705860089",
    appId: "1:1060705860089:web:3dcf73875d6495bd952528",
    measurementId: "G-LWTG8WKQYP"
  };
  firebase.initializeApp(firebaseConfig);
  const auth = firebase.auth();
  const database = firebase.database();

  auth.onAuthStateChanged(function(user) {
    if (user) {
      database.ref('users/' + user.uid).once('value')
        .then(function(snapshot) {
          const userData = snapshot.val();
          if (userData) {
            // Access user data properties here
            const fullName = userData.full_name;
            const email = userData.email;
            // ... and so on for other user data fields

            // Display user data
            document.getElementById("userProfile").innerHTML = `
              <p>Email: ${email}</p>
              <p>Full Name: ${fullName}</p>
              <!-- Display other user details -->
            `;
          } else {
            console.log("No user data found.");
          }
        })
        .catch(function(error) {
          console.error("Error fetching user data:", error);
        });
    } else {
      window.location = "login.html";
    }
  });
}
