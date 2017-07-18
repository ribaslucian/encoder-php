<?php
/**
 * @element NoRecords
 * 
 * {NoRecords} tem como objetivo generalizar uma página de registros onde não
 * há nenhum registro inserido para tal entidade. Apenas será exibida uma 
 * mensagem e um botão para inserir um novo registro.
 */
?>

<div class="vertical align">

    <?php // mensagem que será exibida ?>
    <h5 class="centered grey-text">
        <?php echo $message ?>
    </h5>

    <br/>
    <br/>
    <br/>

    <?php
    // Botão para inserção do registro. 
    // Na ausência da variável {$button}, seu texto será "Registrar";
    // Na ausência da variável {$url}, vamos definir como para ação {add};
    ?>
    <a href="<?php echo url_action((isset($action) ? $action : 'add')); ?>" class="waves-effect waves-light btn-large bold centered">
        <?php echo isset($button) ? $button : 'Registrar'; ?>
    </a>
</div>