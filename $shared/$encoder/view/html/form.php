<?php

class Form extends Object {

    /**
     * Valores cacheados não precisam ser referenciados novamente até mudança.
     * Estes valores são as opções informadas nos métodos geradores de HTML.
     * Podem ser atributos ou entidades de inputs.
     * 
     * @var array
     */
    private static $cache = array(
        'maxlength' => 92
    );

    /**
     * Abre ou inicia um formulário.
     * 
     * @param array $options [url, method, entity]
     * @return string HTML
     */
    public static function open($options = array()) {

        # se o parâmetro {$options} for um objeto, vamos verificar se 
        # representa um modelo da aplicação e cachear seu valor no formulário.
        if (is_object($options))
            $options = array('@entity' => $options);

        return element('form/open', static::cacheOptions($options));
    }

    /**
     * Fecha ou finaliza um formulário.
     * 
     * @return string HTML
     */
    public static function close() {
        return '</form>';
    }

    /**
     * Gera e anexa um código CSFR à um formulário qualquer.
     * 
     * @return string HTML input
     */
    public static function csfr() {
        return '<input type="hidden" name="csfr" value="' . Request::csfr() . '" />';
    }

    /**
     * Renderiza o elemento "_form/label" e passa o parâmetro {$options} para 
     * seu escopo, como variáveis.
     * 
     * @param string||array $options array(
     *      'entity' => object encoder\Model, 
     *      'field' => 'field', 
     *      'class' => 'my classes',
     *      'attributes' => 'attribute01="value01" attributes02="value="02"...',
     * ]
     * 
     * @return string Html label
     */
    public static function label($options = array()) {
        return element('form/label', static::cacheOptions($options, 'field'));
    }

    /**
     * Renderiza o elemento "input/field" e passa o parâmetro {$options} para 
     * seu escopo, como variáveis.
     * 
     * @param string $options array(
     *      'entity' => object encoder\Model, 
     *      'field' => 'field', 
     *      'class' => 'my classes',
     *      'attributes' => 'attribute01="value01" attributes02="value="02"...',
     * ]
     * 
     * @return string Html label
     */
    public static function input($options = array()) {

        # cacheamos os valores que possuirem '@' como prefixo.
        static::cacheOptions($options, 'field');

        # definindo valor padrão para o "type" do input
        if (!isset($options['type'])) {
            $options['type'] = 'text';
        }

        # definindo valor padrão para o "field" que será utilizado no input
        if (!isset($options['field']))
            $options['field'] = null;

        # definindo valor de {belongs_to}
        if (!isset($options['belongs_to']))
            $options['belongs_to'] = null;

        # definindo valor de {belongs_to}
        if (isset($options['is_son'])) {
            $entity = static::$cache['entity'];
            $options['belongs_to'] = $entity::nameFull();
        }

        return element('form/input', $options);
    }

    /**
     * Gera um campo para formulário personalizado e com todos os elementos.
     * 
     * @param array||string $options Nome do campo ou opções do {field}
     * @param string $label Nome da label
     */
    public static function field($options = array(), $label = NULL, $more_options = array()) {
        $field = array();

        # se {$options} não é um {array} significa que as opções estão divididas
        if (!is_array($options)) {

            # se {$options} for um string, significa que é o campo do {field}
            # if (is_string($options))
            $field['field'] = $options;

            # se {$label} não é null, então será a label do {field}
            if ($label)
                $field['text'] = $label;
        } else
            $field = $options;

        $field = array_merge($field, $more_options);
        $field = array_merge(static::$cache, $field);

        return element('form/field', $field);
    }

    /**
     * Exibe um input oculto baseando-se no input de uma entidade.
     * 
     * @param array $options
     * @return string HTML input
     */
    public static function fieldId($options = array()) {
        $defaults = array(
            'field' => 'id',
            'type' => 'hidden',
            'entity' => encoder_is_model($options) ? $options : (isset($options['entity']) ? $options['entity'] : static::$cache['entity']),
        );

        # cacheamos os valores que possuirem '@' como prefixo.
        static::cacheOptions($options);

        return element('form/input', array_merge($options, $defaults));
    }

    /**
     * Exibição de uma mensagem para um determinado input.
     * Adaptar método para message($entity_or_message, $field = null);
     * 
     * @param string $message
     * @return string Html label
     */
    public static function message($options = array(), $field = null) {

        # se {$options} for uma string, ela mesmo é a mensagem
        if (is_string($options))
            $message = $options;
        else {

            # definimos a entidade da mensagem
            if (encoder_is_model($options))
                $entity = $options;
            else if (is_array($options) && isset($options['entity']))
                $entity = $options['entity'];
            else if (isset(static::$cache['entity']))
                $entity = static::$cache['entity'];
            else
                return NULL;

            # definimos o campo da mensagem
            if (is_string($field))
                $field = $field;
            else if (is_array($options) && isset($options['field']))
                $field = $options['field'];
            else if (isset(static::$cache['field']))
                $field = static::$cache['field'];
            else
                return NULL;

            $message = $entity->message($field);
        }

        if (empty($message))
            return NULL;

        return element('form/message', array(
            'message' => $message
        ));
    }

    #
    ##
    ###
    # Interno #

    /**
     * Define as últimas opções passadas nos método de renderização de elementos.
     * 
     * Para cada índice se $options verificamos se o seu primeiro caracter é
     * igual a '@', se sim, significa que deseja-se salva o atributo na memória 
     * da classe, pra não ser preciso informa-lo outra vez, funcionando como um 
     * cache. Antes de armazenar o valor na classe, retiramos seu '@'.
     * 
     * @param atrin||array $options
     */
    private static function cacheOptions(&$options = array(), $defaultField = null) {
        $options_arrayed = static::$cache;

        # verificamos se as opções são apenas uma string e armazenamos 
        # no índice padrão, informado por cada método de renderização
        if (is_string($options)) {
            $options_arrayed[$defaultField] = $options;
        } else if (is_array($options)) {

            foreach ($options as $attr => $value) {

                # se o primeiro caracter do campo for igual a '@', significa que
                # deseja-se salva o atributo na memória da classe, pra não ser 
                # preciso informa-lo outra vez, funcionando como um cache. Antes
                # de armazenar o valor na classe, retiramos seu '@'.
                if (substr($attr, 0, 1) == '@')
                    static::$cache[$attr = substr($attr, 1)] = $value;

                $options_arrayed[$attr] = $value;
            }
        }

        return $options = $options_arrayed;
    }

}
