<br/>

<table class="hover">
    <thead>
        <tr>
<!--            <th>Nome</th>
            <th class="center-align">CPF</th>
            <th>Contato</th>
            <th>Endereço</th>-->
            <th class="tnr" center colspan="2">E-mails</th>
            <th class="tnr">Interações</th>
            <th class="tnr">Contadores</th>
            <th class="tnr">Hierarquia</th>
            <th class="tnr">Status</th>

            <td class="center-align">
                <div class="dropdown">
                    <div class="title">
                        <i class="material-icons">&#xE5D4;</i>
                    </div>

                    <div class="menu left center vertical">

                        <a href="<?php echo url_auth('/users/sign_up'); ?>" class="item icon">
                            <i class="material-icons">add</i>
                            <small>Adicionar</small>
                        </a>

                        <div class="item icon form-search-button-search">
                            <i class="material-icons">&#xE8B6;</i>
                            <small>Buscar</small>
                        </div>

                        <div class="item dropdown icon">

                            <div class="title">
                                <i class="material-icons">&#xE314;</i>
                                <small>Ordenar</small>
                            </div>

                            <div class="menu left center vertical">
                                <?php echo paginate_link_sort('id', '<small>ID</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('name', '<small>Nome</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('documentation', '<small>CPF</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('email', '<small>Email</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('phone', '<small>Telefone</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('address', '<small>Endereço</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('hash_password_renew', '<small>Email Red. de Senha</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('hash_confirm_account', '<small>Email Conf. de Conta</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('hash_unlock_account', '<small>Email Desb. de Conta</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('hierarchy', '<small>Hierarquia</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('active', '<small>Status</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('created', '<small>Data/Criação</small>', 'item icon') ?>
                                <?php echo paginate_link_sort('updated', '<small>Data/Edição</small>', 'item icon') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($entities as $u) { ?> 
            <tr>
                <?php echo element('paginate/line_number'); ?>

                <td class="center-align">
                    <?php echo $u->email; ?>
                </td>

                <td>
                    <div class="dropdown">
                        <div class="title grey-text bold">
                            <b class="text-small relative blue-text" style="top: -8px;">
                                Enviar e-mail para:
                            </b>

                            <i class="material-icons blue-text">&#xE5C5;</i>
                        </div>

                        <div class="menu top center horizontal">
                            <?php
                            echo element('button/post', array(
                                'url' => '/' . hierarchy() . '/users/email_password_renew',
                                'content' => '<input name="User[id]" value="' . $u->id . '" type="hidden" />',
                                'submitter' => '<div class="item">
                                        <small class="purple-text">' . format_limit_str($u->hash_password_renew) . '</small>
                                        <small>Redefinir Senha</small>
                                    </div>'
                            ));
                            ?>

                            <?php
                            echo element('button/post', array(
                                'url' => '/' . hierarchy() . '/users/email_confirm_account',
                                'content' => '<input name="User[id]" value="' . $u->id . '" type="hidden" />',
                                'submitter' => '<div class="item">
                                        <small class="purple-text">' . format_limit_str($u->hash_confirm_account) . '</small>
                                        <small>Confirmar Conta</small>
                                    </div>'
                            ));
                            ?>

                            <?php
                            echo element('button/post', array(
                                'url' => '/' . hierarchy() . '/users/email_unlock_account',
                                'content' => '<input name="User[id]" value="' . $u->id . '" type="hidden" />',
                                'submitter' => '<div class="item">
                                        <small class="purple-text">' . format_limit_str($u->hash_unlock_account) . '</small>
                                        <small>Desbloquear Conta</small>
                                    </div>'
                            ));
                            ?>
                        </div>
                    </div>
                </td>

                <td>
                    <small class="bold grey-text">
                        <?php echo $u->login_attempts; ?> Tentativas / <?php echo $u->login_count; ?> Efetuadas
                    </small>
                </td>

                <td>
                    <small class="purple-text"><i><b><?php echo $u->hierarchy; ?></b></i></small>
                </td>

                <td>
                    <?php if ($u->active == true || $u->active == 't') { ?>
                        <?php
                        echo element('button/post', array(
                            'url' => '/' . hierarchy() . '/users/unactive',
                            'content' => '<input name="User[id]" value="' . $u->id . '" type="hidden" />',
                            'submitter' => '
                                    <div confirm="Tem certeza que deseja Desativar este usuário ?">
                                        <i class="material-icons centered green-text cursor pointer">&#xE86C;</i>
                                    </div>
                                '
                        ));
                        ?>
                    <?php } else { ?>
                        <?php
                        echo element('button/post', array(
                            'url' => '/' . hierarchy() . '/users/active',
                            'content' => '<input name="User[id]" value="' . $u->id . '" type="hidden" />',
                            'submitter' => '
                                    <div confirm="Tem certeza que deseja Ativar este usuário ?">
                                        <i class="material-icons centered red-text cursor pointer">&#xE897;</i>
                                    </div>
                                '
                        ));
                        ?>
                    <?php } ?>
                </td>

                <td class="center-align">
                    <div class="dropdown centered">
                        <div class="title grey-text bold">
                            <i class="material-icons grey-text">&#xE5D4;</i>
                        </div>

                        <div class="menu top center horizontal">

                            <a href="<?php echo url_auth('/users/edit?id=' . $u->id); ?>" class="item icon">
                                <i class="material-icons">&#xE254;</i>
                                <small>Editar</small>
                            </a>

                            <?php
                            echo element('button/post', array(
                                'url' => '/visitor/users/remove',
                                'content' => '<input name="User[id]" value="' . $u->id . '" type="hidden" />',
                                'submitter' => '<div class="item icon" confirm="Tem certeza que deseja deletar este usuário ?">
                                        <i class="material-icons">&#xE5CD;</i>
                                        <small>Remover</small>
                                    </div>'
                            ));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<!--                <td class="center-align">
<?php // if ($u->address = json_decode($u->address)) { ?>
                        <div class="dropdown centered">
                            <div class="title grey-text bold">
                                <b class="text-small relative" style="top: -8px;">
                                    Endereço
                                </b>

                                <i class="material-icons grey-text">&#xE5C5;</i>
                            </div>

                            <div class="menu top center horizontal">

                                <a class="item unclick">
                                    <small>
<?php // echo $u->address->city; ?>
                                        -
<?php // echo $u->address->state; ?>
                                    </small>
                                </a>

                                <a class="item unclick">
                                    <small>
<?php // echo $u->address->street; ?>
                                        , 
<?php // echo $u->address->number; ?>
                                        -
<?php // echo @$u->address->complemento; ?>
                                    </small>
                                </a>

                                <a class="item unclick">
                                    <small>
<?php // echo $u->address->neighborhood; ?>
                                        -
<?php // echo $u->address->zipcode; ?>
                                    </small>
                                </a>
                            </div>
                        </div>
<?php // } else { ?>
                        <small class="bold grey-text">Indefinido</small>
<?php // } ?>
                </td>-->