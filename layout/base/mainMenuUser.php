<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
        <a class="p-2 link-secondary" href="/">Main page</a>
        <a class="p-2 link-secondary" href="#">Profile</a>
        <a class="p-2 link-secondary" href="#">Rules</a>
        <a class="p-2 link-secondary" href="#">Friends</a>
        <?=accessCheck(3)?'<a class="p-2 link-secondary" href="/admin/users">Administration</a>':''?>

    </nav>
</div>
