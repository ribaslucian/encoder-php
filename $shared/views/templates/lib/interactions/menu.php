<div class="dropdown centered grey-text">
    <div class="title">
        <i class="material-icons">&#xE913;</i>
    </div>

    <div class="menu top center horizontal hover bold">
        <div class="item small-text-2 grey-text">
            <?php if ($model->updated) { ?>
                Editado em: <?php echo show_date_hour($model->updated); ?>
            <?php } else { ?>
                Ainda não foi editado
            <?php } ?>
        </div>

        <div class="item small-text-2">
            Criado em: <?php echo show_date_hour($model->created); ?>
        </div>
    </div>
</div>