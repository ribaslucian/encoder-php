<form 
    style="display: inline;"
    method="post"
    action="<?php echo url(@$url); ?>"
    >
    <?php echo csfr(); ?>
    <?php echo $content; ?>
    
    <submitter>
        <?php echo $submitter; ?>
    </submitter>
</form>