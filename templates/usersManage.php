<?php
require_once __DIR__ . "/../templates/head.php";

echo("
    <link rel='stylesheet' href='css/global.css'>
    <link rel='stylesheet' href='css/nav.css'>
    <link rel='stylesheet' href='css/dashboard.css'>
    <link rel='stylesheet' href='css/users.css'>

    <script src='js/nav.js'></script>
    <script src='js/userManage.js'></script>
</head>");

require_once __DIR__ . "/../templates/header.php";
require_once __DIR__ . "/../templates/dashboard.php";

echo("
<h1>Users</h1>

<form class='userSearchForm'>
    <input type='search' name='filter' id='filter' placeholder='by username, email...'>

    <div class='roleSearchContainer'>
        <label for='roleSearch'>Role:</label>
        <select name='roleSearch' id='roleSearch' title='roleSearch'>
            <option value=''></option>");

        foreach ($roles as $role) {
            echo "<option value='$role->name'>$role->name</option>";
        }
echo("
        </select>
    </div>
    <button>Search</button>
</form>

<section class='users'>");
foreach ($users as $user) {
    if ($this->userId != $user->id) {
        echo("
        <article>
            <div class='banner'></div>");
            if ($user->image == "" || $user->image == null) {
                echo "<img src='image/profile/default.jpg' alt='profile user's picture'>";
            } else {
                echo "<img src='image/profile/$user->image' alt='profile user's picture'>";
            }
            echo("
            <div class='userInfo'>
                <p>$user->username</p>
                <p>$user->email</p>
                <p class='roleP$user->id'>$user->role</p>
            </div>
            <div class='roleSelection'>
                <p>Role:</p>");
                if ($userRole == "SUPER_ADMIN") {
                    echo "<select name='role' id='role' class='role' title='user roles'>";
                        foreach ($roles as $role) {
                            if ($user->role == $role->name) {
                                echo "<option value='$role->id' selected>$role->name</option>";
                            } else {
                                echo "<option value='$role->id'>$role->name</option>";
                            }
                        }
                    echo "</select>";
                } else {
                    echo "<p>$user->role</p>";
                }
        echo ("
            </div>

            <button class='roleBtn userRole$user->id hidden'>Update role</button>
        </article>");
    }
}
echo("
</section>

<div class='popup hidden'>
    <p></p>
</div>

<input type='hidden' value='$userRole' class='userRole'>");