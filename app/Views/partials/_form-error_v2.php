<?php if(session("validation")): ?>
    <?php foreach(session("validation")/* ->getErrors() */ as $error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>
<?php endif ?>