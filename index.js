
  
    function init() {
      const firebaseConfig = {
        apiKey: "AIzaSyCkjZHy2uAd8mZTE6f57rFSudOkcZ0HxIk",
        authDomain: "mk12-462e8.firebaseapp.com",
        projectId: "mk12-462e8",
        storageBucket: "mk12-462e8.appspot.com",
        messagingSenderId: "854905787304",
        appId: "1:854905787304:web:6d3c8ba1cee7572571039d",
        measurementId: "G-DEE1RYGQM9"
      };
      
    
      // Initialize Firebase if not initialized yet
      if (!firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
      }
    }
      // Get a reference to the Firestore database service
    
    
      document.getElementById('userForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const db = firebase.firestore();
        const auth = firebase.auth();
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
    
        try {
          // Create a user with email and password
          const userCredential = await auth.createUserWithEmailAndPassword(email, password);
          // Access the newly created user
          const user = userCredential.user;
    
          // Check if user exists and then add data to Firestore
          if (user) {
            // Add a new document with a generated ID to the "users" collection
            await db.collection("users").doc(user.uid).set({
              firstName,
              lastName,
              email
            });
    
            // Clear the form fields after submission
            document.getElementById('firstName').value = '';
            document.getElementById('lastName').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
    
            alert('User created and data saved successfully!');
          } else {
            console.log('No user found.');
            alert('User creation failed!');
          }
        } catch (error) {
          console.error("Error creating user: ", error);
          alert('Error creating user or saving data!');
        }
      });
    
    
    // Call the init function to initialize Firebase and set up the form event listener
    init();
    
