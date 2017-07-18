<?php

/**
 * <Encoder Framework>
 * A classe {encoder\Controller} tem como objetivo desempenhar funcionalidades 
 * referentes as ações do usuário. Possuirá métodos que serão acessadas
 * diretamente pelas {URL} ou rotas da aplicação. Este métodos irão intercalar
 * o usuário entre as visões (Views) e modelos (Models) da aplicação, como 
 * sujere o padrão {MVC}.
 * 
 * Está dentro do namespace "encoder" pois o nome {Controller} está reservado
 * para utilização da aplicação que está utilizando do framework. Permintindo 
 * uma melhor legibilidade para o desenvolvedor.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

namespace encoder;

abstract class Controller extends \Object {

    /**
     * Define se um {Controller} deverá ou não renderizar automaticamente a 
     * visão correspondente à róta atual da aplicação.
     * 
     * @var boolean
     */
    protected static $autoRender = true;

    /**
     * Define se um {Controller} será apenas para apresentação das visões filhas.
     * Tornando-se desnecessário a implementação das suas @actions (ações ou 
     * métodos) implementador no {Controller}.
     * 
     * @var boolean
     */
    protected static $onlyRender = false;

    /**
     * {Array} de métodos que serão referenciados Antes da @action (ação/método)
     * do {controller} requisitado pela róta atual da aplicação.
     * 
     * @var array[nome_dos_metodos]
     */
    protected static $beforeAction = array();

    /**
     * {Array} de métodos que serão referenciados Depois da @action (ação/método)
     * do {controller} requisitado pela róta atual da aplicação.
     * 
     * @var array[nome_dos_metodos]
     */
    protected static $afterAction = array();

    /**
     * {Array} de métodos que serão referenciados Antes da renderização da visão
     * correspondente a @action (ação/método) do {controller} requisitado pela 
     * róta atual da aplicação.
     * 
     * @var array[nome_dos_metodos]
     */
    protected static $beforeRender = array();

    /**
     * {Array} de métodos que serão referenciados Depois da renderização da visão
     * correspondente a @action (ação/método) do {controller} requisitado pela 
     * róta atual da aplicação.
     * 
     * @var array[nome_dos_metodos]
     */
    protected static $afterRender = array();

    /**
     * Método {Setter} e {Getter} genérico para o atributo {$autoRender}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, vai apenas retornar.
     * 
     * @return string $key
     */
    public static function autoRender() {
        return self::$autoRender;
    }

    /**
     * Método {Setter} e {Getter} genérico para o atributo {$onlyRender}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, vai apenas retornar.
     * 
     * @return string $set
     */
    public static function onlyRender($set = null) {
        if ($set !== null)
            return self::$onlyRender = $set;

        return self::$onlyRender;
    }

    /**
     * - Se o parâmetro {$set_get_or_call} for um array, o método irá definir o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for true, o método irá retornar o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for null, o método irá 
     * referenciar/chamar os métodos informador no {array} {$beforeAction};
     * 
     * @return array
     * @return void
     */
    public static function beforeAction($set_get_or_call = null) {
        # if (is_array($set_get_or_call)) setter e retornar
        if (is_array($set_get_or_call))
            return self::$beforeAction = array_merge(self::$beforeAction, $set_get_or_call);

        # if ($set_get_or_call === true) retornar
        if ($set_get_or_call === true)
            return self::$beforeAction;

        if ($set_get_or_call === null)
            static::callMethods(static::$beforeAction);
    }

    /**
     * - Se o parâmetro {$set_get_or_call} for um array, o método irá definir o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for true, o método irá retornar o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for null, o método irá 
     * referenciar/chamar os métodos informador no {array} {$afterAction};
     * 
     * @return array
     * @return void
     */
    public static function afterAction($set_get_or_call = null) {
        # if (is_array($set_get_or_call)) setter e retornar
        if (is_array($set_get_or_call))
            return self::$afterAction = array_merge(self::$afterAction, $set_get_or_call);

        # if ($set_get_or_call === true) retornar
        if ($set_get_or_call === true)
            return self::$afterAction;

        if ($set_get_or_call === null)
            static::callMethods(static::$afterAction);
    }

    /**
     * Route controller call.
     * 
     * @return void
     */
    public static function routeCall() {
        $action = \Route::action();

        # verificando se é um controller apenas de renderização.
        if (!static::$onlyRender) {
            static::beforeAction();
            static::$action(); # efetuando referênciação da ação.
            static::afterAction();
        }

        # verificando se o controller deseja renderizar a View.
        if (static::$autoRender) {
            static::beforeRender();
            echo \View::get(self::view($action), array(), static::layout());
            static::afterRender();
        }
    }

    /**
     * Get Current Locale.
     * 
     * @return string
     */
    public static function locale() {
        return static::nameFull() . '::' . \Route::action();
    }

    /**
     * Obtém a view correspondente ao controller.
     * 
     * @return string
     */
    public static function view($view = null) {
        $view = $view ? I . $view : '';
        $namespace = str_replace(array('\\', '/'), I, static::nameOfSpaceAlias());
        return $namespace . ($namespace ? I : '') . static::nameAlias() . $view;
    }

    /**
     * Obtém o layout da view que será utilizado para um determinado controller.
     * Primeiro é verificado se está definido uma propriedade $layout no 
     * controller. Se não, é obtido o namespace do controller. Se o namepace for
     * vazio, o application é retornado.
     * 
     * @return string
     */
    public static function layout() {
        if (property_exists(static::nameFull(), 'layout'))
            return static::$layout;

        return self::nameOfSpaceAlias() ?: 'default';
    }

    /**
     * Obtém a URL correspondente ao controller.
     * 
     * @return string
     */
    public static function route($action = null) {
        $action = $action ? '/' . $action : '';
        $namespace = str_replace(array('\\', '/'), '/', static::nameOfSpaceAlias());
        return '/' . $namespace . ($namespace ? '/' : '') . static::nameAlias() . $action;
    }

    #
    ##
    ###
    # PROTECTED #

    /**
     * - Se o parâmetro {$set_get_or_call} for um array, o método irá definir o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for true, o método irá retornar o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for null, o método irá 
     * referenciar/chamar os métodos informador no {array} {$beforeRender};
     * 
     * @return array
     * @return void
     */
    protected static function beforeRender($set_get_or_call = null) {
        # if (is_array($set_get_or_call)) setter e retornar
        if (is_array($set_get_or_call))
            return self::$beforeRender = array_merge(self::$beforeRender, $set_get_or_call);

        # if ($set_get_or_call === true) retornar
        if ($set_get_or_call === true)
            return self::$beforeRender;

        if ($set_get_or_call === null)
            static::callMethods(static::$beforeRender);
    }

    /**
     * - Se o parâmetro {$set_get_or_call} for um array, o método irá definir o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for true, o método irá retornar o 
     * atributo {$set_get_or_call}.
     * - Se o parâmetro {$set_get_or_call} for null, o método irá 
     * referenciar/chamar os métodos informador no {array} {$afterRender};
     * 
     * @return array
     * @return void
     */
    protected static function afterRender($set_get_or_call = null) {
        # if (is_array($set_get_or_call)) setter e retornar
        if (is_array($set_get_or_call))
            return self::$afterRender = array_merge(self::$afterRender, $set_get_or_call);

        # if ($set_get_or_call === true) retornar
        if ($set_get_or_call === true)
            return self::$afterRender;

        if ($set_get_or_call === null)
            static::callMethods(static::$afterRender);
    }

    #
    ##
    ###
    # PRIVATE #

    /**
     * Efetua a chamada de métodos baseado em um {array} com seus nomes.
     * 
     * @param array $methods
     */
    private static function callMethods(array $methods = array()) {
        foreach ($methods as $method) {
            if (!method_exists(static::nameFull(), $method))
                throw new \MissingMethod('Method Not Found: ' . static::nameFull() . '::' . $method . '()');

            static::$method();
        }
    }

}
