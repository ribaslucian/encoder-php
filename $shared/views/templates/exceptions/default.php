<div class="container">
    <h3 class="center-align">
        <span style="background: yellow;">
            <?php echo $exception->getMessage(); ?>
        </span>

        <br/>

        <small class="grey-text" style="font-size: 35%;">
            <?php echo $exception->getFile(); ?>
            | <b>Linha:</b>
            <?php echo $exception->getLine(); ?>
        </small>
    </h3>

    <small>
        <b><?php echo get_class($exception); ?></b> 
        Exception in <?php echo $exception->getTraceAsString(); ?>
    </small> 
</div>