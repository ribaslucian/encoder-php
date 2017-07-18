<div class="row vertical align animated fadeInDown">
    <div class="col s4 m2 l4">&nbsp;</div>

    <div class="col s12 m8 l4">
        <div class="white" style="padding: 30px; border-radius: 5px;">

            <h4 class="bold">Confirmar Minha Conta</h4>
            <p class="center-align grey-text">
                Para <b>confirmar sua conta</b> informe seu e-mail no campo abaixo:
            </p>

            <div class="card-content" style="padding-top: 0;">
                <?php echo partial('forms/not_receive_confirmation', array('entity' => $user)) ?>
            </div>
        </div>
    </div>
</div>