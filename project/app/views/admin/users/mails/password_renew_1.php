<div style="color: #323e41;">
    - Olá
    <span style="font-size: 18px; color: black;">
        <b><?php echo $user->email; ?></b>!
    </span>
</div>

<br/>

<div style="color: #323e41; padding: 15px 20px;">
    Clique no endereço abaixo para renovar a sua senha:

    <br/>
    <br/>

    <a href="<?php echo url('/visitor/users/password_renew?hash=' . $user->hash_password_renew); ?>" style="color: blue;">
        <b>
            <!--&#8702;-->
            &#8702; Clique aqui
        </b>
    </a>
</div>