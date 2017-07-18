<?php

/**
* Sistema de cache
*
* @author Thiago Belem <contato@thiagobelem.net>
* @link http://blog.thiagobelem.net/
*/
class Cache extends Object {

  /**
  * Tempo padrão de cache
  *
  * @var string
  */
  private static $time = '5 minutes';

  /**
  * Local onde o cache será salvo
  *
  * Definido pelo construtor
  *
  * @var string
  */
  private static $folder;

  /**
  * Define o tempo padrão que um cache ficará armazenado.
  *
  * @param string $set Tempo de expiração.
  * @return void
  */
  public static function time($set = null) {
    if (empty($set))
    return self::$time;

    return self::$time = $set;
  }

  /**
  * Define onde os arquivos de cache serão salvos
  *
  * Irá verificar se a pasta existe e pode ser escrita, caso contrário
  * uma mensagem de erro será exibida
  *
  * @param string $set Local para salvar os arquivos de cache (opcional)
  *
  * @return void
  */
  public static function folder($set = null) {
    if (empty($set))
      return self::$folder;

    # criamos a pasta de cache caso ainda nao exista
    Dir::create($set);

    # verificamos se a pasta e valida
    if (file_exists($set) && is_dir($set) && is_writable($set))
      static::$folder = $set;
    else
      throw new MissingFolder($set);
  }

  /**
  * Gera o local do arquivo de cache baseado na chave passada
  *
  * @param string $key Uma chave para identificar o arquivo
  *
  * @return string Local do arquivo de cache
  */
  protected static function generateFileLocation($key) {
    return static::$folder . DIRECTORY_SEPARATOR . sha1($key) . '.tmp';
  }

  /**
  * Cria um arquivo de cache
  *
  * @uses Cache::generateFileLocation() para gerar o local do arquivo de cache
  *
  * @param string $key Uma chave para identificar o arquivo
  * @param string $content Conteúdo do arquivo de cache
  *
  * @return boolean Se o arquivo foi criado
  */
  protected static function createCacheFile($key, $content) {
    // Gera o nome do arquivo
    $filename = static::generateFileLocation($key);

    // Cria o arquivo com o conteúdo
    return file_put_contents($filename, $content)
    OR trigger_error('Não foi possível criar o arquivo de cache', E_USER_ERROR);
  }

  /**
  * Salva um valor no cache
  *
  * @uses Cache::createCacheFile() para criar o arquivo com o cache
  *
  * @param string $key Uma chave para identificar o valor cacheado
  * @param mixed $content Conteúdo/variável a ser salvo(a) no cache
  * @param string $time Quanto tempo até o cache expirar (opcional)
  *
  * @return boolean Se o cache foi salvo
  */
  public static function save($key, $content, $time = null) {
    $time = strtotime(!is_null($time) ? $time : self::$time);

    $content = serialize(array(
      'expires' => $time,
      'content' => $content
    ));

    return static::createCacheFile($key, $content);
  }

  /**
  * Salva um valor do cache
  *
  * @uses Cache::generateFileLocation() para gerar o local do arquivo de cache
  *
  * @param string $key Uma chave para identificar o valor cacheado
  *
  * @return mixed Se o cache foi encontrado retorna o seu valor, caso contrário retorna NULL
  */
  public static function read($key) {
    $filename = static::generateFileLocation($key);
    if (file_exists($filename) && is_readable($filename)) {
      $cache = unserialize(file_get_contents($filename));

      if ($cache['expires'] > time())
      return $cache['content'];
      else
      unlink($filename);
    }

    return null;
  }

  public static function _cache($key, $value = null) {
    if (empty($value))
    return static::read($key);

    return static::save($key, $value);
  }

  public static function reload() {
    return array_map('unlink', glob(static::$folder . '*'));
  }

}
