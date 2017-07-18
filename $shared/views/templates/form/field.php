<div class="input-field">

    <?php if (isset($icon)) { ?>
        <i class="material-icons prefix grey-text"><?php echo $icon; ?></i>
    <?php } ?>
    
    <?php if (!isset($label)) { ?>
        <?php echo label(get_defined_vars()); ?>
    <?php } ?>

    <?php echo input(get_defined_vars()); ?>

    <?php echo input_message($entity, $field); ?>
</div>