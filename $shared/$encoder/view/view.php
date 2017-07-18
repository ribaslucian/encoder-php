<?php

/**
 * <Encoder Framework>
 * A classe {View} tem como objetivo desempenhar as funcionalidades referentes
 * a páginas frontais da aplicação, contéudos que serão enviados diretamente 
 * para o navegador do cliente processar. Páginar visuais, menos lógica mais 
 * estruturamento.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class View extends Object {

    /**
     * Diretório que as visões do módulo atual estão salvas.
     * 
     * @var string
     */
    private static $dir;
    private static $templatesDir;

    /**
     * Váriaveis que estarão disponíveis nas renderizações dos arquivos de 
     * visões da aplicação.
     * 
     * @var array[view][name] = value
     */
    private static $vars = array();

    /**
     * Extensão dos arquivos da visões da aplicação.
     * 
     * @var string
     */
    private static $extension;

    /**
     * Método {Setter} e {Getter} genérico para o atributo {$dir}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, vai apenas retornar.
     * 
     * @return string $set
     */
    public static function dir($set = null) {
        if (empty($set))
            return self::$dir;

        return self::$dir = $set;
    }

    /**
     * Método {Setter} e {Getter} genérico para o atributo {extension}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, vai apenas retornar.
     * 
     * @return string $key
     */
    public static function extension($set = null) {
        if (empty($set))
            return self::$extension;

        return self::$extension = $set;
    }

    public static function templatesDir($set = null) {
        if (empty($set))
            return self::$templatesDir;

        return self::$templatesDir = $set;
    }

    /**
     * Verifica se existe uma determinada visão. Utilizando como diretório base
     * o diretório das visões, definido no atributo {$dir}. Não ah necessidade 
     * de informar a extesão da visão, apenas seu caminha relativo. Por ex: 
     * "home\index", "admin\users\index"...
     * 
     * @param string $view Visão que deseja verificar
     * @return boolean
     */
    public static function exists($view) {

        // @gambiarra
        if (strpos($view, '@layouts') !== false)
            $view = str_replace('@layouts' . I, static::$templatesDir, $view);
        else
            $view = static::$dir . $view;

        $view .= '.' . static::$extension;

        if (!file_exists($view))
            throw new \MissingView('Crie o arquivo <small class="small-text-8 bold">\'' . $view . '\'</small>');

        return $view;
    }

    /**
     * Obtém o HTML de uma visão, sem envia-lá para o cliente, permitindo 
     * possíveis modificações no HTML antes de ir de fato para o {browser} 
     * do cliente.
     * 
     * @param string $view
     * @param string $layout
     * @param array $vars
     */
    public static function getHtml($view, $vars = array()) {
        $view = str_replace(array('\\', '/'), I, strtolower($view));
        $view_path = static::exists($view);

        ob_start(); # start buffer.
        extract($vars, EXTR_PREFIX_SAME, ''); # define view vars;
        # set vars defined by method not by param.
        if (array_key_exists($view, static::$vars))
            extract(static::$vars[$view], EXTR_PREFIX_SAME, '');

        unset($vars); # unset vars array
        require $view_path; # include view
        $html = ob_get_contents(); # get HTML and close buffer;
        ob_end_clean(); # end buffer

        return $html; # compress html before return
        # return compress($html); # compress html before return
    }

    /**
     * Obtém o HTML de uma visão para o cliente. 
     * Obtendo seu HTML, enviando ao cliente
     * e finalizando o processamento do servidor.
     * 
     * @param string $view Visão que irá renderizar
     * @param string $layout Layout que a visão irá utilizar
     * @param $vars Variáveis que estarão disponíveis no layout e na visão
     */
    public static function getView($view, $layout = null, $vars = array()) {
        $view = str_replace(array('\\', '/'), I, strtolower($view));

        if ($layout != null) {
            $vars['_view'] = $view;
            $vars['_vars'] = $vars;
            return static::getHtml('@layouts/' . $layout, $vars);
        }

        return static::getHtml($view, $vars);
    }

    /**
     * Renderiza uma visão para o cliente. Obtendo seu HTML, enviando ao cliente
     * e finalizando o processamento do servidor.
     * 
     * @param string $view Visão que irá renderizar
     * @param string $layout Layout que a visão irá utilizar
     * @param $vars Variáveis que estarão disponíveis no layout e na visão
     */
    public static function render($view, $layout = null, $vars = array()) {
        echo static::getView($view, $layout, $vars);
        exit;
    }

    /**
     * Obtém o conteúdo HTML de um visão, sem rederização, ou seja, sem 
     * finalizar o processamento do servidor.
     * 
     * @param string $view Visão que deseja obter
     * @param array $vars Variáveis que estarão disponíveis na visão
     * @param string $layout Layout que será atribuído a visão
     */
    public static function get($view, $vars = array(), $layout = null) {
        return static::getView($view, $layout, $vars);
    }

    /**
     * Obtem o HTML de um visão {partial} ou seja, dentro de uma pasta relativa,
     * dentro do escopo da visão atual. Por ex: A visão {partial} de 
     * "user/index" deve estar localizada dentro da pasta "user/index/partial".
     * 
     * @param string $view Visão que deseja obter
     * @param array $vars Variáveis que estarão disponíveis na visão
     * @param string $layout Layout que será atribuído a visão
     */
    public static function partial($view, $vars = array(), $layout = null) {
        $controller = route_controller();
        return static::getView($controller::view($view), $layout, $vars);
    }

    /**
     * Obtem o HTML de um visão {partial} ou seja, dentro de uma pasta relativa
     * as pastas base de visões, chamada @element. {view}/@layouts
     * 
     * @param string $view Visão que deseja obter
     * @param array $vars Variáveis que estarão disponíveis na visão
     * @param string $layout Layout que será atribuído a visão
     */
    public static function element($name, $vars = array(), $layout = null) {
        return static::get('@layouts' . I . $name, $vars, $layout);
    }

    /**
     * Define uma variável que está disponível em um determinada visão.
     * Baseando-se em um {array} com dois índice, o nome da visão e o nome da
     * variável.
     * 
     * @param string $view Visão que deseja definir a variável
     * @param string $var Noma da variável na visão
     * @param ? $value
     */
    public static function setVar($view, $var, $value) {
        static::$vars[$view][$var] = $value;
    }

    /**
     * Obtem o caminho/nome uma visão baseado na localização da rota atual.
     * 
     * @param string $locale Camonho/nome da visão
     */
    public static function getByLocale($locale) {
        return strtolower(str_replace(array('\\', '::'), I, $locale));
    }

}
