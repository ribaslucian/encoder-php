<nav class="<?php echo menu_color(); ?>">
    <div class="container">
        <ul class="left hide-on-med-and-down">
            <li style="padding-left: 10px; padding-right: 10px;">
                <a href="<?php echo url_auth(); ?>">
                    <i class="material-icons left relative" style="bottom: -18px;">&#xE84F;</i>
                    <span class="bold large-text-3 relative" style="top: -1px;">
                        M Y S T O R E
                    </span>
                </a>
            </li>

            <li class="<?php echo menu_active('sign_up'); ?>">
                <a href="<?php echo menu_url('sign_up'); ?>" class="bold">
                    Cadastre-se
                </a>
            </li>

            <li class="<?php echo menu_active('forgot_password'); ?>">
                <a href="<?php echo menu_url('forgot_password'); ?>" class="small-text-3 bold">
                    Esqueci minha senha
                </a>
            </li>

            <li class="<?php echo menu_active('not_receive_confirmation'); ?>">
                <a href="<?php echo menu_url('not_receive_confirmation'); ?>" class="small-text-3 bold">
                    Confirmar minha conta
                </a>
            </li>
        </ul>

        <ul class="right hide-on-med-and-down">
            <li class="<?php echo menu_active('sign_in'); ?>">
                <a href="<?php echo menu_url('sign_in'); ?>" class="bold">
                    <i class="material-icons left relative" style="bottom: -20px;">&#xE879;</i>
                    Entrar
                </a>
            </li>
        </ul>

        <ul id="slide-out" class="side-nav">
            <li class="<?php echo menu_active('sign_up'); ?>">
                <a href="<?php echo menu_url('sign_up'); ?>" class="bold">
                    <i class="material-icons left relative" style="bottom: -20px;">&#xE85E;</i>
                    Cadastre-se
                </a>
            </li>

            <li class="<?php echo menu_active('help_password_renew'); ?>">
                <a href="<?php echo menu_url('help_password_renew'); ?>" class="small-text-3 bold">
                    Esqueci minha senha
                </a>
            </li>

            <li class="<?php echo menu_active('help_confirm_account'); ?>">
                <a href="<?php echo menu_url('help_confirm_account'); ?>" class="small-text-3 bold">
                    Confirmar minha conta
                </a>
            </li>

            <li class="<?php echo menu_active('sign_in'); ?>">
                <a href="<?php echo menu_url('sign_in'); ?>" class="bold">
                    <i class="material-icons left relative" style="bottom: -20px;">&#xE879;</i>
                    Entrar
                </a>
            </li>
        </ul>

        <a href="#" data-activates="slide-out" class="button-collapse">
            <i class="material-icons left relative" style="font-size: 180%;">&#xE84F;</i>

            <span class="bold relative" style="top: -11px;">
                M Y S T O R E
            </span>

            <i class="material-icons" style="margin-left: 15px; font-size: 250%;">&#xE5D2;</i>
        </a>
    </div>
</nav>
