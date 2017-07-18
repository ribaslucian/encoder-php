<?php

namespace actions;

trait Paginate {

    /**
     * Generic Paginate Action.
     * 
     * @genericAction
     */
    public static function paginate() {
        
        # definindo nome das entidades atuais
        if (property_exists(static::nameFull(), 'model'))
            $model = static::$model;
        else
            $model = singularize(static::name());

        # se existe uma view para o modelo, vamos paginar em seu respeito
        $view = str_replace($model::name(), 'views\\' . $model::name(), $model);
        if (has_class($view))
            $model = $view;

        # definindo opções de busca de paginação
        $options = array();
        if (property_exists(static::nameFull(), 'paginate_options'))
            $options = static::$paginate_options;

        # definindo condições do filtro
        if (property_exists(static::nameFull(), 'filter'))
            $filter = model_request(static::$filter, 'get');
        else
            $filter = model_request($model::nameFilter(), 'get');
        
        if (!$filter->nil())
            $options['where'] = $filter->conditions();
        
        set('entities', $model::paginate($options));

        # verificando se foi informado uma página e se ela é valida
        if (data('page', 'get') !== null)
            if (!paginate_page_exists(data('page')))
                flash_w('Página inválida.') & go_paginate();

        # definindo filtro de registros referente ao model do controller atual
        set('filter', $filter);
    }

}
