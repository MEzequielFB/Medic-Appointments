{include file="head.tpl"}
</head>

<a href="logout">Logout</a>
<h1>Users:</h1>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$users item=user}
            <tr>
                <td>{$user->id}</td>
                <td>{$user->email}</td>
                <td>{$user->role}</td>
            </tr>
        {/foreach}
    </tbody>
</table>