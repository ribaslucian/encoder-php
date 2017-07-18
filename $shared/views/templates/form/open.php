<form

    enctype="multipart/form-data"

    <?php
    // A URL do formulário por padrão será a URL atual da aplicação. Será 
    // sobreescrita apenas se informado uma variável {$route}.
    ?>
    action="<?php echo isset($url) ? $url : url() ?>"

    <?php
    // O método do formulário por padrão será a POST. Será sobreescrito apenas 
    // se informado uma variável {$method}.
    ?>
    method="<?php echo isset($method) ? $method : 'post' ?>"

    <?php echo isset($class) ? "class='$class'" : ''; ?>
    <?php echo isset($style) ? "style='$style'" : ''; ?>

    <?php
    // se existe a variável {$atributes} significa que há mais atributos
    // não previsíveis definidos para esta label, vamos apresentar eles.
    echo isset($attributes) ? $attributes : '';
    ?>
    
    accept-charset="UTF-8"
>

<?php echo csfr(); ?>