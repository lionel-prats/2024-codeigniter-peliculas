<?php if(session("mensaje")): ?>
    <div class="alert alert-dismissible fade show <?php echo session("alert-bg"); ?>">
        <?php echo session("mensaje"); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>