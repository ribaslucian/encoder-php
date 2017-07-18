<div class="row vertical align">
    <div class="col s4 m2 l4">&nbsp;</div>

    <div class="col s12 m8 l4">

        <div class="white" style="padding: 30px">
            <div class="card-image">
                <h4>
                    <b class="grey-text text-darken-3">
                        Renovar Minha Senha
                    </b>
                </h4>
            </div>

            <div class="card-content center-align" style="padding-top: 0;">

                <br/>
                <div class="grey-text">
                    <b>Olá</b>
                    <b class="large-text-5 black-text">
                        <?php echo $user->email; ?>
                    </b>

                    <br/>
                    <br/>
                    <div class="small-text-3">
                        Preecha os campos abaixo para renovar sua senha.
                    </div>
                </div>

                <br/>

                <?php echo partial('forms/password_renew', array('entity' => $user)); ?>
            </div>
        </div>        
    </div>
</div>
