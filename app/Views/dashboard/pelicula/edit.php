<?php if($pelicula): ?>
    <?php echo $this->extend("Layouts/dashboard"); ?>

    <?php echo $this->section("contenido"); ?>

        <?php echo view("partials/_form-error_v2"); ?>

        <form 
            action="/dashboard/pelicula/update/<?php echo $pelicula->id; ?>" 
            method="POST"
            enctype="multipart/form-data" 
        >
        <!-- 
            enctype="multipart/form-data" 
            este atributo del form es necesario para poder enviar archivos al servidor con el submit (v119)
        --> 
            <?php echo view("dashboard/pelicula/_form"); ?>
        </form>
        <br>
        <a href="/dashboard/pelicula" class="btn btn-primary">Get Back</a>
    <?php echo $this->endSection(); ?>
<?php else: ?>
    <p>El id especificado no existe.</p>
<?php endif ?>