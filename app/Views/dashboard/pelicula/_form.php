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

<div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input 
        type="text" name="titulo" id="titulo" 
        value="<?php echo old("titulo", $titulo); ?>"
        class="form-control"
    >
    <?php if(isset($validation->titulo) && $validation->titulo != ""): ?>
        <br>
        <br>
        <small class="error-message p-2"><?php echo $validation->titulo; ?></small>
    <?php endif ?>
</div>

<div class="mb-3">
    <label for="titulo" class="form-label">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">
        <?php echo old("descripcion", $descripcion); ?>
    </textarea>
    <?php if(isset($validation->descripcion) && $validation->descripcion != ""): ?>
        <br>
        <br>
        <small class="error-message p-2"><?php echo $validation->descripcion; ?></small>
    <?php endif ?>
</div>

<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría</label>
    <select name="categoria_id" id="categoria_id" class="form-control">
        <option value="">Seleccione una categoría</option>
        <?php foreach($categorias as $categoria): ?>
            <option 
                value="<?php echo $categoria->id; ?>"
                <?php 
                    if(old("categoria_id") == $categoria->id) {
                        echo "selected";
                    } elseif(isset($pelicula->categoria_id) && $pelicula->categoria_id == $categoria->id) {
                        echo "selected";
                    }
                ?>
            ><?php echo $categoria->titulo; ?></option>
        <?php endforeach ?>
    </select>
    <?php if(isset($validation->categoria_id) && $validation->categoria_id != ""): ?>
        <br>
        <br>
        <small class="error-message p-2"><?php echo $validation->categoria_id; ?></small>
    <?php endif ?>
</div>
<?php if(isset($pelicula->id)): ?>
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen</label>
        <input type="file" name="imagen" id="imagen" class="form-control">
    </div>
<?php endif ?>

<input type="submit" value="<?php echo $op; ?>" class="btn btn-success">