<hr/>

<div class="centered">
    <br/>

    <a 
        href="<?php echo isset($cancel_url) ? $cancel_url : url_action('paginate'); ?>" 
        class="<?php echo isset($cancel_class) ? $cancel_class : ''; ?> waves-effect waves-light btn-large left bold grey"
        >
        Cancelar
    </a>

    <div class="left"  style="margin-left: 5px;">
        <?php echo submit(isset($submit_text) ? $submit_text : 'Enviar', 'centered'); ?>
    </div>
</div>