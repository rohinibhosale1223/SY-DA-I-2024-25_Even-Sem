/* Apply a smooth transition to the background and font */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(45deg, #410285, #b0c7f0);
    /* One single gradient color */
    animation: gradientAnimation 15s ease infinite;
    /* Animation for smooth color change */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: white;
}

.login-container {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    width: 350px;
    text-align: center;
    backdrop-filter: blur(10px);
    /* Adds a frosted glass effect */
}

h2 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #333;
    font-weight: 600;
}

.input-group {
    margin-bottom: 20px;
    text-align: left;
}

.input-group label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    color: #555;
    font-weight: 500;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    font-family: 'Poppins', sans-serif;
    background-color: #f7f7f7;
    transition: border-color 0.3s ease-in-out;
}

.input-group input:focus {
    border-color: #2575fc;
    /* Blue color when focused */
    outline: none;
}

.input-group button {
    width: 100%;
    padding: 12px;
    background-color: #2575fc;
    /* Blue gradient button */
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.input-group button:hover {
    background-color: #6a11cb;
    /* Hover effect color */
}

.forgot-password {
    margin-top: 10px;
    font-size: 14px;
}

.forgot-password a {
    color: #2575fc;
    text-decoration: none;
    transition: color 0.3s ease;
}

.forgot-password a:hover {
    color: #6a11cb;
}

.signup {
    margin-top: 20px;
    font-size: 14px;
}

.signup a {
    color: #2575fc;
    text-decoration: none;
    transition: color 0.3s ease;
}

.signup a:hover {
    color: #6a11cb;
}
<form action="/login" method="post">
        <h2>Login Form</h2>
        <label for="username">User Name</label>
        <input type="text" class="box" placeholder="Enter User name" id="username" name="username">
        <label for="pass">Password</label>
        <input type="password" class="box" placeholder="Enter Password" id="pass" name="pass">
        <button id="show-pass">show password</button>
        <input type="submit" id="submit-btn" value="Login" disabled>
        <!-- <div style="color: <%= err ? 'red' : 'green' %>"><%= msg %></div> -->
        <div class="msg"></div>
    </form>
var submit = document.getElementById('submit-btn');
var msgElement = document.querySelector('.msg');

submit.addEventListener('click', onSubmitClick);

function onSubmitClick(e)
    {
      e.preventDefault();
      var msg = '';
      let un = "rohinibhosale";
      let pw = 'Admin@123'
      if(un === username.value && pw === pass.value) {
      msg = 'Successfully logged in';
localStorage.setItem('userDetails', JSON.stringify({username:un, password:pw}));
msgElement.textContent=msg;  //don't use innerHTML for security purpose
      setTimeout(() => window.location = `${window.location.href.slice(0, window.location.href.lastIndexOf('/'))}/index.html`, 2000);}
    else {
      msg = 'Invalid Username or Password';
      msgElement.textContent=msg;
      console.log('error');
    }


    }