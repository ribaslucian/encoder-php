<?php

namespace middleware;

trait RequestValidations {

    public static function beforeAction($set_get_or_call = null) {
        # Efetuar o log de acesso do com as informaçõs básicas do usuário.
        log_write('access', json(array(
            'host_name' => client_name(),
            'accessed_in' => date('d/m/Y H:i:s'),
            'ip' => ip(),
            'url' => url_current(),
            'is_ajax' => ($ajax = is_ajax()) ? 'true' : 'false',
            'get' => $_GET,
            'post' => $_POST,
            'session' => session_get(),
        )));

        # Verificamos se a requisição atual está utilizando o método
        # ajax. Caso esteja vamos impedir a continuação do código.
        if ($ajax)
            d('encoder responds > that ugly, never pass data in this way.');

        # Verificando o controller da requisição atual está localizado
        # em uma área nomeada diferente do usuário conectado atual.
        # Ou seja, caso um usuário tente entrar na área de outro, redirecionamo-os.
        allow_if_my_area();

        # Caso a requisição atual esteja utilizando o método post. Vamos
        # verifica se a mesma possui um código CSFR válido. Caso não tenha,
        # vamos manda-lô para a página inicial da área do usuário.
        if (is_post() && !csfr_validation())
            flash('Requisição não solicitada.', 'warning') & go();

        parent::beforeAction();
    }

}
