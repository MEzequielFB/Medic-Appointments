<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='$this->baseUrl/css/global.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/nav.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/dashboard.css'>
    <link rel='stylesheet' href='$this->baseUrl/css/settings.css'>

    <script src='$this->baseUrl/js/nav.js'></script>
    <script src='$this->baseUrl/js/settings.js'></script>
</head>");

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

echo "<nav class='settingsSections'>";
    if ($errorMsg != "" || $successMsg != "") {
        echo ("
        <button class='profileInformationBtn'>Profile information</button>
        <button class='profilePictureBtn selected'>Profile picture</button>");
    } else {
        echo ("
        <button class='profileInformationBtn selected'>Profile information</button>
        <button class='profilePictureBtn'>Profile picture</button>");
    }
    echo "<button class='changePasswordBtn'>Change password</button>";
echo "</nav>";

if ($errorMsg != "" || $successMsg != "") {
    echo "<section class='profileInformation settingsSection hidden'>";
} else {
    echo "<section class='profileInformation settingsSection'>";
}

echo("
    <h1>Edit profile</h1>
    <form method='post' class='profileInformationForm'>
        <label for='email'>Email:</label>
        <input type='email' name='email' id='email' value='$user->email'>

        <label for='username'>Username:</label>
        <input type='text' name='username' id='username' value='$user->username'>

        <button>Update profile</button>
    </form>
</section>");

if ($errorMsg != "" || $successMsg != "") {
    echo "<section class='profilePicture settingsSection'>";
} else {
    echo "<section class='profilePicture settingsSection hidden'>";
}

echo("
    <h1>Change profile picture</h1>
    <form action='user/updateProfileImage' method='post' class='profilePictureForm' enctype='multipart/form-data'>
        <label for='image'>Picture:</label>
        
        <div class='fileInputContainer'>
            <label for='image' class='fileBtn'>Select File</label>
            <input type='file' name='image' id='image' class='image'>
            <span class='fileInputMsg'>No file selected</span>
        </div>

        <button>Update picture</button>
    </form>
</section>

<section class='changePassword settingsSection hidden'>
    <h1>Change password</h1>
    <form method='post' class='passwordForm'>
        <label for='currentPassword'>Current password:</label>
        <input type='password' name='currentPassword' id='currentPassword'>

        <label for='newPassword'>New password:</label>
        <input type='password' name='newPassword' id='newPassword'>

        <label for='newPasswordConfirm'>Confirm new password:</label>
        <input type='password' name='newPasswordConfirm' id='newPasswordConfirm'>

        <button>Update password</button>
    </form>
</section>

<p class='message'>$errorMsg</p>");

if ($successMsg != "") {
    echo("
    <div class='success-popup'>
        <p>$successMsg</p>
    </div>");
} else {
    echo("
    <div class='success-popup hidden'>
        <p></p>
    </div>");
}