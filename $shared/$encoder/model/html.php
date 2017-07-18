<?php

/**
 * A classe {model\Html} tem como objetivo informar valores referentes a uma 
 * entidade instanciada a partir de um modelo da aplicação. Estes valores serão
 * de grande utilizado na camada frontal da aplicação, nas visões (Views). Com 
 * métodos voltados a gerar e obter informações para formulários e modelo de 
 * apresentação da entidade aos usuários.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

namespace model;

class Html {

    /**
     * encoder\Model que esté sendo referenciada no geramentos das informações frontais.
     * 
     * @var \encoder\Model
     */
    public $entity;

    /**
     * Construtor gerado para definição do atributor $entity da classe junto a
     * sua instanciação, pois não haverá um objeto \model\Html sem o atributo
     * $entity.
     * 
     * Não foi utilizado o construtor do framework pois há método que conflitam.
     * 
     * @param \encoder\Model $entity
     */
    public function __construct($entity) {
        $this->entity = $entity;
    }

    /**
     * Obtém o ID da entidade ou de um campo de 
     * seu pertence (útil na geração de formulários).
     * 
     * @param string $field
     * @return string
     */
    public function id($field = null) {
        $m = $this->entity;

        # o apelido da entidade será seu prefixo.
        $id = $m::nameFullAlias();

        // utilização o ID da entidade esteja definido como intermédio
        if (isset($this->entity->id))
            $id .= '_' . $this->entity->id;

        // utilização o $field caso tenho sido informado como sufixo
        if (is_string($field))
            $id .= '_' . $field;

        return $id;
    }

    /**
     * Obtém o nome de um campo da entidade. Útil na geração de inputs HTML.
     * Se o método identificar '[' (abertura de colchetes) o parâmetro {$field},
     * não será concatedo entre colchetes ([]).
     * 
     * Caso seja reconhecido a string {$rewrite} no nome do modelo, seu valor
     * será retirado ou sobreescrito por ''.
     * 
     * @param string $field
     * @return string
     */
    public function name($field, $belong_to = null, $rewrite = 'views\\') {
        $m = $this->entity;

        # verificamos se este campo pertence a alguma outra entidade
        $name = $belong_to ? $belong_to . '[' . $m::nameFull() . ']' : $m::nameFull();

        # prefix do noma será o nome completo do modelo da Entidade;
        # verificamos se o nome deve ser gerado limpamente ou definido seus '[]'
        $name .= (strpos($field, '[') !== false ? $field : "[$field]");

        # caso o modelo seja uma view, reescrevemos seu nome para sua entidade
        if (is_string($rewrite) && strpos($name, $rewrite) !== false)
            return str_replace($rewrite, '', $name);

        return $name;
    }

    /**
     * Se existe o campo solicitado o retornamos, se não retornamos vazio {''}.
     * 
     * @param string $field
     * @return ?
     */
    public function value($field) {
        if (!isset($this->entity->$field))
            return '';

        return $this->entity->$field;
    }

    /**
     * Gera uma label HTML utilizando da classe Input.
     * Verificar mais documentações na classe Input.
     * 
     * @param string $field
     * @param array $options
     * @return string HTML label
     */
    public function label($field = null, $options = array()) {

        # valores padrão para labels geradas diretamente da entidade.
        $defaults = array(
            'entity' => $this->entity,
            'field' => $field,
        );

        # se o parâmetro $options for string, não há mais opções a definir, 
        # logo retornamos a label com os valores que temos (entity, field, text)
        if (is_string($options)) {
            $defaults['text'] = $options;
            return \Input::label($defaults);
        }

        return \Input::label($defaults);
    }

    /**
     * Gera uma label HTML utilizando da classe Input.
     * Verificar mais documentações na classe Input.
     * 
     * @param string $field
     * @param array $options
     * @return string HTML field
     */
    public function field($field, $options = array()) {
        $options['field'] = $field;
        $options['@entity'] = $this->entity;
        return \Input::field($options);
    }

    /**
     * Exibi uma mensagem HTML referente à um campo da entidade {$entity}.
     * 
     * @param string $field 
     * @return string HTML message
     */
    public function message($field) {
        if ($message = $this->entity->message($field))
            return \Input::message($message);

        return '';
    }

    /**
     * Obtem as mesagens de um campo ou todas da entidade {$entity}.
     * 
     * @param string $field 
     * @return string HTML message
     */
    public function messages($field = null) {
        $html = '';

        # obtendo todas as mensagens da entidade {$entity}
        if (is_null($field) && $messages = $this->entity->messages()) {
            foreach ($messages as $field => $field_messages)
                foreach ($field_messages as $message)
                    $html .= \Input::message($message);
        } else if ($messages = $this->entity->messages($field)) {
            # obtendo todas as mensagens de um único campo
            foreach ($messages as $message)
                $html .= \Input::message($message);
        }

        return $html;
    }

}
