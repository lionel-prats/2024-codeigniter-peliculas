<?php echo $this->extend("Layouts/web"); ?>
<?php echo $this->section("contenido"); ?>
    <?php //echo view("partials/_form-error_v1"); ?>
    <?php echo view("partials/_form-error_v2"); ?>
    <form 
        class="mb-3"
        method="POST"
        action="<?php echo route_to("usuario.register_post"); ?>">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input 
                type="text" name="usuario" class="form-control"
                value="<?php echo old("usuario", session("usuario")); ?>"
            >
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                class="form-control"
                type="text" name="email" 
                value="<?php echo old("email", session("email")); ?>"
            >
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Contraseña</label>
            <input type="pasword" class="form-control" name="contrasena">
        </div>
        <div class="mb-3 d-flex justify-content-between">
            <input type="submit" class="btn btn-primary" value="Registrarse">
            <a href="<?php echo route_to("usuario.login") ?>" class="btn btn-secondary">Iniciar Sesión</a>
        </div>
    </form>
<?php echo $this->endSection(); ?>