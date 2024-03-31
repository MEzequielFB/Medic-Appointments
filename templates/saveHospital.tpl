{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/save.css">
<link rel="stylesheet" href="{$baseUrl}/css/hospitals.css">
<link rel="stylesheet" href="{$baseUrl}/css/dashboard.css">

<script src="{$baseUrl}js/nav.js"></script>
<script src="{$baseUrl}js/saveHospital.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<h1 class="pageHeader">Save hospital</h1>

<form action="{$baseUrl}hospital" method="post" class="saveHospitalForm">
    <input type="text" name="name" id="name" placeholder="Name">
    <input type="text" name="address" id="address" placeholder="Address">

    <div class="formBtns">
        <button type="button" class="cancelBtn hidden">Cancel</button>
        <button type="submit" class="saveBtn">Save</button>
    </div>
</form>
<p class="errorMsg">{$errorMsg}</p>

<p class="adviceMsg">Click a hospital to edit it!</p>
<section class="hospitalsSection">
    {foreach from=$hospitals item=hospital}
        <article class="eligibleHospital hospital{$hospital->id}">
            <h1>{$hospital->name}</h1>
            <p>{$hospital->address}</p>
        </article>
    {/foreach}
</section>