<div class="center-align vertical align">
    <h1>
        <small>
            Olá
        </small>

        <b>
            <?php echo $name; ?>!
        </b>
    </h1>

    <h5 class="grey-text large-text-2">
        Você está na área <b>Admin</b> do Encoder
    </h5>
    
    <br/>
    
    <a href="<?php echo url_auth('/users/logout'); ?>" class="bold">
        Sair
    </a>
</div>