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

        <title>Liv &minus; Estacionamento</title>

        <!-- informações básicas -->
        <meta name="description" content="Layout de impressão de uma página HTML desenvolvida com o framework Enconder-PHP">
        <meta name="author" content="Lucian Rossoni Ribas">

        <?php echo assets(); ?>
    </head>

    <body>

        <!-- Inclusão da View referenciada pela Ação acessada pelo usuário -->
        <?php echo view($_view, $_vars); ?>

        <script>
            $(document).ready(function () {
//                window.print();
//                setTimeout(window.close, 0);
            });
        </script>
    </body>
</html>