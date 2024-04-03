<?php echo $this->extend("Layouts/web"); ?>

<?php echo $this->section("contenido"); ?>

    <?php echo view("partials/_form-error"); ?>
    
    <form action="<?php echo route_to("usuario.login_post"); ?>" method="POST">
        <label for="email">Email/Usuario</label>
        <input type="text" name="email">
        <label for="email">Contraseña</label>
        <input type="pasword" name="contrasena">
        <input type="submit" value="Login">
    </form>

    <?php if(session("usuario") != null): ?>
        <br>
        <form action="<?php echo route_to("usuario.logout"); ?>" method="POST">
            <input type="submit" value="Cerrar Sesión">    
        </form>
    <?php endif ?>

<?php echo $this->endSection(); ?>