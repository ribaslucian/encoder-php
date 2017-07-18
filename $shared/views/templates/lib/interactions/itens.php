<div class="item unclick bold small-text-2 blue-text" style="text-align: center !important; ">
    Criado em: <?php echo show_date_hour($entity->created); ?>
</div>

<div class="item unclick small-text-2 orange-text bold" style="text-align: center !important;">
    <?php if (isset($model->updated)) { ?>
        Editado em: <?php echo show_date_hour($entity->updated); ?>
    <?php } else { ?>
        Não editado
    <?php } ?>
</div>