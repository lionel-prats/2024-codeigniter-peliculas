<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>

    <?php echo view("partials/_form-error"); ?>

    <form action="/dashboard/categoria/update/<?php echo $categoria["id"]; ?>" method="POST">
        <?php echo view("dashboard/categoria/_form"); ?>
    </form>
    <br>
    <a href="/dashboard/categoria">Get Back</a>
<?php echo $this->endSection(); ?>