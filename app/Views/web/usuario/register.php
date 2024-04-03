<?php echo $this->extend("Layouts/web"); ?>

<?php echo $this->section("contenido"); ?>

    <?php echo view("partials/_form-error"); ?>
    
    <form action="<?php echo route_to("usuario.register_post"); ?>" method="POST">

        <label for="usuario">Usuario</label>
        <input 
            type="text" name="usuario"
            value="<?php echo old("usuario", session("usuario")); ?>"
        >

        <label for="email">Email</label>
        <input 
            type="text" name="email" 
            value="<?php echo old("email", session("email")); ?>"
        >
    
        <label for="email">Contraseña</label>
        <input type="pasword" name="contrasena">
        <input type="submit" value="Crear cuenta">
    </form>

<?php echo $this->endSection(); ?>