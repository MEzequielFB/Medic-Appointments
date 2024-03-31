{include file="head.tpl"}
<base href="{$baseUrl}">
<link rel="stylesheet" href="{$baseUrl}css/global.css">
<link rel="stylesheet" href="{$baseUrl}css/nav.css">
<link rel="stylesheet" href="{$baseUrl}css/dashboard.css">
<link rel="stylesheet" href="{$baseUrl}css/users.css">

<script src="{$baseUrl}js/nav.js"></script>
<script src="{$baseUrl}js/userManage.js"></script>
</head>

{include file="header.tpl"}
{include file="dashboard.tpl"}

<h1>Users</h1>

<form class="userSearchForm">
    <input type="search" name="filter" id="filter" placeholder="by username, email...">

    <div class="roleSearchContainer">
        <label for="roleSearch">Role:</label>
        <select name="roleSearch" id="roleSearch" title="roleSearch">
        <option value=""></option>
            {foreach from=$roles item=role}
                <option value="{$role->name}">{$role->name}</option>
            {/foreach}
        </select>
    </div>
    <button>Search</button>
</form>

<section class="users">
    {foreach from=$users item=user}
        {if $userId neq $user->id}
            <article>
                <div class="banner"></div>
                {if $user->image eq "" || $user->image eq null}
                    <img src="image/profile/default.jpg" alt="profile user's picture">
                {else}
                    <img src="image/profile/{$user->image}" alt="profile user's picture">
                {/if}
                <div class="userInfo">
                    <p>{$user->username}</p>
                    <p>{$user->email}</p>
                    <p class="roleP{$user->id}">{$user->role}</p>
                </div>

                <div class="roleSelection">
                    <p>Role:</p>
                    {if $userRole eq "SUPER_ADMIN"}
                        <select name="role" id="role" class="role" title="user roles">
                            {foreach from=$roles item=role}
                                {if $user->role eq $role->name}
                                    <option value="{$role->id}" selected>{$role->name}</option>
                                {else}
                                    <option value="{$role->id}">{$role->name}</option>
                                {/if}
                            {/foreach}
                        </select>
                    {else}
                        <p>{$user->role}</p>
                    {/if}
                </div>

                <button class="roleBtn userRole{$user->id} hidden">Update role</button>
            </article>
        {/if}
    {/foreach}
</section>

<div class="popup hidden">
    <p></p>
</div>

<input type="hidden" value="{$userRole}" class="userRole">