<?php
// Establish connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user-id";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$user = $_POST['fullname'];
$pass = $_POST['password']; // Please use password_hash() for secure storage
$email = $_POST['email'];
$tel = $_POST['tel'];

// Check if the username already exists
$sql_check = "SELECT * FROM users WHERE user-email='$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Username already exists
    echo "Username already taken";
} else {
    // Insert new user into the database
    // For security, use prepared statements or password_hash() before storing passwords
    
    // Example using password_hash() for secure password storage
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    
    $sql_insert = "INSERT INTO users (user-name, user-password, user-email) VALUES ('$user', '$hashed_password', '$email')";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "Sign up successful";
        // Redirect or perform any action after successful signup
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>



// Your web app's Firebase configuration
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
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  // Initialize variables
  const auth = firebase.auth()
  const database = firebase.database()
 
  // Set up our register function
  function register () {
    
    // Get all our input fields
    email = document.getElementById('email').value
    password = document.getElementById('password').value
    full_name = document.getElementById('full_name').value
    surname = document.getElementById('surname').value
    tel = document.getElementById('tel').value
    country = document.getElementById('country').value
    
  
    // Validate input fields
    if (validate_email(email) == false || validate_password(password) == false) {
      alert('Email or Password is Outta Line!!')
      return
      // Don't continue running the code
    }
    if (validate_field(full_name) == false || validate_field(country) == false || validate_field(surname) == false || validate_field(tel) == false) {
      alert('One or More Extra Fields is Outta Line!!')
      return
    }
   
    // Move on with Auth
    auth.createUserWithEmailAndPassword(email, password)
    .then(function() {
      // Declare user variable
      var user = auth.currentUser
  
      // Add this user to Firebase Database
      var database_ref = database.ref()
  
      // Create User data
      var user_data = {
        email : email,
        full_name : full_name,
        surname: surname,
        tel : tel,
        country : country,
        last_login : Date.now(),
        active_plan:noneof,
        invested_amount:zeroof,
        balance:zeroof,
        deposit_amount:zeroof,
        paid_amount:zeroof,
        want_to_withdraw:zeroof,
        telegram:noneof,
        payment_method:noneof,
        date_for_purchased_plan:zeroof,
        profit_to_receive:zeroof,
        rate:zeroof,
        number_of_visit:zeroof

      }
  
      // Push to Firebase Database
      database_ref.child('users/' + user.uid).set(user_data)
  
      // DOne
      window.location.href = `profile.html?uid=${user.uid}`;
    })
    .catch(function(error) {
      // Firebase will use this to alert of its errors
      var error_code = error.code
      var error_message = error.message
  
      alert(error_message)
    })
  }
  
  // Set up our login function
  function login () {
    // Get all our input fields
    email = document.getElementById('email').value
    password = document.getElementById('password').value
  
    // Validate input fields
    if (validate_email(email) == false || validate_password(password) == false) {
      alert('Email or Password is Outta Line!!')
      return
      // Don't continue running the code
    }
  
    auth.signInWithEmailAndPassword(email, password)
    .then(function() {
      // Declare user variable
      var user = auth.currentUser
  
      // Add this user to Firebase Database
      var database_ref = database.ref()
  
      // Create User data
      var user_data = {
        last_login : Date.now()
      }
  
      // Push to Firebase Database
      database_ref.child('users/' + user.uid).update(user_data)
  
      // DOne
      alert('User Logged In!!')
  
    })
    .catch(function(error) {
      // Firebase will use this to alert of its errors
      var error_code = error.code
      var error_message = error.message
  
      alert(error_message)
    })
  }
  
  
  
  
  // Validate Functions
  function validate_email(email) {
    expression = /^[^@]+@\w+(\.\w+)+\w$/
    if (expression.test(email) == true) {
      // Email is good
      return true
    } else {
      // Email is not good
      return false
    }
  }
  
  function validate_password(password) {
    // Firebase only accepts lengths greater than 6
    if (password < 6) {
      return false
    } else {
      return true
    }
  }
  
  function validate_field(field) {
    if (field == null) {
      return false
    }
  
    if (field.length <= 0) {
      return false
    } else {
      return true
    }
  }