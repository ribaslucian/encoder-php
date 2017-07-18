<nav class="<?php echo menu_color(); ?>">
    <div class="container">
        <div class="nav-wrapper">

            <ul class="left">
                <li style="padding-left: 10px; padding-right: 10px;">
                    <a href="<?php echo url_auth(); ?>">
                        <span class="bold large-text-6" style="position: relative; ">
                            Liv
                        </span>
                    </a>
                </li>

                <li style="padding-left: 10px; padding-right: 10px;">
                    <div class="dropdown large">
                        <div class="title">
                            <i class="material-icons white-text">&#xE5D2;</i>
                        </div>

                        <div class="menu bottom center horizontal">
                            <a href="<?php echo url_auth('/users/paginate'); ?>" class="item icon bold">
                                <i class="material-icons">&#xE7FF;</i>
                                Usuários
                            </a>
                            
                            <div class="item dropdown icon" style="width: 150px;">
                                <div class="title bold">
                                    <i class="material-icons">&#xE875;</i>
                                    Opções

                                    <i class="material-icons">&#xE315;</i>
                                </div>

                                <div class="menu right vertical">
                                    <a href="#" class="item icon bold">
                                        <i class="material-icons">&#xE875;</i>
                                        Opção
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <ul class="right">
                <li class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Desconectar do sistema.">
                    <a href="<?php echo url_auth('/users/logout'); ?>" confirm="Você quer sair do sistema ?">
                        <i class="material-icons left">&#xE879;</i>
                        <b>Sair</b>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
