<div class="row vertical align">

    <div class="col l4 m8 s12 offset-l4 offset-m2 white center-align" style="padding: 30px">
        <h3 class="grey-text text-darken-3">
            <b>Criar Conta</b>
        </h3>

        <p class="grey-text center-align">
            Para se cadastrar no sistema basta preencher os campos abaixo:
        </p>

        <br/>

        <?php
        echo partial('forms/sign_up', array(
            'entity' => $user
        ));
        ?>
    </div>
</div>
