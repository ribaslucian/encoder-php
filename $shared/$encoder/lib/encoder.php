<?php

/**
 * <Encoder Framework>
 * A classe {Encoder ou App} tem como objetivo desempenhar as funcionalizadades básicas e 
 * de utilizadade interna. Como inicializar outras classes, calcular o tempo de 
 * execução da aplicação, etc...
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Encoder extends Object {

    /**
     * Tempo de execução da aplicaçao.
     * 
     * @var float
     */
    private static $timeExecution;

    /**
     * Nome do {Controller} base do Encoder.
     * Utilizado para verificar se outras classes são ou não um controllador 
     * válido.
     * 
     * @var string
     */
    private static $controller;

    /**
     * Nome do {Model} base do Encoder.
     * Utilizado para verificar se outras classes são ou não um modelo válido.
     * 
     * @var string
     */
    private static $model;

    /**
     * @genericSetGetter
     */
    public static function controller($set = null) {
        if (empty($set))
            return self::$controller;

        return self::$controller = $set;
    }

    /**
     * @genericSetGetter
     */
    public static function model($set = null) {
        if (empty($set))
            return self::$model;

        return self::$model = $set;
    }

    /**
     * Chama o arquivo de inicialização de uma classe. Baseado em um diretório
     * e em um arquivo nomeado com o apelido da classe. Por ex: "encoder\Model" 
     * está inicializado através do arquivo "encoder_model".
     * 
     * @param string $class é classe que deseja inicializar.
     */
    public static function initClass($class) {
        $file = CONFIG . Inflector::underscore($class) . '.php';

        if (file_exists($file))
            require $file;
    }

    /**
     * Na primeira chamada do método, é iniciado um contador de tempo de 
     * execução. Nas próximas chamadas será retornado o tempo utilizado
     * até o momento da chamada.
     * 
     * @return void
     * @return float
     */
    public static function timer() {
        if (empty(self::$timeExecution))
            return self::$timeExecution = microtime(TRUE);

        return substr(number_format(microtime(TRUE) - self::$timeExecution, 6), 0, -2);
    }

    /**
     * Verifica se uma determinada classe representa um {Controller} do encoder.
     * 
     * @param string $className
     * @return bool
     */
    public static function isController($className) {
        if (!is_subclass_of($className, '\\' . static::$controller))
            return false;

        return true;
    }

    /**
     * Verifica se uma determinada classe representa um {Controller} do encoder.
     * 
     * @param string $className
     * @return bool
     */
    public static function isModel($className) {
        if (!is_subclass_of($className, '\\' . static::$model))
            return false;

        return true;
    }

}
