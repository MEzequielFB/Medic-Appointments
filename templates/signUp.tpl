{include file="head.tpl"}
</head>

<h1>{$title}</h1>

<form action="user" method="post">
    <label for="email">Email: </label>
    <input type="email" name="email" id="email">

    <label for="password">Password: </label>
    <input type="password" name="password" id="password">

    <label for="passwordCheck">Enter the password again: </label>
    <input type="password" name="passwordCheck" id="passwordCheck">

    <button type="submit">Sign up</button>
</form>

<p>{$errorMsg}</p>