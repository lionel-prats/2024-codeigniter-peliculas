<?php 
    $validation = session()->getFlashdata('validation'); // obtengo los posibles errores de validacion del form 

    // bloque para que no rompa el form de edicion por errores de validacion
    $titulo = "";
    $descripcion = "";
    if(isset($pelicula) && isset($pelicula->titulo)) {
        $titulo = $pelicula->titulo;
        
    }   
    if(isset($pelicula) && isset($pelicula->descripcion)) {
        $descripcion = $pelicula->descripcion;
        
    }   
    // fin bloque 
?>

<label for="titulo">Título</label>
<input 
    type="text" name="titulo" id="titulo" 
    value="<?php echo old("titulo", $titulo); ?>"
>
<?php if(isset($validation->titulo) && $validation->titulo != ""): ?>
    <br>
    <br>
    <small class="error-message p-2"><?php echo $validation->titulo; ?></small>
<?php endif ?>
<br>
<br>
<label for="titulo">Descripción</label>
<br>
<textarea name="descripcion" id="descripcion" cols="30" rows="10">
    <?php echo old("descripcion", $descripcion); ?>
</textarea>
<?php if(isset($validation->descripcion) && $validation->descripcion != ""): ?>
    <br>
    <br>
    <small class="error-message p-2"><?php echo $validation->descripcion; ?></small>
<?php endif ?>
<br>
<br>
<input type="submit" value="<?php echo $op; ?>" 