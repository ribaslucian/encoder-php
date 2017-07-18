<?php

/**
 * <Encoder Framework>
 * A classe {Validate} tem como objetivo desempenhar validações básicas, ou seja
 * validação o sobre valores, não sobre ações.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Validate {
    
    #
    ##
    ###
    # BASICS #

    /**
     * Verifica es um valor não está vazio.
     * 
     * @param string $value
     * @return boolean
     */
    public static function notEmpty($value) {
        return !empty($value);
    }

    /**
     * Verifica se um valor é númerico.
     * 
     * @param string $value
     * @return boolean
     */
    public static function numeric($value) {
        return is_numeric($value);
    }

    /**
     * Verifica os tamanhos máximos e mínimos de uma string.
     * 
     * @param string $value
     * @param array $config array(max: 1, min: 2)
     * @return boolean
     */
    public static function strlen($value, $config) {
        $value = strlen($value);

        if (!array_key_exists('min', $config))
            $config['min'] = 0;

        if (!array_key_exists('max', $config))
            return $config['min'] <= $value;

        return $config['min'] <= $value && $value <= $config['max'];
    }

    /**
     * Verifica o tamanho mínimo de uma string.
     * 
     * @param string $value
     * @param array $config array(min: 2)
     * @return boolean
     */
    public static function strmin($value, $config) {
        return $config['min'] <= strlen($value);
    }

    /**
     * Verifica o tamanho máximo de uma string.
     * 
     * @param string $value
     * @param array $config array(max: 2)
     * @return boolean
     */
    public static function strmax($value, $config) {
        return $config['max'] >= strlen($value);
    }

    /**
     * Verifica o tamanho máximo para um número.
     * 
     * @param string $value
     * @param array $config array(max: 1, min: 2)
     * @return boolean
     */
    public static function numlen($value, $config) {
        if (!array_key_exists('min', $config))
            $config['min'] = 0;

        if (!array_key_exists('max', $config))
            return $config['min'] <= $value;

        return $config['min'] <= $value && $value <= $config['max'];
    }

    #
    ##
    ###
    # MODEL #

    /**
     * Aplica as validações definidas em um modelo, no seu objeto referenciador.
     * 
     * @param encoder\Model $model
     * @return bolean
     */
    public static function model($model) {
        # checking if any validation was set
        if (!isset($model::$validate))
            return true;

        # percorrendo validações
        foreach ($model::$validate as $validation => $confs) {

            $validation = explode('{', $validation);
            $rule = str_replace(' ', '', $validation[0]);
            $fields = explode(',', str_replace(array(' ', '}'), '', $validation[1]));

            $actions_only = str_replace(array(' ', '}'), '', $validation[2]);

            $actions_only = $actions_only ? explode(',', $actions_only) : null;
            $action = \Route::action();

            # verificando se a validação é definida para a ação atual
            if (!empty($actions_only) && (!in_array($action, $actions_only) || in_array('!' . $action, $actions_only)))
                continue;

            # verificando se foi definido alguma mensagem.
            if (@$confs[0]) {

                # armazenando e destruindo da confs.
                $message = $confs[0];
                unset($confs[0]);

                # definindo mensagem e suas palavras especiais
                foreach ($confs as $conf => $value)
                    $message = str_replace(':' . $conf, $value, $message);
            }

            # percorrendo e validando os campo
            foreach ($fields as $field) {

                # passar model por paramêtro para algumas validações.
                if (is_int(array_search($rule, array('unique', 'confirm', 'exists'))))
                    $confs['model'] = $model;

                # para regra unique é necessário parra o field.
                if ($rule == 'unique' || $rule == 'exists')
                    $confs['field'] = $field;

                if (!isset($model->$field) || !self::$rule($model->$field, $confs))
                    $model->message($field, @$message ? : '');
            }
        }

        return $model->messages() ? false : true;
    }

    /**
     * Verifica se o valor de um campo bate com o valor de outro campo.
     * 
     * @param string $value
     * @param array $options array(model: object, compare_to: value)
     * @return bolean
     */
    public static function confirm($value, $options) {
        $field = $options['compare_to'];
        return $value == @$options['model']->$field;
    }

    /**
     * Verifica se existe um registro correspondente no banco de dados.
     * 
     * @param string $value
     * @param array $options array(model: object, field: value)
     * @return bolean
     */
    public static function exists($value, $options) {
        return $options['model']->exists($options['field'] . ' = \'' . $value . '\'');
    }

    /**
     * Verifica se o objeto referenciador representa um único registro no DB.
     * 
     * @param string $value
     * @param array $options array(model: object, field: value)
     * @return bolean
     */
    public static function unique($value, $options) {
        if (@$options['model']->id)
            return $options['model']->exists($options['field'] . ' = \'' . $value . '\' AND id <> \'' . $options['model']->id . '\'') <= 0;

        return $options['model']->exists($options['field'] . ' = \'' . $value . '\'') <= 0;
    }

    /**
     * Verifica se um valor corresponde a uma entidade de outro modelo.
     * 
     * @param string $id ID da entitidade origin
     * @param array $options array(model: string) modelo destino a verificar
     * @return bolean
     */
    public static function existsIn($id, $options) {
        # se o ID origin está vazio não efetuamos a validação
        if (empty($id))
            return true;

        # obtemos o modelo destino
        $model = $options['model'];

        # verificamos no modelo destino se existe um registro com o ID origem
        return $model::count("id = '$id'") >= 1;
    }

    #
    ##
    ###
    # REGEX #

    /**
     * Verifica se um valor não possui caracteres além dos convencionais.
     * 
     * @param string $string
     * @return bolean
     */
    public static function generic($string) {
        return preg_match('/^[0-9,a-z,A-Z,á-ú,Á-Ú,à-ù,À-Ù,ã-õ,Ã-Õ,â-û,Â-Û,ä-ü,Ä-Ü,\.,\º,\ª,\-,\:,[:space:]]{0,1024}$/', $string);
    }

    /**
     * Verifica se um valor não possui caracteres irrelevantes em um nome.
     * 
     * @param string $name
     * @return bolean
     */
    public static function name($name) {
        # '|^[a-z çá-úà-ù]{0,92}$|i'
        return preg_match('|^[a-z çá-úà-ù]*$|i', $name);
    }

    /**
     * Verifica se um valor está no formato de um CPF (xxx.xxx.xxx-xx).
     * 
     * @param string $cpf
     * @return bolean
     */
    public static function cpf($cpf) {
        return preg_match('|^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$|', $cpf);
    }

    /**
     * Verifica se um valor está pode ser um RG.
     * 
     * @param string $rg
     * @return bolean
     */
    public static function rg($rg) {
        return preg_match('|[0-9]{0,16}|', $rg);
    }

    /**
     * Verifica se um valor está no formato de um CNPJ (xx.xxx.xxxx/xxx-xx).
     * 
     * @param string $cnpj
     * @return bolean
     */
    public static function cnpj($cnpj) {
        return preg_match('|^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$|', $cnpj);
    }

    /**
     * Verifica se um valor está no formato de um CEP (xxxxx-xxx).
     * 
     * @param string $cep
     * @return bolean
     */
    public static function cep($cep) {
        return preg_match('|^[0-9]{5}-[0-9]{3}$|', $cep);
    }

    /**
     * Verifica se um valor está no formato de um email.
     * 
     * @param string $email
     * @return bolean
     */
    public static function email($email) {
        return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email);
    }

    /**
     * Verifica se um valor está no formato de um telefone ((xx) xxxx-xxxx).
     * 
     * @param string $phone
     * @return bolean
     */
    public static function phone($phone) {
        return preg_match('|^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$|', $phone);
    }

    #
    ##
    ###
    # TIME #

    /**
     * Verifica se um valor é uma data válida.
     * 
     * @param string $date Data que será verificada
     * @param string $format Formato da data
     * @return bolean
     */
    public static function date($date, $format = 'Y-m-d H:i:s') {
        if (empty($date))
            return true;
        
        $format = is_array($format) ? $format['format'] : $format;
        return Date::is($date, $format);
    }

    /**
     * Verifica se um valor representa um horário válido.
     * 
     * @param string $hour Hora que será verificada
     * @return boolean
     */
    public static function hour($hour) {
        return Date::isHour($hour);
    }

    /**
     * Verifica se uma data está no passado.
     * 
     * @param string $date Data que será verificada
     * @param string $format Formato da data
     * @return boolean
     */
    public static function isPast($date, $format = 'Y-m-d H:i') {
        $format = is_array($format) ? $format['format'] : $format;

        if (Date::isPast($date, $format))
            return true;

        return false;
    }

    /**
     * Verifica se uma data está no futuro.
     * 
     * @param string $date Data que será verificada
     * @param string $format Formato da data
     * @return boolean
     */
    public static function isFuture($date, $format = 'Y-m-d H:i') {
        $format = is_array($format) ? $format['format'] : $format;

        if (Date::isFuture($date, $format))
            return true;

        return false;
    }

}
