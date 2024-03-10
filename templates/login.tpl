{include file="head.tpl"}
<link rel="stylesheet" href="css/global.css">
<link rel="stylesheet" href="css/login.css">
</head>

<div>
    <h1>Welcome to Medipoint!</h1>
    <p>Streamline your medical appointments with ease using our intuitive app designed to simplify your healthcare journey.</p>
</div>

<form action="authentication" method="post">
    <input type="email" name="email" id="email" placeholder="Email">

    <input type="password" name="password" id="password" placeholder="Password">

    <button type="submit">Log in</button>

    <p class="errorMsg">{$errorMsg}</p>

    <a href="{$baseUrl}/signUp"><button type="button">Sign up</button></a>
</form>