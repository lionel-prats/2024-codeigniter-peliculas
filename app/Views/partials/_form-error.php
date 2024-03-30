<?php if(session("validation")): ?>
    <div class="error-message">
        <?php 
            echo session("validation"); 
            // esta accion imprime literalmente la plantilla vvv 
            // /vendor/codeigniter4/framework/system/Validation/Views/list.php
            // la podemos modificar
        ?>
    </div>
    <br>
<?php endif ?>