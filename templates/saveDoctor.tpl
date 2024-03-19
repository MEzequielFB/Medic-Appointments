{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/save.css">
<link rel="stylesheet" href="{$baseUrl}/css/dashboard.css">

<script src="{$baseUrl}js/saveDoctor.js"></script>
<script src="{$baseUrl}js/nav.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<h1>Save doctor</h1>

<form action="{$baseUrl}doctor" method="post" enctype="multipart/form-data" class="saveDoctorForm">
    <input type="text" name="fullname" id="fullname" placeholder="Fullname">

    <label for="specialization">Specialization:</label>
    <select name="specialization" id="specialization">
        
    </select>

    <label for="hospital">Hospital:</label>
    <select name="hospital" id="hospital">

    </select>

    <label for="startTime">Start time:</label>
    <input type="time" name="startTime" id="startTime">

    <label for="endTime">End time:</label>
    <input type="time" name="endTime" id="endTime">
    
    <input type="file" name="image" id="image">

    <button type="submit">Save</button>
</form>
<p class="errorMsg">{$errorMsg}</p>