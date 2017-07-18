<?php

/**
 * <Encoder Framework>
 * A classe {Paginate} tem como objetivo efetuar a listagem de registros 
 * referentes aos modelos da aplicação de maneira paginada.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Paginate extends Object {

    /**
     * Atributos editáveis ou valores de entrada para um efetuar uma paginação.
     * 
     * @var array
     */
    private static $in = array(
        'method' => 'get',
        'fields' => '*',
        'limit' => 10,
        'page' => 1,

        # 'where' => null,
        # 'order' => null,
    );

    /**
     * Valores que serão definidos após a paginação. Representam 
     * os  resultados da ou os valores de saída da paginação.
     * 
     * @var array
     */
    private static $out = array(
        'offset' => null,

        'page' => array(
            'previous' => null,
            'forward' => null,
            'total' => null,
        ),

        'records' => array(
            'total' => null,
            'start' => null,
            'end' => null,
        )
    );

    /**
     * Efetua a paginação dos registros de um {model} qualquer.
     * 
     * @param string $model nome do modelo que será páginado
     * @param array $in opções de entrada de paginação
     * @return array registros paginados
     */
    public static function find($model, array $in = array()) {
        # definindo atributos de entrada da paginão.
        static::setIn($in);

        # efetuamos alguns cálculo dos dados de saída da paginação.
        static::calcOuts($model);
        
        static::$in['offset'] = static::$out['offset'];

        return $model::find(static::$in);
    }

    #
    ##
    ###
    # Métodos Utilitários #

    /**
     * Verificamos se uma determinada página é válida ou existe.
     * Se não informado a página, será verificado com a página atual.
     * 
     * @param int $page página que desejamos verificar
     * @return boolean página é ou não válida
     */
    public static function pageExists($page = null) {
        $page = $page ? : static::pageCurrent();
        return $page > 0 && $page <= self::pagesCount();
    }

    #
    ##
    ###
    # Métodos {Get} #

    /**
     * Obtém-se os valores de entrada da paginação.
     * @return array entrada
     */
    public static function in() {
        return static::$in;
    }

    /**
     * Obtém-se os valores de saída da paginação.
     * @return array saída
     */
    public static function out() {
        return static::$out;
    }

    /**
     * Obtém-se o método {Http} de comunicação com o usuário que a paginação 
     * está utilizando, {get} ou {post}.
     * @return string método
     */
    public static function method() {
        return static::$in['method'];
    }

    /**
     * Obtém-se os campos que foram listados na paginação.
     * @return string
     */
    public static function fields() {
        return static::$in['fields'];
    }

    /**
     * Obtém-se a quantidade de registros por página.
     * @return int limite
     */
    public static function limit() {
        return static::$in['limit'];
    }

    /**
     * Obtém-se as condições de busca por registros utilizados na paginação.
     * @return array||string condições
     */
    public static function where() {
        return static::$in['where'];
    }

    /**
     * Obtém-se a ordem dos registros na paginação.
     * @return string order
     */
    public static function order() {
        return static::$in['order'];
    }

    /**
     * Obtém-se o offset de busca por registros na paginação.
     * @return int offset
     */
    public static function offset() {
        return static::$out['offset'];
    }

    /**
     * Obtém-se o número da página atual dos registros paginados.
     * @return int número
     */
    public static function pageCurrent() {
        return static::$in['page'];
    }

    /**
     * Obtém-se o número da página anterior dos registros paginados.
     * @return int anterior
     */
    public static function pagePrevious() {
        return static::$out['page']['previous'];
    }

    /**
     * Obtém-se o número da próxima página dos registros paginados.
     * @return int próxima
     */
    public static function pageForward() {
        return static::$out['page']['forward'];
    }

    /**
     * Obtém-se o número total páginas dos registros paginados.
     * @return int total
     */
    public static function pagesCount() {
        return static::$out['page']['total'];
    }

    /**
     * Obtém-se o número do primeiro de registro da página, referente a toda 
     * paginação.
     * @return int primeiro registro
     */
    public static function recordStart() {
        return static::$out['records']['start'];
    }

    /**
     * Obtém-se o número do último de registro da página, referente a toda 
     * paginação.
     * @return int último registro
     */
    public static function recordEnd() {
        return static::$out['records']['end'];
    }

    /**
     * Obtém-se o número total de registros paginados.
     * @return int total de registros
     */
    public static function recordsCount() {
        return static::$out['records']['total'];
    }
    
    /**
     * Número da linha de uma tabela de paginação, pode-se considerar também
     * como identificador do registro ou da linha de modo interno a paginação.
     * 
     * @return int número do linha
     */
    public static function lineNumber() {
        
        # obtemos a linha atual armazenada
        $l = static::globals('lineNumber');
               
        # se não existe linha armazenada vamos definir 
        # como o número do primeiro registro da página
        if (!$l)
            return static::globals('lineNumber', static::recordStart());

        return static::globals('lineNumber', ++$l);
    }

    #
    ##
    ###
    # URL Métodos {Get} #

    /**
     * Obtém-se a URL para a página anterior da páginação.
     * @return null||string
     */
    public static function urlBack() {
        # verificamos se a página anterior existe.
        if (!$p = static::pagePrevious())
            return null;

        # definimos a página nos parâmetros da URL e reescrevemos a url.
        $url = explode('?', \Url::current());
        return $url[0] . '?' . Request::query('page', $p);
    }

    /**
     * Obtém-se a URL para a página anterior da páginação.
     * @return null||string
     */
    public static function urlForward() {
        # verificamos se a página anterior existe.
        if (!$p = static::pageForward())
            return null;

        # definimos a página nos parâmetros da URL e reescrevemos a url.
        $url = explode('?', \Url::current());
        return $url[0] . '?' . Request::query('page', $p);
    }

    /**
     * Link para paginação e Ordenação dos registros em função de uma coluna e 
     * direção.
     * 
     * @param string $column coluna de ordenação
     * @param string $text texto que será exibido no link para clicar
     * @param string $class classes CSS que serão atribuídas no link
     * @return string
     */
    public static function linkSort($column, $text, $class = '') {
        # obtemos a ordem atual da paginação
        $order = @explode(' ', static::order());

        # defimos ASC como direção padrão
        $direction = 'asc';

        # definindo ícone padrão do botão de ordenação
        $icon = '<i class="material-icons grey-text text-lighten-3">&#xE8D5;</i>';

        # verificando se foi informado a coluna e a direção de ordenação
        if (count($order) >= 1) {

            # Verificamos se a coluna de requisição informada é a mesma do 
            # parâmetro de requisitado, se foi informado a direção de paginação.
            # Se não ASC será atribuído para todos os Links de ordenação.
            if ($column == $order[0]) {

                # invertemos o valor da direção de paginação caso o valor tenha
                # sido informado.
                if (isset($order[1]))
                    $direction = $order[1] == 'asc' ? 'desc' : 'asc';

                # atualizando ícone para destacar a coluna referênciada no momento
                $icon = $direction == 'desc' ?
                        '<small><i class="material-icons">&#xE5DB;</i></small>' :
                        '<small><i class="material-icons">&#xE5D8;</i></small>';
            }
        }

        # definindo URL do link
        $url = explode('?', \Url::current());
        $url = $url[0] . '?' . \Request::query('order', "$column $direction");

        # retornamos o link formado e pronto para ordenar os registros
        return "<a class='$class' href='$url'>$icon $text</a>";
    }

    #
    ##
    ###
    # Métodos Internos #

    /**
     * Método de definição dos valores de entrada da paginação. Seu atributo de 
     * visibilidade é privado pois somente será referenciado no momento da 
     * paginação dos registro, não podendo sobreescrever estes valores em outros
     * instantes da aplicação a não ser outra paginação.
     * 
     * @return array $in valores de entrada da paginação
     * @return void
     */
    private static function setIn(array $in) {
        # unindo valores de entrada com os valores padrões
        $i = array_merge(($i = &static::$in), $in);

        # verificamos se a paginação está definida para obter os dados de 
        # entrada através das variáveis de requisição {$_GET} e {$_POST}.
        $i['method'] = strtolower($i['method']);
        if ($i['method'] == 'get')
            $i = array_merge($i, $_GET);
        else if ($in['method'] == 'post')
            $i = array_merge($i, $_POST);
    }

    /**
     * Calculamos os valores de saída da paginação.
     * 
     * @param string $model modelo referente a paginação
     * @return void
     */
    private static function calcOuts($model) {
        $i = &static::$in;
        $o = &static::$out;

        /* basics */ {
            # definindo modelo de entrada
            $i['model'] = $model;

            # calculando offset para buscar os registros
            $o['offset'] = $i['page'] * $i['limit'] - $i['limit'];
        }

        /* registros */ {
            # total de registros
            $o['records']['total'] = $model::count(isset($i['where']) ? $i['where'] : null);
            // $o['records']['total'] = 20;

            # número do registro de início da página
            $o['records']['start'] = 1 + $i['limit'] * ($i['page'] - 1);

            # número do registro de fim da página
            $o['records']['end'] = 1 + $i['limit'] * $i['page'];
        }

        /* página */ {
            # anterior: se for 0 ou menor atribuímos {null}
            $o['page']['previous'] = ($i['page'] - 1) <= 0 ? null : $i['page'] - 1;

            # total de páginas paginadas
            $o['page']['total'] = ceil($o['records']['total'] / $i['limit']);

            # próxima: se for maior que o total de página atribuímos {null}
            $o['page']['forward'] = ($i['page'] + 1 > $o['page']['total']) ? null : $i['page'] + 1;
        }
    }

}