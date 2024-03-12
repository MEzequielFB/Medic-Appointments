{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/save.css">
</head>

{include file="header.tpl"}

<h1>Save specialization</h1>
<form action="{$baseUrl}specialization" method="post">
    <input type="text" name="name" id="name" placeholder="Specialization">
    <button type="submit">Save</button>
</form>
<p class="errorMsg">{$errorMsg}</p>