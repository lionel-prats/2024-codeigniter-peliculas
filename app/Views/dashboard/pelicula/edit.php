<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>

    <?php // echo view("partials/_form-error"); ?>

    <form action="/dashboard/pelicula/update/<?php echo $pelicula->id; ?>" method="POST">
        <?php echo view("dashboard/pelicula/_form"); ?>
    </form>
    <br>
    <a href="/dashboard/pelicula">Get Back</a>
<?php echo $this->endSection(); ?>