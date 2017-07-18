<?php

namespace actions;

trait Add {

    /**
     * Ação genérica para efetuar o registro de entidades.
     * 
     * @genericAction
     */
    public static function add() {

        # obtendo modelo de requisição baseado no nome do controlador atual.
        $m = model_request(singularize(static::nameFull()));

        # verificamos se o usuário informou algum campo do formulário.
        if (!$m->nil()) {

            # validamos os valores informados pelo usuário.
            if ($m->valid()) {

                # salvamos os dados informados pelo usuário.
                $m->save() ?
                    flash('Os dados foram inseridos com sucesso.') :
                    flash_w('Não foi possível salvar o registro no momento. Por favor, tente novamente mais tarde.');

                # redirecionamos para a tela de paginação.
                go_paginate();
            } else
                flash('Verique os dados do formulário.', 'error');
        }

        # definindo váriavel na visão correpondente ao modelo de requisição.
        set('entity', $m);
    }

}
