{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/save.css">
<link rel="stylesheet" href="{$baseUrl}/css/dashboard.css">
<link rel="stylesheet" href="{$baseUrl}/css/doctors.css">

<script src="{$baseUrl}js/saveDoctor.js"></script>
<script src="{$baseUrl}js/nav.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<h1 class="pageHeader">Save doctor</h1>

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

    <div class="formBtns">
        <button type="button" class="cancelBtn hidden">Cancel</button>
        <button type="submit" class="saveBtn">Save</button>
    </div>
</form>
<p class="errorMsg">{$errorMsg}</p>

<section class="doctorsSection">
    {foreach from=$doctors item=doctor}
        <article class="eligibleDoctor doctor{$doctor->id}">
            <div>
                <div>
                    <h1>Dr. {$doctor->fullname}</h1>
                    <p>{$doctor->specialization}</p>
                </div>
                <p class="hospitalP">{$doctor->hospital}</p>
            </div>
            <img src="{$baseUrl}image/profile/{$doctor->image}" alt="doctor's image">
        </article>
    {/foreach}
</section>