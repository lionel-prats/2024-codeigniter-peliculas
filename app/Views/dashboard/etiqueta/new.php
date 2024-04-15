<?php echo $this->extend("Layouts/dashboard"); ?>
<?php echo $this->section("contenido"); ?>
    <form action="/dashboard/etiqueta/create" method="POST">
        <?php echo view("dashboard/etiqueta/_form"); ?>
    </form>
    <br>
    <a href="/dashboard/etiqueta">Get Back</a>
<?php echo $this->endSection(); ?>