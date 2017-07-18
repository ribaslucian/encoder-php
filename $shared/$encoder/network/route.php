<?php

/**
 * <Encoder Framework>
 * A classe {Route} tem como objetivo desempenhar atividades voltadas as Rotas
 * ou endereços válidos dentro do escopo do projeto.
 * 
 * Suas funcionalidades se limitão na criação de rotas, validação, 
 * redirecionamento, listagem, etc.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * Exemplos de rotas
 * {url_application}/controller
 * {url_application}/controller/action
 * {url_application}/pack/controller/action
 * {url_application}/pack1/pack2/my_controller/myAction
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Route extends Object {

    /**
     * Rotas criadas pelo desenvolvedor
     * 
     * @var array[route] => config
     */
    private static $routes = array();

    /**
     * Rota atual da aplicação.
     * 
     * @var string
     */
    private static $current;

    /**
     * {Controller} base que a classe irá buscar em um redirecionamento.
     * 
     * @defaultValue 'Hello'
     * 
     * @var string
     */
    private static $controller = 'Home';

    /**
     * {Action} base que a classe irá chamar em um redirecionamento.
     * 
     * @defaultValue 'index'
     * 
     * @var string
     */
    private static $action = 'index';

    /**
     * A extensão da rota refresenta a extensão do arquivo de visão que será 
     * renderizado.
     * 
     * @defaultValue 'index'
     * 
     * @var string
     */
    private static $extension = 'php';

    /**
     * @staticConstruct
     */
    public static function init($data = array()) {
        # definimos a rota atual.
        self::current();

        # vamos redefinir o {controller} e {action} a partir da rota atual ou da 
        # configuração definida pelo desenvolvedor.
        if (self::defined())
            self::setControllerActionByConf();
        else
            self::setControllerActionByUrl();

        self::setExtension();
    }

    /**
     * Método {Getter} para o atributo {routes}.
     * 
     * @return array
     */
    public static function routes() {
        return self::$routes;
    }

    /**
     * Método {Getter} e {Setter} para o atributo {controller}.
     * 
     * @return string
     */
    public static function controller($set = null) {
        if (!empty($set))
            return self::$controller = $set;

        return self::$controller;
    }

    /**
     * Método {Getter} e {Setter} para o atributo {action}.
     * 
     * @return string
     */
    public static function action($set = null) {
        if (!empty($set))
            return self::$action = $set;

        return self::$action;
    }

    /**
     * Método {Setter} e {Getter} para o atributo {current}.
     * Na primeira chamada define e obtem, nas próximas, apenas obtem.
     * 
     * @return string
     */
    public static function current() {
        if (!empty(self::$current))
            return self::$current;

        $current = '/' . str_replace(url_application(), '', url_current());

        # retiramos os parâmetros GET caso existam na URL.
        $current = explode('?', $current);
        $current = $current[0];

        # retiramos a barra que existe no fim do URL, caso a rota seja != /
        if (isset($current{2})) {
            $t = substr($current, -1);
            if ($t == '/' || $t == '\\')
                $current = substr($current, 0, -1);
        }

        return (static::$current = $current);
    }

    /**
     * Verifica se uma rota foi definida previamente pelo desenvolvedor.
     * Caso não infome a rota, será verificado a rota atual.
     * 
     * @return bool
     */
    public static function defined($route = null) {
        $route = $route ?: self::current();
        return array_key_exists($route, static::$routes);
    }

    /**
     * Adiciona uma nova rota pré configurada.
     * 
     * @param string $route
     * @param string|array $locale
     * 
     * @return void
     */
    public static function add($route, $locale) {
        if (empty($route))
            throw new InvalidValue('$route should be a not empty string');

        if (empty($locale))
            throw new InvalidValue('$locale should be a not empty string');

        static::$routes[$route] = $locale;
    }

    /**
     * Define o {Controller} e {Action} que a rota deve referenciar baseada na 
     * configuração definida pelo desenvolvedor.
     * 
     * @return void
     */
    private static function setControllerActionByConf() {
        # slice route elements config
        $elements = explode(' ', self::$routes[self::$current]);

        # controller full name
        self::$controller = $elements[0];

        # action name
        self::$action = isset($elements[1]) ? $elements[1] : self::$action;
    }

    /**
     * Define o {Controller} e {Action} que a rota deve referenciar baseada na 
     * na interpretação da URL atual.
     * 
     * @return void
     */
    private static function setControllerActionByUrl() {
        # check if url is empty
        if (static::$current != '/') {

            $elements = explode('/', static::$current);
            unset($elements[0]);
            $last_pos = count($elements);

            # check if URL define oinly controller >> {appliction}/params/controller
            if ($last_pos == 1) {
                self::$controller = \Inflector::camelize($elements[1]);
            } else {

                # define action by last url parameter {url}/action
                self::$action = \Inflector::underscore($elements[$last_pos]);
                unset($elements[$last_pos]); # destroy action by elements
                # define controller relative name by penultimate URL parameter {appliction}/params/controller/action
                self::$controller = \Inflector::camelize($elements[$last_pos - 1]);
                unset($elements[$last_pos - 1]); # destroy controller by elements
                # controller full name
                self::$controller = strtolower(implode('\\', $elements)) . '\\' . self::$controller;

                # correct controller name
                if (substr(self::$controller, 0, 1) == '\\')
                    self::$controller = substr(self::$controller, 1, strlen(self::$controller));
            }
        }
    }

    /**
     * Método que definirá a extensão do rota atua.
     * 
     * @return void
     */
    private static function setExtension() {
        $action = explode('.', static::$action);

        if (($l = count($action)) > 1) {
            static::$extension = $action[--$l];
            unset($action[$l]);
            static::$action = implode('.', $action);
        }
    }

    /**
     * Gerador de URLs válidas a partir de um única rota.
     * 
     * @param string $route
     * 
     * @return string url
     */
    public static function url($route = null) {
        if (empty($route))
            return Url::current();

        return \Url::application() . substr($route, 1);
    }

    /**
     * Verifica se a rota possui um local válido.
     * 
     * @return boolean
     * @throws \MissingClass
     * @throws \MissingMethod
     * @throws \InvalidClass
     */
    public static function isValid($tell_me_why = true) {

        # verificanso se a classe da róta existe.
        if (!Dir::hasClass(self::$controller)) {
            if ($tell_me_why)
                throw new \MissingClass(self::$controller);
            else
                return false;
        }

        # verificando se a classe da róta é um {Controller} válido.
        if (!encoder_is_controller(self::$controller)) {
            if ($tell_me_why)
                throw new \InvalidClass(self::$controller . ' is not ' . encoder_controller() . ' instance');
            else
                return false;
        }

        # verificamos se nao eh um controller apenas de renderizacao
        if (!property_exists(self::$controller, 'onlyRender')) {
            # verificando se axiste a ação solicitada definida dentro do {Controller}.
            if (!method_exists(self::$controller, self::$action)) {
                if ($tell_me_why)
                    throw new \MissingMethod(self::$controller . '::' . self::$action);
                else
                    return false;
            }
        }

        return true;
    }

    /**
     * Redireciona a aplicação para uma nova URL baseada na rota informada.
     * 
     * @param string $route
     */
    public static function redirect($route = null) {
        header('Location: ' . url_application() . substr($route, 1));
        exit();
    }

    /**
     * Efetual chamada ao Controller referenciado pela rota atual.
     * 
     * @return void
     */
    public static function call() {
        $controller = static::$controller;
        $controller::routeCall();
    }

    /**
     * Obtém a string definindo o {Controller} e {Action} atual da rota.
     * 
     * @return string
     */
    public static function locale() {
        $locale = static::controller() . I . static::action();
        return str_replace(array(I, '\\'), I, $locale);
    }

    /**
     * Obtém todas a rotas definida num determinado prefixo.
     * 
     * @param string $hierarchy
     * 
     * @return array
     */
    public static function byPack($hierarchy) {
        $routes = array();

        foreach (static::$routes as $route => $locale) {
            $route = explode('/', $route);

            if (!$route[2] && empty($hierarchy) || $route[1] == $hierarchy)
                $routes[] = implode('/', $route);
        }

        return $routes;
    }

}
