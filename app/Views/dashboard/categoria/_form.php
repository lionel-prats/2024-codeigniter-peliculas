<label for="titulo">Título</label>
<input 
    type="text" name="titulo" id="titulo" 
    value="<?php echo old("titulo", $categoria["titulo"]); ?>"
>
<br>
<br>
<input type="submit" value="<?php echo $op; ?>" 