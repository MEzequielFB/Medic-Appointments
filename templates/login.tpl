{include file="head.tpl"}
</head>

<h1>{$title}</h1>

<form action="authentication" method="post">
    <label for="email">Email: </label>
    <input type="email" name="email" id="email">

    <label for="password">Password: </label>
    <input type="password" name="password" id="password">

    <button type="submit">Log in</button>
</form>
<a href="{$baseUrl}/signUp">Sign up</a>

<p>{$errorMsg}</p>