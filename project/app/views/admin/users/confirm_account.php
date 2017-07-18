<div class="row vertical align">

    <!-- l:desktop m:tablet s:mobile -->
    <div class="col s4 m2 l3">&nbsp;</div>

    <div class="col s12 m8 l6">
        <h1 class="center-align">
            <i class="material-icons green-text" style="font-size: 180%;">&#xE7F2;</i>

            <div>
                QUASE LÁ!
            </div>
        </h1>

        <h6 class="center-align grey-text info_painel">
            Resta apenas confirmar sua conta.

            <br/>
            <br/>
            Para lhe ajudar com isso, enviamos um e-mail para 
            <span class="blue-text text-darken-3"><b>&lt;<?php echo $user->email; ?>&gt;</b></span>
        </h6>

        <br/>
        
        <p class="center-align orange-text text-small small-text-3 bold">
            <i class="material-icons relative orange-text large-text-10" style="bottom: -5px;">&#xE88F;</i>
            VERIFIQUE SUA LIXEIRA OU CAIXA DE SPAN

            <br/>
            <br/>

            <a href="<?php echo url_auth('/users/not_receive_confirmation'); ?>" class="center-align">
                <u>Não Recebi o E-mail</u>
            </a>
        </p>
        
        <br/>
        <hr/>

        <a href="<?php echo url(); ?>" class="pull-left text-small bold">
            <i class="material-icons">&#xE5C4;</i>

            <span class="relative" style="top: -8px;">
                Retornar
            </span>
        </a>
    </div>
</div>