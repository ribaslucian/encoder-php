<?php

namespace actions;

trait GroupRemove {

    /**
     * Ação genérica para remoção de um ou mais registros de entidades.
     * 
     * @genericAction
     */
    public static function group_remove() {
        
        # definindo nome do modelo de requisição
        if (property_exists(static::nameFull(), 'model'))
            $model = static::$model;
        else
            $model = singularize(static::nameFull());

        # verificando se existe um modelo de requisição
        $e = model_request($model);

        if (!$e->nil()) {
            
            $group_delete = json_decode($e->group);

            $model::begin();
            foreach ($group_delete as $id => $status) {
                if ($status)
                    $model::delete("id = $id");
            }

            if ($model::commit())
                flash('Registros deletados com sucesso.');
            else
                flash_e('Erro ao deletar os registros.');
        }

        go_paginate();
    }

}
