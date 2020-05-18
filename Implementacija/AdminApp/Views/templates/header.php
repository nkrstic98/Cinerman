<!--
    Nikola Krstic 2017/0265
-->
<header class="bg-dark fixed-top">
    <div class="row">
        <div class="col-sm-2 text-center">
            <a class="display-4 text-white" href="<?= site_url("Admin/welcome") ?>" style="text-decoration: none">Cinerman</a>
        </div>
        <div class="col-sm-8"></div>
        <div class="col-sm-2">
            <form action="<?= site_url("Admin/logout") ?>" method="post">
                <button type="submit" class="btn btn-danger float-right mt-3 mr-2 p-2 mb-3">Log out</button>
            </form>
        </div>
    </div>
</header>