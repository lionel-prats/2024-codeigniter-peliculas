<label for="titulo">Título</label>
<input type="text" name="titulo" id="titulo" value="<?php echo $pelicula["titulo"]; ?>">
<br>
<label for="titulo">Descripción</label>
<br>
<textarea name="descripcion" id="descripcion" cols="30" rows="10">
    <?php echo $pelicula["descripcion"]; ?>
</textarea>
<br>
<input type="submit" value="<?php echo $op; ?>" 