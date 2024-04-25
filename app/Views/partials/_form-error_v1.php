<?php 
    if(session("validation")): 
    // existe la variable flash "session", entonces hay errores de validacion en el form
?>

    <div class="error-message">
        <?php 
            echo session("validation"); 
            // renderizamos el contenido de esta variable flash, que contiene el condenido de /vendor/codeigniter4/framework/system/Validation/Views/list.php (podemos modificar este archivo a nuestro gusto)
        ?>
    </div>
    <br>
<?php endif ?>