<div style="color: #323e41;">
    - Olá
    <span style="font-size: 18px; color: black;">
        <b><?php echo $user->email; ?></b>!
    </span>!
</div>

<br/>

<i style="color: #787878;">
    - Sua conta foi bloqueada devido ao número excessivo de vezes que alguém tentou se conectar.
</i>

<br/>

<div style="color: #323e41; padding: 15px 20px;">
    Clique no endereço abaixo para desbloquear sua conta:

    <br/>
    <br/>

    <a href="<?php echo url('/visitor/users/unlock_account?hash=' . $user->hash_unlock_account); ?>" style="color: blue;">
        <b>
            <!--&#8702;-->
            &#8702; Clique aqui
        </b>
    </a>
</div>