<?php

namespace actions;

trait Edit {

    /**
     * Ação genérica para efetuar a edição de registros.
     * 
     * @genericAction
     */
    public static function edit() {
        $id = data('id');

        # verificando se foi informado o ID do registro.
        if (empty($id))
            flash_e('Nenhum identificador foi encontrado.') & go_paginate();

        # definindo nomeações das entidades de controle de relacionamento
        $model = singularize(static::nameFull());
        $controller = strtolower(static::name());

        # buscando registro puro pelo id.
        $model_raw = $model::byId($id);
        
        # verificando se o registro foi encontrado.
        if ($model_raw->nil())
            flash_e('Nenhum registro foi encontrado.') & go_paginate();

        # obtendo modelo de dados enviado pelo usuário
        $m = model_request($model);

        # verificando se foi enviado algum dado de formulário
        if (!$m->nil()) {
            $m->id = $id;

            if ($m->valid()) {
                if ($m->edit())
                    flash('Dados editados com sucesso.');
                else
                    flash_w('Não foi possível salvar os dados no momento. Por favor, tente novamente mais tarde.');

                go_paginate();
            } else
                flash_e('Verifique os dados do formulário.');
        }

        # definindo váriavel na visão correpondente ao modelo de requisição.
        set('entity', $m);
        set('entity_raw', $model_raw);
    }

}
