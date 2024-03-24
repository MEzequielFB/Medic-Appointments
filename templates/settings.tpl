{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/dashboard.css">
<link rel="stylesheet" href="{$baseUrl}css/settings.css">

<script src="{$baseUrl}js/nav.js"></script>
<script src="{$baseUrl}js/settings.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<nav class="settingsSections">
    {if $errorMsg eq "" || $successMsg eq ""}
        <button class="profileInformationBtn selected">Profile information</button>
        <button class="profilePictureBtn">Profile picture</button>
    {else}
        <button class="profileInformationBtn">Profile information</button>
        <button class="profilePictureBtn selected">Profile picture</button>
    {/if}
    <button class="changePasswordBtn">Change password</button>
</nav>

{if $errorMsg neq "" || $successMsg neq ""}
    <section class="profileInformation settingsSection hidden">
{else}
    <section class="profileInformation settingsSection">
{/if}
    <h1>Edit profile</h1>
    <form method="post" class="profileInformationForm">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{$user->email}">

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="{$user->username}">

        <button>Update profile</button>
    </form>
</section>

{if $errorMsg neq "" || $successMsg neq ""}
    <section class="profilePicture settingsSection">
{else}
    <section class="profilePicture settingsSection hidden">
{/if}
    <h1>Change profile picture</h1>
    <form action="{$baseUrl}user/updateProfileImage" method="post" class="profilePictureForm" enctype="multipart/form-data">
        <label for="image">Picture:</label>
        <input type="file" name="image" id="image">

        <button>Update picture</button>
    </form>
</section>

<section class="changePassword settingsSection hidden">
    <h1>Change password</h1>
    <form method="post" class="passwordForm">
        <label for="currentPassword">Current password:</label>
        <input type="password" name="currentPassword" id="currentPassword">

        <label for="newPassword">New password:</label>
        <input type="password" name="newPassword" id="newPassword">

        <label for="newPasswordConfirm">Confirm new password:</label>
        <input type="password" name="newPasswordConfirm" id="newPasswordConfirm">

        <button>Update password</button>
    </form>
</section>

<p class="message">{$errorMsg}</p>

{if $successMsg neq ""}
    <div class="success-popup">
        <p>{$successMsg}</p>
    </div>    
{else}
    <div class="success-popup hidden">
        <p></p>
    </div>
{/if}