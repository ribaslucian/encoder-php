<input

    <?php
    # ID do Input
    # primariamente pela variável {$id}, caso exista;
    # secundáriamente pela entidade {$entity} definida para o input;
    ?>
    <?php if (isset($id)) { ?>
        id="<?php echo $id; ?>"
    <?php } else if (isset($entity)) { ?>
        id="<?php echo $entity->html()->id($field); ?>"
    <?php } ?>


    <?php
    # Nome do Input
    # primariamente pela variável {$name}, caso exista;
    # secundáriamente pela entidade {$entity} definida para o input;
    # terceáriamente pela variável {$field}, caso não seja nula.
    ?>
    <?php if (isset($name)) { ?>
        name="<?php echo $name; ?>"
    <?php } else if (isset($entity)) { ?>
        name="<?php echo $entity->html()->name($field, $belongs_to); ?>"
    <?php } else if ($field) { ?>
        name="<?php echo $field; ?>"
    <?php } ?>


    <?php
    # Valor do Input
    # Campos do tipo {password} não serão autocompletados, a não ser 
    # que o valor esteja definido manualmente no escopo {$options} da função. 
    ?>
    <?php if ($type == 'password' && isset($value)) { ?>
        value="<?php echo $value; ?>"
    <?php } else if ($type != 'password') { ?>
        <?php
        # definimos o valor do input primariamente pela variável {$value} se 
        # estiver definida; secundáriamente pela valor da entidade {$entity} se 
        # estiver  definida; caso nenhumas das opções estiver definida {$value} 
        # será {null}
        ?>
        <?php if ($value = isset($value) ? $value : (isset($entity) ? $entity->html()->value($field) : null)) { ?>
            value="<?php echo $value; ?>"
        <?php } ?>
    <?php } ?>


    <?php
    # definindo opções básicas do input
    ?>
    type="<?php echo $type; ?>"
    <?php echo isset($class) ? "class='$class'" : ''; ?>
    <?php echo isset($placeholder) ? "placeholder='$placeholder'" : ''; ?>
    maxlength="<?php echo $maxlength; ?>"
    <?php echo isset($minlength) ? "minlength='$minlength'" : ''; ?>


    <?php
    # definindo opções que não necessariamente precisam de um valor
    ?>
    <?php echo isset($autofocus) ? 'autofocus' : ''; ?>
    <?php echo isset($required) ? 'required' : ''; ?>
    <?php echo isset($disabled) ? 'disabled' : ''; ?>


    <?php
    # se existe a variável {$atributes} significa que há mais 
    # atributos não previsíveis definidos, vamos apresentar eles.
    echo isset($attributes) ? $attributes : '';
    ?>
    />