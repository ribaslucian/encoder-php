<label

    <?php
    // Apenas inserimos o "for" na label, se for informado a $entity da label.
    // Verificamos se {$field} foi passado, se não passamos {null} para o ID.
    ?>
    <?php if (isset($entity)) { ?>
        for="<?php echo $entity->html()->id(isset($field) ? $field : null); ?>" 
    <?php } ?>

    class="bold"

    <?php
    // se existe a variável {$atributes} significa que há mais atributos
    // não previsíveis definidos para esta label, vamos apresentar eles.
    echo isset($attributes) ? $attributes : '';
    ?>
    >

    <?php
    // O texto da label será a variável $text, se não definida, será o 
    // próprio {$field} se não será apenas "label".
    echo isset($text) ? $text : (isset($field) ? $field : 'label');
    ?>

</label>