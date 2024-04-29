<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='css/global.css'>
    <link rel='stylesheet' href='css/login.css'>
    <link rel='stylesheet' href='css/signUp.css'>
</head>

<div class='signupContainer'>
    <h1>Get started!</h1>

    <form action='user' method='post'>
        <input type='text' name='username' id='username' placeholder='Username'>

        <input type='email' name='email' id='email' placeholder='Email'>

        <input type='password' name='password' id='password' placeholder='Password'>

        <input type='password' name='passwordCheck' id='passwordCheck' placeholder='Repeat the password'>

        <p class='errorMsg'>$errorMsg</p>

        <button type='submit'>Sign up</button>
    </form>
</div>");