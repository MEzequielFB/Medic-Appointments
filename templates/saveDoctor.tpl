{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/doctor.css">
</head>

{include file="header.tpl"}

<h1>Save doctor</h1>

<form action="doctor" method="post" enctype="multipart/form-data">
    <input type="text" name="fullname" id="fullname" placeholder="Fullname">

    <label for="specialization">Specialization:</label>
    <select name="specialization" id="specialization">
        {foreach from=$specializations item=specialization}
            <option value="{$specialization->id}">{$specialization->name|capitalize}</option>
        {/foreach}
    </select>

    <label for="hospital">Hospital:</label>
    <select name="hospital" id="hospital">
        {foreach from=$hospitals item=hospital}
            <option value="{$hospital->id}">{$hospital->name|capitalize}</option>
        {/foreach}
    </select>
    
    <input type="file" name="image" id="image">

    <button type="submit">Save</button>
</form>