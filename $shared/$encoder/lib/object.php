<?php

/**
 * <Encoder Framework>
 * A classe {Object} tem como objetivo representar o modelo básico de um 
 * classe pertencente ao <Encoder Framework>. Ou seja, a partir do momento que
 * uma classe qualquer herda de {Object}, esta agora pertence ao conjunto de 
 * classes do e está apta a trabalhar no conjunto.
 * 
 * Suas funcionalidades se limitão na descrição e no modelamento das classes 
 * filhas. Como obter seu nome; namespace; apelidos; Fornecer construtores 
 * estáticos e não estáticos; Descrever métodos; etc...
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Object {

    /**
     * Nome do método que será referenciado na inclusão de um arquivo/classe.
     * 
     * @defaultValue 'inclusion'
     * 
     * @var string
     */
    private static $methodOnInclude;

    /**
     * Nome do método que será referenciado na inclusão de um arquivo/classe.
     * 
     * @defaultValue 'init'
     * 
     * @var string
     */
    private static $methodConstructStatic;

    /**
     * Nome do método que será referenciado na instanciação de um arquivo/classe.
     * 
     * @defaultValue 'instantiation'
     * 
     * @var string
     */
    private static $methodAfterInstantiation;

    /**
     * Váriveis globais ou auxiliares para determinada classe interessada.
     * 
     * @var string
     */
    protected static $globals = array();

    /**
     * Método Setter e Getter para a propriedade {methodOnInclude}.
     * 
     * @param string $set
     * @return string
     */
    public static function methodOnInclude($set = null) {
        if (empty($set))
            return self::$methodOnInclude;

        return self::$methodOnInclude = $set;
    }

    /**
     * Método Setter e Getter para a propriedade {methodAfterInstantiation}.
     * 
     * @param string $set
     * @return string
     */
    public static function methodAfterInstantiation($set = null) {
        if (empty($set))
            return self::$methodAfterInstantiation;

        return self::$methodAfterInstantiation = $set;
    }

    /**
     * Método Setter e Getter para a propriedade {methodConstructStatic}.
     * 
     * @param string $set
     * @return string
     */
    public static function methodConstructStatic($set = null) {
        if (empty($set))
            return self::$methodConstructStatic;

        return self::$methodConstructStatic = $set;
    }

    /**
     * Chama de inclusão de classes do <Encoder Framework>, para toda classe que
     * for incluída/requerida automaticamente, este método será referênciado 
     * antes de qualquer outro. Dando a impressão de uma chamada {on_include}, 
     * ou seja, na inclusão efetue tais instruções...
     * 
     * Seu principal objetivo é buscar pelo arquivo de inicialização da classe e
     * fornecer as configurações básicas defidas pelo desenvolvedor. Como 
     * {setters} e {getters}.
     * 
     * @return void
     * 
     * @onInclude
     */
    public static function inclusion() {
        $class = self::nameFull();

        # inicializamos a classe caso exista um arquvo inicializador
        encoder_init_class(self::nameFullAlias());

        # referenciamos o construtor estático da classe, caso exista.
        if (method_exists($class, $constructStatic = self::methodConstructStatic())) {
            $class::$constructStatic();
        }
    }

    /**
     * Construtor estático do <Encoder Framework>, para toda classe que for 
     * incluída/requerida, este método será referênciado antes de qualquer 
     * interação desenvolvida no escopo da aplicação. Ou seja, antes de 
     * referenciar/métodos, atributos e antes de instanciar. Simulando um 
     * construtor estático.
     * 
     * 
     * Seu principal objetivo é definir inicializações lógicas, propriedades e 
     * parâmetros no escopo da classe. Nas quais você não deseja que aparecem 
     * no arquivo de inicialização, algo mais robusto ou longo.
     * 
     * @return void
     * 
     * @constructNonStatic
     */
    public static function init($data = array()) {
        self::setProperties($data);
    }

    /**
     * Construtor não estático do <Encoder Framework>, toda classe que for 
     * Instanciada, este método será referênciado de qualquer outro.
     * 
     * Seu principal objetivo é dar um nome mais elegante ao método {__construct},
     * primitivo do PHP. Permitindo também um momento prévio a instanciação 
     * literal do Objeto. Sendo que implementando o método {__construct} e o método
     * {instantiation}, o método {__construct} irá simular uma chamada 
     * {before_instantiation}, ou seja, antes da instanciação do objeto. 
     * Fornecendo um novo recurdo ao programador.
     * 
     * @param ? $data Dados passados no cabeçalho de instanciação da classe.
     * 
     * @return void
     * 
     * @constructNonStatic
     */
    public static function instantiantion($data) {
        return;
    }

    /**
     * Método construtor literal do PHP. 
     * Seu principal objetivo neste contexto é servir como evento 
     * {before_instantiation} e efetuar a referenciação do método construtor
     * do <Encoder Framework>, {instantiation}, e repassar os dados do parâmetro.
     * 
     * @param ? $data Dados que seão repassados ao método {instantiation}.
     * 
     * @return void
     * 
     * @onConstruct
     */
    public function __construct($data = null) {
        # instatiation magic method to pather class is called
        if (method_exists($this, 'instantiation'))
            $this->instantiation($data);
    }

    /**
     * Obtem o nome básico da classe filha, sem o {namespace}.
     * 
     * @return string
     */
    public static function name() {
        $class = explode('\\', get_called_class());
        return end($class);
    }

    /**
     * Obtem o apelido do nome básico da classe filha.
     * 
     * @return string
     */
    public static function nameAlias() {
        return Inflector::delimit(self::name());
    }

    /**
     * Obtem o {namespace} da classe filha.
     * 
     * @return string
     */
    public static function nameOfSpace() {
        $name = explode('\\', self::nameFull());
        unset($name[count($name) - 1]);
        return implode('\\', $name);
    }

    /**
     * Obtem o apelido do {namespace} da classe filha.
     * 
     * @return string
     */
    public static function nameOfSpaceAlias() {
        $name = explode('\\', self::nameFull());
        unset($name[count($name) - 1]);
        return strtolower(implode('_', $name));
    }

    /**
     * Obtem o nome completo da classe filha, incluindo o {namespace}.
     * 
     * @return string
     */
    public static function nameFull() {
        return get_called_class();
    }

    /**
     * Obtem o apelido completo da classe filha.
     * 
     * @return string
     */
    public static function nameFullAlias() {
        if ($namespace = self::nameOfSpaceAlias())
            $namespace .= '_';

        return $namespace . self::nameAlias();
    }

    /**
     * Obtém o objeto filho convertido para {array}.
     * 
     * @return array
     */
    public static function toArray() {
        $reflection = new ReflectionClass(self::nameFull());
        $vars = array_keys($reflection->getdefaultProperties());
        return $reflection->getStaticProperties();
    }

    /**
     * Verifica se um propriedade existe e se a mesmo não está nula.
     * 
     * @throws MissingProperty Exceção informando que a propriedade não está 
     *  definida ou está nula.
     * 
     * @param string $property Nome da propriedade que deseja verificar.
     * 
     * @return null
     * @return ? $value Valor da propriedade informada no parâmetro.
     */
    public static function getRequiredProperty($property) {
        $a = self::nameFull();

        if (!property_exists($a, $property))
            throw new MissingProperty($a . '::$' . $property . ' not defined');

        $value = call_user_func(array($a, ucfirst($property)));

        if (empty($value))
            throw new MissingProperty($a . '::$' . $property . ' is empty');

        return $value;
    }

    /**
     * A partir de um {array} onde o índice é o nome da que propriedade será 
     * definido pelo seu valor.
     * 
     * @param array $properties
     */
    public static function setProperties(&$properties, $destroy_on_set = FALSE) {
        $myName = self::name();
        $nproperties = array();

        if (is_array($properties)) {
            foreach ($properties as $property => $value) {

                # em alguns casos é necessário passar junto aos parâmentros algum 
                # índice que seja o nome de um atributo da classe, havendo assim 
                # uma colisão de índices. Para diferenciar isto, pôem-se um '@' 
                # antes do nome do índice, ex: 'database' => '@database'.
                $attribute = str_replace('@', '', $property);

                if (property_exists($myName, $attribute)) {
                    static::$attribute($value);

                    unset($properties[$property]);
                    $nproperties[$attribute] = $value;
                } else {
                    $nproperties[$attribute] = $value;
                }
            }

            if (!$destroy_on_set)
                $properties = $nproperties;
        }
    }

    /**
     * Obtem ou definide uma variável auxiliar ou globals para determinada 
     * classe.
     * 
     * @param string $name índice do valor
     * @param ? $value valor que será definido
     * @return ?
     */
    public static function globals($name = null, $value = null) {
        if (empty($name))
            return self::$globals;

        if (empty($value))
            return isset(self::$globals[$name]) ? self::$globals[$name] : null;

        return self::$globals[$name] = $value;
    }

}
