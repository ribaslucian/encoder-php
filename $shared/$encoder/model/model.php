<?php

/**
 * <Encoder Framework>
 * A classe {encoder\Model} tem como servir como modelo básico para os modelos
 * que irão existir na aplicação. Possuindo funções para interação com o objeto
 * que o modelo descreve e com o banco de dados definido na conexão do modelo.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

namespace encoder;

abstract class Model extends \Object {

    /**
     * Ações que o modelo atual irá efetuar em determinados eventos.
     * 
     * @var array
     */
    public static $event = array();

    #
    ##
    ###
    # BASICS #

    /**
     * Atravez do atributo $event, será referenciado outro método para 
     * determinada algumas ações. No primeiro indíce é definido o  evento (find, 
     * delete, update, save). No segundo índice o momento (before, after).
     * 
     * @param string $event Nome do evento
     * @param string $instant Instante do evento
     */
    protected static function event($event, $instant, &$model) {
        $event = $instant . ':' . $event;
        $methods = isset(static::$event[$event]) ? static::$event[$event] : null;

        if (is_array($methods))
            foreach ($methods as $method)
                static::$method($model);
        else
            $methods ? static::$methods($model) : false;

        return true;
    }

    /**
     * Obtem o nome do modelo de filtro relacionado ao modelo atual.
     * 
     * @return string
     */
    public static function nameFilter() {
        $name = str_replace(static::name(), 'filter\\' . static::name(), static::nameFull());
        return str_replace('views\\', '', $name);
    }

    #
    ##
    ###
    # DATABASE #

    /**
     * Conexão com banco de dados que o modelo irá utilizar.
     * 
     * @var string
     */
    public static $connection;

    #
    ##
    ###
    # SCHEMA #

    /**
     * Método {Setter} e {Getter} genérico para o atributo {$connection}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, vai apenas retornar.
     * 
     * @return string $set
     */
    public static function connection($set = null) {
        # retornamos, se existir um tabela definida manualmente.
        if (property_exists(static::nameFull(), 'connection')) {
            if (!empty(static::$connection))
                return static::$connection;
        }
        
        if (empty($set))
            return self::$connection;
        
        return (self::$connection = $set);
    }

    /**
     * Table Getter.
     * 
     * @return string
     */
    public static function table() {
        # retornamos, se existir um tabela definida manualmente.
        if (property_exists(static::nameFull(), 'table'))
            return static::$table;

        # se não retornamos o nome do modelo no plueral.
        return strtolower(pluralize(static::name()));
    }

    public static function tables() {
        return \Db::tables(array(
                    'connection' => static::$connection,
                    'table' => static::table(),
        ));
    }

    /**
     * Make query on connection datasource model.
     * 
     * @param string $sql
     * @return ?
     */
    public static function query($sql) {
        return \Db::query($sql, static::$connection);
    }

    /**
     * Get table model coluns
     * 
     * @return array
     */
    public static function columns() {
        return \Db::columns(array(
            'connection' => static::$connection,
            'table' => static::table(),
        ));
    }

    /**
     * Check if model has column
     * 
     * @param string $column
     * @return boolean
     */
    public static function hasColumn($column) {
        return in_array($column, static::columns());
    }

    /**
     * Descreve as restrições de uma coluna no banco de dados.
     * 
     * @param string $restriction Restrição que deseja obter da coluna
     * Opções: table, column, default, nullable, updatable, type, max_length, precision
     * 
     * @return array
     */
    public static function description($column, $restriction = null) {
        $options = array(
            'connection' => static::$connection,
            'table' => static::table(),
            'column' => $column,
        );

        if ($restriction)
            $options['option'] = $restriction;

        return \Db::columnDescription($options);
    }

    #
    ##
    ###
    # SCHEMA CRUD #

    /**
     * Insert a table record related with current model.
     * 
     * @param array $data [column => value]
     * 
     * @return booelan
     */
    public static function insert(array $data) {
        $data['@connection'] = static::$connection;
        $data['@table'] = static::table();

        if (\Vetor::countBranches($data) <= 1 && static::hasColumn('id_ns'))
            $data['id_ns'] = security_random(8) . sha1('Y-m-d H:i:s') . security_random(8);

        return $c = \Db::insert($data);
    }

    /**
     * Update table records related with current model.
     * 
     * @param array $data [column => value]
     * @param array $where 'id = 1', ['id = 1', 'id = 2', [id => 2]]
     * 
     * @return booelan
     */
    public static function update(array $data, $where = '') {
        $data['@connection'] = static::$connection;
        $data['@table'] = static::table();
        $data['@where'] = $where;
        return \Db::update($data);
    }

    /**
     * Delete table records related with current model.
     * 
     * @param array $where 'id = 1', ['id = 1', 'id = 2', [id => 2]]
     * 
     * @return booelan
     */
    public static function delete($where = null) {
        return \Db::delete(array(
                    '@connection' => static::$connection,
                    '@table' => static::table(),
                    'where' => $where
        ));
    }

    #
    ##
    ###
    # SCHEMA UTILITY #

    /**
     * @docs in Datasouce
     */
    public static function begin() {
        return \Datasource::begin(static::connection());
    }

    /**
     * @docs in Datasouce
     */
    public static function commit() {
        return \Datasource::commit(static::connection());
    }

    /**
     * Find records on connection.
     * 
     * @param array $options
     * @return array
     */
    public static function find($options = array()) {
        $options['@connection'] = static::$connection;
        
        // definimos aonde será feito a busca dos registro: tabela ou view do model
        if (property_exists(static::nameFull(), 'view'))
            $options['@table'] = static::$view;
        else
            $options['@table'] = static::table();
        
        $c = \Db::select($options);

        if (empty($c) || $c === true)
            return array();

        # tranformamos todos os resultados em uma instancia do seu modelo.
        $m = static::nameFull();
        $c[key($c)] = new $m(current($c));
        for (; next($c); $c[key($c)] = new $m(current($c)))
            ;

        return $c;
    }

    /**
     * Get by options first record on connection.
     * 
     * @param array $options [fields, where, order, offset]
     * @return encoder\model
     */
    public static function first($options = array()) {
        $options['@connection'] = static::$connection;
        $options['@table'] = static::table();

        $c = \Db::first($options);

        if (!empty($c)) {
            $model = static::nameFull();
            return new $model($c);
        }

        return array();
    }

    /**
     * Count table records by condition
     * 
     * @param array $where 'id = 1', ['id = 1', 'id = 2', [id => 2]]
     * 
     * @return int
     */
    public static function count($where = '') {
        return \Db::count(array(
            '@connection' => static::$connection,
            '@table' => static::table(),
            'where' => $where
        ));
    }

    /**
     * Check by WHERE clause if record exists.
     * 
     * @param ? $where
     * 
     * @return boolean
     */
    public static function exists($where = '') {
        return \Db::exists(array(
                    '@connection' => static::$connection,
                    '@table' => static::table(),
                    'where' => $where
        ));
        return static::count($where) > 0;
    }

    /**
     * Get a record by id.
     * 
     * @param type $field
     * @param type $options
     */
    public static function byId($id) {
        $model_name = self::nameFull();
        $data = @\Db::first(array(
                    'connection' => static::$connection,
                    'table' => static::table(),
                    'id' => $id,
        ));
        return new $model_name($data);
    }

    /**
     * Generate new id to a record.
     * 
     * @return string
     */
    public static function newId() {
        return \Db::newId(array(
                    'connection' => static::$connection,
                    'table' => static::table()
        ));
    }

    /**
     * Paginação de registros deste modelo.
     * 
     * @param array $in dados de entrada ou de definição de paginação
     * @return array registros páginados.
     */
    public static function paginate($in = array(), $useView = false) {
        return \Paginate::find(static::nameFull(), $in);
    }

    /**
     * Obtém o último erro ocorrido na conexão do model referente.
     * 
     * @return array
     */
    public static function lastError() {
        return \Db::lastError(static::connection());
    }

    #
    ##
    ###
    # ENTITY #

    /**
     * Campo que ficará salvo as mensagens 
     * definida para uma determinada entidade.
     * 
     * @var string
     */
    private static $messageErrorsField;

    /**
     * Campo que ficará salvo o objeto que irá 
     * gerar HTMLs referentes à entidade de referência.
     * 
     * @var string
     */
    private static $htmlField;

    #
    ##
    ###
    # ENTITY UTILS #

    /**
     * @FrameworkInstantialConstructor
     */
    public function instantiation($data) {
        if ($data == null)
            return;

        if (is_array($data) || is_object($data))
            return $this->setPropertiesByData($data);

        $this->unknow_data = $data;
    }

    /**
     * @genericSetGetter
     * 
     * Método genérico para definição (set) / obtenção (get) do atributo 
     * {$messageErrorsField}. Ao informar o parâmetro {$set}, será definido 
     * (set) seu valor no atributo e logo após retornado. Caso contrário, 
     * apenas será obtido (get).
     * 
     * @param int $set Valor à definir
     * @return int $set
     */
    public static function messageErrorsField($set = null) {
        if (empty($set))
            return self::$messageErrorsField;

        return self::$messageErrorsField = $set;
    }

    /**
     * @genericSetGetter
     * 
     * Método genérico para definição (set) / obtenção (get) do atributo 
     * {$htmlField}. Ao informar o parâmetro {$set}, será definido (set) seu 
     * valor no atributo e logo após retornado. Caso contrário, apenas será 
     * obtido (get).
     * 
     * @param int $set Valor à definir
     * @return int $set
     */
    public static function htmlField($set = null) {
        if (empty($set))
            return self::$htmlField;

        return self::$htmlField = $set;
    }

    /**
     * Define object properties bay $data array or object.
     * 
     * @param array $data
     * @param object $data
     */
    public function setPropertiesByData($data) {
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }

    /**
     * Destrói as colunas que foram passadas por parâmetro na instância de um modelo.
     * 
     * @param array $data
     * @param object $data
     * 
     * @return void
     */
    public function destroyPropertiesNotIsColumn() {
        $columns = static::columns();

        foreach ($this as $attr => $val) {
            if (!in_array($attr, $columns))
                unset($this->$attr);
        }
    }

    /**
     * Generate where conditions by coluns.
     * 
     * @param strin $columns
     * @return string
     */
    private function conditionsByColumns($columns) {
        $where = array();

        foreach (explode(',', str_replace(' ', '', $columns)) as $column) {
            if (!empty($column)) {
                $where[$column] = $this->$column;
                # unset($this->$column);
            }
        }

        return $where;
    }

    /**
     * Check if current instance has a particular attribute.
     * 
     * @param string $attr
     * @return boolean
     */
    public function hasAttr($attr) {
        return $this->$attr;
    }

    /**
     * Obtém ou define uma mensagem de um determinado campo.
     * 
     * @param string $field
     * @param string $message
     * @return string
     */
    public function message($field, $message = null) {
        $message_field = static::messageErrorsField();

        # obtemos todas as mensagens definidas
        $messages = isset($this->$message_field) ? $this->$message_field : array();

        # verificamos se é pra definir uma mensagem no campo
        if (!is_null($message)) {

            # definimos uma nova mensagem para o campo {$field}
            $messages[$field][] = $message;
            $this->$message_field = $messages;
            return;
        }

        # verificamos se existe uma mensagem e retornamos, se não retornamos {null}
        return isset($messages[$field][0]) ? $messages[$field][0] : null;
    }

    /**
     * Obtém todas as mensagens de erro definida 
     * para um campo ou para a entidade complete.
     * 
     * @param string $messages
     */
    public function messages($field = NULL) {
        $message_field = static::messageErrorsField();

        # obtendo todas as mensagens definidas
        $messages = isset($this->$message_field) ? $this->$message_field : NULL;

        # retornando apenas as mensagens do campo solicitado em $field
        if (is_string($field))
            return isset($messages[$field]) ? $messages[$field] : NULL;

        # retornamos todas as mensagens
        return $messages;
    }

    /**
     * Efetua a validação da entidade referenciadora.
     * 
     * @return boolean
     */
    public function valid() {
        $valid = true;

        # buscando por sub-modelos pra serem validados.
        foreach ($this as $attr => $value) {
            if (is_object($value))
                if (!$value->valid())
                    $valid = false;
        }

        if (!\Validate::model($this))
            $valid = false;

        return $valid;
    }

    /**
     * Verifica se existe um índice no $_GET ou $_POST da requisação atual 
     * referente ao nome do modelo referenciador. Caso existir irá obter uma 
     * instância do modelo a partir do valor do índice.
     * 
     * @return encoder\Model
     */
    public static function request($method = 'post', $includes = array()) {
        $model = self::nameFull();

        # obtemos os dados enviados pelo usuário
        $requested = array();
        if ($method == 'post')
            $requested = \Request::post($model) ? : array();
        else if ($method == 'get')
            $requested = \Request::get($model) ? : array();

        # verificamos se a chamada request já foi chamada referenciada 
        # anteriormente, deixando definido um objeto no paramêtro de requisição.
        if (is_object($requested))
            return $requested;

        # unimos aos dados do formulário se for enviado algum arquivo para o modelo atual;
        # instanciamos um objetos modelo da aplicação, representando uma entidade.
        $model = new $model(array_merge($requested, static::getDataFiles()));

        # reescrevemos os dados enviados por formulário para os OBJETOS da aplicação
        if (!$model->nil()) {
            if ($method == 'post')
                $_POST[self::nameFull()] = $model;
            else if ($method == 'get')
                $_GET[self::nameFull()] = $model;
        }

        return $model;
    }

    /**
     * Verifica se um objeto modelo está vazio.
     * 
     * @return boolean
     */
    public function nil() {
        $model = (array) $this;
        return empty($model);
    }

    /**
     * Define na visão correspondete ao controlador da rota atual, uma variável 
     * com o conteúdo do modelo atual, nomeada com seu nome básico.
     * 
     * @return void
     */
    public function view($prefix = '', $sulfix = '') {
        set($prefix . delimit($this::name()) . $sulfix, $this);
    }

    /**
     * Cria/Retorna um objeto gerador de HTML para
     * uma instancia específica de um modelo.
     * 
     * @return \html\Model
     */
    public function html() {
        if (!isset($this->__html))
            $this->__html = new \model\Html($this);

        return $this->__html;
    }

    /**
     * Obtém de forma padronizada todos os arquivos
     * que estão sendo enviado a este modelo by POST.
     * 
     * @return array
     */
    private static function getDataFiles() {
        $data_files = array();

        if (@$files = $_FILES[self::nameFull()]) { # verificamos se existe algum arquivo sendo enviado a este model.
            foreach ($files['name'] as $column => $value) { # percorrendo colunas
                if (!is_array($files['name'][$column])) { # se o input atual possui um único arquivo.
                    $data_files[$column]['name'] = $value;
                    $data_files[$column]['type'] = $files['type'][$column];
                    $data_files[$column]['tmp_name'] = $files['tmp_name'][$column];
                    $data_files[$column]['error'] = $files['error'][$column];
                    $data_files[$column]['size'] = $files['size'][$column];

                    $ext = explode('.', $value);
                    $ext = $ext[count($ext) - 1];

                    # definindo nome para salvar o arquivo.
                    $data_files[$column]['save_name'] = $column . '_' . security_random() . '.' . $ext;
                    $data_files[$column]['extension'] = $ext;
                } else {
                    foreach ($files['name'][$column] as $key => $name) { # se o input atual possui vários arquivo.
                        $data_files[$column][$name]['type'] = $files['type'][$column][$key];
                        $data_files[$column][$name]['tmp_name'] = $files['tmp_name'][$column][$key];
                        $data_files[$column][$name]['error'] = $files['error'][$column][$key];
                        $data_files[$column][$name]['size'] = $files['size'][$column][$key];

                        $ext = explode('.', $value);
                        $ext = $ext[count($ext) - 1];

                        # definindo nome para salvar o arquivo.
                        $data_files[$column][$name]['save_name'] = $column . '_' . random(16) . '.' . $ext;
                        $data_files[$column]['extension'] = $ext;
                    }
                }
            }
        }
        return $data_files;
    }

    #
    ##
    ###
    # ENTITY CRUD #

    /**
     * Save object on table model.
     * 
     * @return bool
     */
    public function save() {
        $this->created = date('Y-m-d H:i:s');

        # @event
        static::event('save', 'before', $this);

        $this->destroyPropertiesNotIsColumn();
        $r = (array) $this;
        $r['@connection'] = static::connection();
        $r['@table'] = static::table();
        $r = \Db::insert($r);

        # @event
        return $r ? static::event('save', 'after', $this) : false;
    }

    /**
     * Edit object on record.
     * 
     * @param string $by
     * @return boolean
     */
    public function edit($by = 'id') {
        # @event
        static::event('edit', 'before', $this);

        $this->updated = isset($this->updated) ? $this->updated : date('Y-m-d H:i:s');
        $this->destroyPropertiesNotIsColumn();

        $conditions = $this->conditionsByColumns($by);

        $r = (array) $this;
        $r['@where'] = $conditions;
        $r['@connection'] = static::connection();
        $r['@table'] = self::table();
        $r = \Db::update($r);

        # @event
        return $r ? static::event('edit', 'after', $this) : false;
    }

    /**
     * Remove object from records.
     * 
     * @param string $by
     * @return bool
     */
    public function remove($by = 'id') {
        # @event
        static::event('remove', 'before', $this);
        $remove = static::delete($this->conditionsByColumns($by));

        # @event
        return $remove ? static::event('remove', 'after', $this) : false;
    }

}
