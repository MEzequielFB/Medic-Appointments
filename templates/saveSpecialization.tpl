{include file="head.tpl"}
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/save.css">
<link rel="stylesheet" href="{$baseUrl}/css/dashboard.css">
<link rel="stylesheet" href="{$baseUrl}/css/hospitals.css">

<script src="{$baseUrl}js/nav.js"></script>
<script src="{$baseUrl}js/saveSpecialization.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<h1 class="pageHeader">Save specialization</h1>
<form action="{$baseUrl}specialization" method="post" class="saveSpecializationForm">
    <input type="text" name="name" id="name" placeholder="Specialization">

    <div class="formBtns">
        <button type="button" class="cancelBtn hidden">Cancel</button>
        <button type="submit" class="saveBtn">Save</button>
    </div>
</form>
<p class="errorMsg">{$errorMsg}</p>

<p class="adviceMsg">Click a specialization to edit it!</p>
<section class="specializationsSection">
    {foreach from=$specializations item=specialization}
        <article class="eligibleSpecialization specialization{$specialization->id}">
            <h1>{$specialization->name}</h1>
        </article>
    {/foreach}
</section>