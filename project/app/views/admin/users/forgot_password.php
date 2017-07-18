<div class="row vertical align ">
    <div class="col s4 m2 l4">&nbsp;</div>

    <div class="col s12 m8 l4 white">
        <div style="padding: 30px; border-radius: 5px;">
            <h4 class="bold">Renovar Minha Senha</h4>
            <p class="center-align grey-text">
                Para <b>renovar sua senha</b> informe seu e-mail no campo abaixo:
            </p>

            <?php echo partial('forms/forgot_password', array('entity' => $user)); ?>
        </div>
    </div>
</div>