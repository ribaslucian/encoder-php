<div class="animated fadeInDown">
    <?php if (!empty($entities)) { ?>
        <div class="grey lighten-5"> 
            <br/>
            <br/>

            <div class="container">
                <h1 class="bold grey-text text-darken-2">
                    Usuários
                </h1>

                <p class="grey-text">
                    Está é a tela de gerenciamento de usuários. Aqui você pode <b>adicionar</b>, 
                    <b>remover</b> ou <b>editar</b> os dados de usuários específicos. Você 
                    pode também <b>ordernar</b> os registros listados abaixo ou efetuar uma 
                    <b>busca personalizada</b> para obter apenas os registros que deseja.
                </p>
            </div>

            <br/>
        </div>

        <div class="paginate animated fadeInLeft">
            <br/>
            <br/>

            <div class="container">
                <?php echo partial('tables/paginate', array('entities' => $entities)); ?>
            </div>

            <br/>
            <br/>
            <hr class="no margin"/>
            <br/>
            <br/>

            <div class="container">
                <?php echo element('paginate/traveler'); ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="animated fadeInLeft">
            <?php
            echo element('lib/no_records', array(
                'button' => 'Criar',
                'message' => 'Ainda não há <b class="black-text">Usuário</b> registrado no sistema.'
            ));
            ?>
        </div>
    <?php } ?>
</div>

<?php
// incluindo Modal do formulário de buscas personalizadas
//echo partial('modal/search', array('entity' => $filter));
//
//// listando modals para visualização dos dados das pessoas
//foreach ($entities as $e)
//    echo partial('modal/show_one', array('entity' => $e));
?>
