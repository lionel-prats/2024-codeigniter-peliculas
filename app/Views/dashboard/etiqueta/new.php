<?php echo $this->extend("Layouts/dashboard"); ?>
<?php echo $this->section("contenido"); ?>
    <?php echo view("partials/_form-error_v2"); ?>
    <form action="/dashboard/etiqueta/create" method="POST">
        <?php echo view("dashboard/etiqueta/_form"); ?>
    </form>
    <br>
    <a href="/dashboard/etiqueta" class="btn btn-primary">Get Back</a>
<?php echo $this->endSection(); ?>