<?php $validation = session()->getFlashdata('validation'); // obtengo los posibles errores de validacion del form ?>

<label for="titulo">Título</label>
<input 
    type="text" name="titulo" id="titulo" 
    value="<?php echo old("titulo", $pelicula["titulo"]); ?>"
>
<?php if(isset($validation["titulo"]) && $validation["titulo"] != ""): ?>
    <br>
    <br>
    <small class="error-message p-2"><?php echo $validation["titulo"]; ?></small>
<?php endif ?>
<br>
<br>
<label for="titulo">Descripción</label>
<br>
<textarea name="descripcion" id="descripcion" cols="30" rows="10">
    <?php echo old("descripcion", $pelicula["descripcion"]); ?>
</textarea>
<?php if(isset($validation["descripcion"]) && $validation["descripcion"] != ""): ?>
    <br>
    <br>
    <small class="error-message p-2"><?php echo $validation["descripcion"]; ?></small>
<?php endif ?>
<br>
<br>
<input type="submit" value="<?php echo $op; ?>" 