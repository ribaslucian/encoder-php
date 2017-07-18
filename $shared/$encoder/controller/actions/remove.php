<?php

namespace actions;

trait Remove {

    /**
     * Ação genérica para remoção de registros de entidades.
     * 
     * @genericAction
     */
    public static function remove() {
        # definindo nome do modelo de requisição
        $model = singularize(static::nameFull());
        
        # verificando se existe um modelo de requisição
        $e = model_request($model);
        
        if (!$e->nil()) {

            # verificando se foi informado o ID e se existe um registro referente
            if (empty($e->id) || $model::count("id = '$e->id'") <= 0)
                flash_e('Nenhum registro foi encontrado.') & go_paginate();

            $e->remove() ?
                flash('Dados removidos com sucesso.') :
                flash_w('Não foi possível remover os dados no momento. Por favor, tente novamente mais tarde.');
        }

        go_paginate();
    }

}
