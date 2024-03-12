{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/save.css">
</head>

{include file="header.tpl"}

<h1>Save hospital</h1>

<form action="{$baseUrl}hospital" method="post">
    <input type="text" name="name" id="name" placeholder="Name">
    <input type="text" name="address" id="address" placeholder="Address">

    <button type="submit">Save</button>
</form>
<p class="errorMsg">{$errorMsg}</p>