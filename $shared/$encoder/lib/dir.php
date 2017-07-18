<?php

/**
 * A classe {Dir} tem como objetivo gerenciar os diretórios e classes
 * armazenadas no <Encoder Framework>. Tais como a busca por classes
 * armazenadas, criação e leitura de diretórios, gerenciamento de diretóios em
 * geral.
 *
 * A classe é abstrata e estática pois em nenhum momento será necessária sua
 * independente instanciação.
 *
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Dir extends Object {

    /**
     * Vetorização de todas dos diretórios de todas as classes armazenadas
     * no projeto.
     *
     * @var array[class_name] => directory
     */
    private static $applicationClasses;

    /**
     * Obtém todas as classes, traits, e outras entidades armazenadas no
     * diretório passado por parâmetro. Abstraindo seu nome, namespace, local...
     *
     * @param string $dir Diretório que se deseja mapear.
     * @return array
     */
    public static function getClasses($dir = null) {
        if (empty($dir))
            return null;

        $class_paths = array();

        foreach (new \RegexIterator(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir)), '/\.php$/') as $file) {
            $namespace = '';

            # $tokens = token_get_all(implode('', array_slice(file($file->getRealPath()), 0, 20)));
            $tokens = token_get_all(implode('', file($file->getRealPath())));

            $s = count($tokens);
            for ($i = 0; $i < $s; $i++) {
                if ($tokens[$i][0] == T_NAMESPACE) { # definindo o namespace da classe
                    $i += 2; # pulando os caracters "\"
                    while (is_array($tokens[$i]) && ($i < $s))
                        ($namespace .= $tokens[$i][1]) & ++$i;
                }

                if (
                    T_CLASS === $tokens[$i][0] ||
                    T_TRAIT === $tokens[$i][0] ||
                    T_INTERFACE === $tokens[$i][0]
                ) { # definindo o nome da classe ou trait
                    ($i += 2) & ($namespace .= $namespace ? '\\' : ''); # verificando se foi definido um namespace
                    $class_paths[$namespace . $tokens[$i][1]] = $file->getRealPath();
                }
            }
        }

        return $class_paths;
    }

    /**
     * Método Getter & Setter da propriedade {$applicationClasses}.
     *
     * @param string $project_directory Diretório da pasta do projeto.
     *
     * @return array
     * @return void
     */
    public static function applicationClasses() {

//        return static::$applicationClasses = static::getClasses(ROOT);

        if (!empty(self::$applicationClasses))
            return self::$applicationClasses;

        # verificamos se o valor ainda está cacheado
        if (!static::$applicationClasses = Cache::read('Dir::applicationClasses')) {

            # mapeamos as classes do diretório APP, ENCODER
            // static::$applicationClasses = array_merge(@static::getClasses(ROOT), @static::getClasses(ENCODER));
            static::$applicationClasses = array_merge(@static::getClasses(APP), @static::getClasses(SHARED));

            cache('Dir::applicationClasses', static::$applicationClasses);
        }
    }

    /**
     * Obtem o diretório de todas ou uma única classe armazenada no escopo
     * do projeto.
     *
     * @param string $class_name
     *
     * @return array
     * @return false A classe não existe
     * @return string
     */
    public static function classDir($class_name = null) {

        # return all classes if $class_name null
        if (empty($class_name))
            return self::$applicationClasses;

        # class not found
        if (!array_key_exists($class_name, self::$applicationClasses))
            return false;

        return self::$applicationClasses[$class_name];
    }

    /**
     * Converte um diretório para um {array}.
     *
     * @param string $dir
     *
     * @return array Árvore do diretório
     */
    public static function arrayParse($dir) {
        $result = array();

        foreach (scandir($dir) as $key => $value) {
            if (!in_array($value, array('.', '..'))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                    $result[$value] = static::arrayParse($dir . DIRECTORY_SEPARATOR . $value);
                else
                    $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * Cria um diretório caso mesmo ainda não exista.
     *
     * @param string $dir Diretório que deseja criar
     *
     * @return boolean
     */
    public static function create($dir) {
        return file_exists($dir) ? true : mkdir($dir, 0777, true);
    }

    /**
     * Pega todos os arquivos armazanados em um determinado diretório e salvos
     * em uma determinada extensão.
     *
     * @param string $dir Diretório que se deseja obter os arquivos.
     * @return array de arquivos
     */
    public static function getFiles($dir, $extention = 'php') {
        $files = array();

        foreach (new RegexIterator(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)), '/^.+\.' . $extention . '$/i', RecursiveRegexIterator::GET_MATCH) as $n)
            $files[] = $n[0];

        return $files;
    }

    /**
     * Verifica se existe uma classe na aplicação.
     *
     * @param string $name
     * @return boolean
     */
    public static function hasClass($name) {
        return array_key_exists($name, self::$applicationClasses);
    }

}
