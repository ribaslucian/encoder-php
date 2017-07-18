<div class="row vertical align animated fadeInDown">
    <div class="col s4 m2 l4">&nbsp;</div>

    <div class="col s12 m8 l4">
        <div class="white" style="padding: 30px; border-radius: 5px;">
            <h4 class="bold">Desbloquear Minha Conta</h4>
            <p class="center-align grey-text">
                Para <b>desbloquear sua conta</b> informe seu e-mail no campo abaixo:
            </p>

            <div class="card-content" style="padding-top: 0;">
                <?php echo form_open(array('@entity' => $user, 'route' => 'users/help_unlock_account', 'class' => 'encrypt_password')); ?>

                <div class="row">
                    <div class="row">
                        <div class="input-field col s12" style="margin-top: 20px;">
                            <?php
                            echo field_icon('&#xE0BE;', 'email', 'E-mail: *', array(
                                'required' => true,
                                'type' => 'email'
                            ));
                            ?>
                        </div>
                    </div>

                    <div style="font-size: 90%;">
                        <div class="blue-text left-align">
                            <i class="material-icons">&#xE88F;</i>
                            <b class="relative" style="top: -7px;">INFORMAÇÃO</b>
                        </div>

                        <p class="grey-text center-align info_painel">
                            Enviaremos para seu e-mail as instruções para desbloquear sua conta.
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
                </form>
            </div>
        </div>
    </div>
</div>
