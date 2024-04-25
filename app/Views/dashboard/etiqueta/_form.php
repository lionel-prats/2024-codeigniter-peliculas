<?php 
    $validation = session()->getFlashdata('validation');
    // bloque para que no rompa el form de edicion por errores de validacion
    $titulo = "";
    if(isset($etiqueta) && isset($etiqueta->titulo)) {
        $titulo = $etiqueta->titulo;
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
    <label for="categoria_id" class="form-label">Categoría</label>
    <select name="categoria_id" id="categoria_id" class="form-control">
        <option value="">Seleccione una categoría</option>
        <?php foreach($categorias as $categoria): ?>
            <option 
                value="<?php echo $categoria->id; ?>"
                <?php 
                    if(old("categoria_id") == $categoria->id) {
                        echo "selected";
                    } elseif(isset($etiqueta->categoria_id) && $etiqueta->categoria_id == $categoria->id) {
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
<input type="submit" value="<?php echo $op; ?>" class="btn btn-success"> 