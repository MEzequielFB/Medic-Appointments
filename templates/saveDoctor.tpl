{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/save.css">
<script src="{$baseUrl}js/saveDoctor.js"></script>
</head>

{include file="header.tpl"}

<h1>Save doctor</h1>

<form action="{$baseUrl}doctor" method="post" enctype="multipart/form-data" class="saveDoctorForm">
    <input type="text" name="fullname" id="fullname" placeholder="Fullname">

    <label for="specialization">Specialization:</label>
    <select name="specialization" id="specialization">
        
    </select>

    <label for="hospital">Hospital:</label>
    <select name="hospital" id="hospital">

    </select>
    
    <input type="file" name="image" id="image">

    <button type="submit">Save</button>
</form>
<p class="errorMsg">{$errorMsg}</p>