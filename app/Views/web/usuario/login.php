<?php echo $this->extend("Layouts/web"); ?>
<?php echo $this->section("contenido"); ?>
    <?php echo view("partials/_form-error_v2"); ?>
    <form 
        class="mb-3" 
        method="POST"
        action="<?php echo route_to("usuario.login_post"); ?>">
        <div class="mb-3">
            <label for="email" class="form-label">Email/Usuario</label>
            <input type="text" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Contraseña</label>
            <input type="pasword" name="contrasena" class="form-control">
        </div>
        <div class="d-flex justify-content-between">
            <input type="submit" value="Iniciar Sesión" class="btn btn-primary">
            <a href="<?php echo route_to("usuario.register") ?>" class="btn btn-secondary">Registrarse</a>
        </div>
    </form>
    <?php if(session("usuario") != null): ?>
        <br>
        <form action="<?php echo route_to("usuario.logout"); ?>" method="POST">
            <input type="submit" value="Cerrar Sesión">    
        </form>
    <?php endif ?>
<?php echo $this->endSection(); ?>