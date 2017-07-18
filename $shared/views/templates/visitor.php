<!DOCTYPE html>
<html lang="pt-BT">
    <head>
        
        <!-- Incluimos HTML5 em navegadores antigos -->
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- codificação da página -->
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title>Liv &minus; Comerciantes</title>

        <!-- informações básicas -->
        <meta name="description" content="Layout padrão de uma página HTML desenvolvida com o framework Enconder-PHP">
        <meta name="author" content="Lucian Rossoni Ribas">

        <?php echo assets(); ?>
    </head>

    <body ng-app="Liv" class="grey lighten-4">
        <!-- GIF apresentando no enquanto a página é renderizada ou uma nova página é acessada. -->
        <?php echo loader(); ?>

        <!-- Exibição das mensagens flash sem escopo definidas na sessão. -->
        <?php echo flashes(); ?>

        <!-- Inclusão da View referenciada pela Ação acessada pelo usuário -->
        <?php echo view($_view, $_vars); ?>
        
        <!-- Tempo estimado levado para interpretação da aplicação. Exibido no rodapé da página -->
        <?php echo timer(); ?>
    </body>
</html>
