<?php echo form_open($entity); ?>

<div class="row">
    <div class="row">
        <div class="input-field col s12">
            <?php
            echo field_icon('&#xE0BE;', 'email', 'E-mail: *', array(
                'required' => true,
                'type' => 'email'
            ));
            ?>
        </div>
    </div>

    <br/>

    <div style="font-size: 90%;">
        <div class="blue-text left-align">
            <i class="material-icons">&#xE88F;</i>
            <b class="relative" style="top: -7px;">INFORMAÇÃO</b>
        </div>

        <p class="grey-text center-align info_painel">
            Enviaremos para seu e-mail as instruções para confirmar sua conta.

            <br/>
            <small class="amber-text text-accent-4">
                <b>VERIFIQUE SUA CAIXA DE SPAN/LIXEIRA!</b>
            </small>
        </p>
    </div>

    <br/>
    <br/>

    <?php echo element('form/footer', array('cancel_url' => url('/'))); ?>
</div>
<?php echo form_close(); ?>