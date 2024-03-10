{include file="head.tpl"}
<link rel="stylesheet" href="css/global.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/signUp.css">
</head>

<h1>Get started!</h1>

<form action="user" method="post">
    <input type="text" name="username" id="username" placeholder="Username">

    <input type="email" name="email" id="email" placeholder="Email">

    <input type="password" name="password" id="password" placeholder="Password">

    <input type="password" name="passwordCheck" id="passwordCheck" placeholder="Repeat the password">

    <button type="submit">Sign up</button>
</form>

<p>{$errorMsg}</p>