<?php
echo("
<div class='usersDiv'>
    <img src='$this->baseUrl/image/left-arrow.png' alt='left arrow' class='usersLeftArrow'>

    <h1>Users</h1>
    <form method='post' class='userSearchForm'>
        <input type='search' placeholder='by username, email...' class='userSearch'>
        <button type='submit'>Search</button>
    </form>

    <section class='usersSection'>
        <div class='loader'></div>
    </section>
</div>");