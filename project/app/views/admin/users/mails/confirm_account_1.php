<div style="color: #323e41;">
    - Olá
    <span style="font-size: 18px; color: black;">
        <b><?php echo $user->email; ?></b>!
    </span>
</div>

<br/>

<div style="color: 3c763d; background: #dff0d8; padding: 15px 20px; text-transform: u">
    <b>
        <span style="font-size: 120%;">
            SUCESSO!
        </span>
    </b>
     Seu registro foi efetuado <br/>
</div>

<br/>

<div style="color: #323e41; padding: 15px 20px;">
    Resta apenas confirmar sua conta clicando no endereço abaixo:

    <br/>
    <br/>

    <a href="<?php echo url('/visitor/users/confirm_account?hash=' . $user->hash_confirm_account); ?>" style="color: blue;">
        <b>
            &#8702; Clique aqui
        </b>
    </a>
</div>