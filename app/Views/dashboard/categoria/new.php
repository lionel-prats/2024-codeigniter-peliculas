<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>
    <form action="/dashboard/categoria/create" method="POST">
        <?php echo view("dashboard/categoria/_form"); ?>
    </form>
    <br>
    <a href="/dashboard/categoria">Get Back</a>
<?php echo $this->endSection(); ?>