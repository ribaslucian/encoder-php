<br/>

<div class="centered ">
    <a href="<?php echo url_auth('/users/sign_up'); ?>" class="green-text text-darken-2" style="border: 2px solid green; padding: 10px 20px;">
        Ainda não é usuário ?
        &nbsp; <b>CADASTRE-SE AGORA</b>
    </a>
</div>
<br/>

<p class="center-align grey-text">
    Para acessar o sistema, informe suas crendenciais abaixo.
</p>

<hr/>
<br/>

<?php
echo form_open(array(
    '@entity' => $user,
    'class' => 'encrypt_password',
    'attributes' => 'autocomplete="OFF"'
));
?>

<div class="row">
    <div class="col s12">

        <?php
        echo field_icon('&#xE0BE;', 'email', 'Email: *', array(
            'type' => 'email',
            'required' => true,
            'placeholder' => 'loja@liv.com',
            'maxlength' => 64,
            'autofocus' => 'autofocus',
            'attributes' => 'autocomplete="OFF"'
        ));
        ?>
    </div>

    <div class="col s7">
        <?php
        echo field_icon('&#xE897;', 'password', 'Senha: *', array(
            'type' => 'password',
            'required' => true,
            'placeholder' => '*****',
            'attributes' => 'autocomplete="OFF"'
        ));
        ?>
    </div>

    <div class="col s5">

        <button type="submit" name="action" class="btn waves-effect waves-light btn-large blue darken-2">
            <span class="white-text" style="top: -7px; position: relative;">
                Entrar
            </span>

            &nbsp;&nbsp;
            <i class="material-icons">&#xE879;</i>
        </button>
    </div>
</div>

<hr/>

<div class="centered" style="padding: 0 5%;">
    <div class="dropdown">
        <div class="title grey-text bold small-text-3">
            <b class="text-small relative" style="top: -8px;">
                PRECISO DE AJUDA
            </b>

            <i class="material-icons smooth-text"></i>
        </div>

        <div class="menu top center horizontal" style="display: none;">

            <a href="<?php echo url_auth('/users/forgot_password'); ?>" class="item icon">
                <i class="material-icons">&#xE887;</i>
                <b class="grey-text text-darken-4">Esqueci</b> Minha Senha
            </a>

            <a href="<?php echo url_auth('/users/not_receive_confirmation'); ?>" class="item icon">
                <i class="material-icons">&#xE862;</i>
                <b class="grey-text text-darken-4">Confirmar</b> Minha Conta
            </a>

            <a href="<?php echo url_auth('/users/help_unlock_account'); ?>" class="item icon">
                <i class="material-icons">&#xE898;</i>
                <b class="grey-text text-darken-4">Desbloquear</b> Minha Conta
            </a>
        </div>
    </div>
</div>

<?php echo form_close(); ?>
