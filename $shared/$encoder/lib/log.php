<?php

/**
* A classe {Log} tem como objetivo gerenciar os logs efetuados pelo
* <Encoder Framework>. Criar e obter novos logs.
*
* A classe é abstrata e estática pois em nenhum momento será necessária sua
* independente instanciação.
*
* @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
* @link <https://www.facebook.com/lucian.ribas> Facebook
*/
abstract class Log extends Object {

  /**
  * Diretório onde serão salvos os logs.
  *
  * @var string
  */
  private static $path;

  /**
  * Caracter que será inserido após um log qualquer, ao fim de sua linha.
  *
  * @var string
  */
  private static $lineEnd;

  /**
  * Verifica se um caminho interno ao diretório de logs é valido.
  *
  * @throws MissingFolder diretório inválido.
  * @param true
  */
  public static function isValidPath($path) {
    if (!is_dir($path))
    throw new MissingFolder('No log folder ' . $path);

    return true;
  }

  /**
  * Método {Setter} e {Getter} genérico para o atributo {path}.
  * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
  * Se não, o valor será apenas retornado.
  *
  * @return string $key
  */
  public static function path($set = null) {
    if (empty($set))
    return self::$path;

    self::$path = $set;

    # criamos a pasta de cache caso ainda nao exista
    Dir::create($set);

    # verificamos se o log informado é válido.
    static::isValidPath($set);

    return $set;
  }

  /**
  * Método {Setter} e {Getter} genérico para o atributo {lineEnd}.
  * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
  * Se não, o valor será apenas retornado.
  *
  * @return string $key
  */
  public static function lineEnd($set = null) {
    if (!empty($set))
    return self::$lineEnd = $set;

    return self::$lineEnd;
  }

  /**
  * Escreve um valor em um determinado log.
  *
  * @param string $name Nome do log que se deseja salvar o valor.
  * @param string $content Valor que será salvo.
  *
  * @return boolean
  */
  public static function write($name, $content) {
    $folder = static::$path . str_replace(array(basename($name), '/', '\\'), array('', I, I), $name);
    $name = basename($name) . '.tmp';

    # criamos a subpasta do log caso nao exista
    Dir::create($folder);

    # verificamos se o log informado é válido.
    static::isValidPath($folder);

    if (!($file = fopen($folder . $name, 'a')))
      return false;

    fwrite($file, $content . self::$lineEnd);
    fclose($file);

    return true;
  }

  /**
  * Obtem o todo o contéudo de um determinado log.
  *
  * @param string $name
  * @return string
  */
  public static function get($name) {
    # verificamos se o log informado é válido.
    static::isValidPath($name);

    return file_get_contents(self::$path . $name);
  }

  /**
  * Deleta um arquivo de log.
  *
  * @param string $name No do log que deseja deletar.
  *
  * @return boolean
  */
  public static function destroy($name) {
    # verificamos se o log informado é válido.
    static::isValidPath($name);

    return unlink(self::$path . $name);
  }

  /**
  * Este método possui função genérica para a classe {Log}.
  * Ou seja, se vc passar o conteúdo, ele irá definir um log.
  * Se não, vai retornar o conteúdo o log informado.
  *
  * @param string $name Nome do log que deseja obter ou escrever
  * @param string $content Conteúdo que deseja escrever
  *
  * @return bool
  * @return string
  */
  public static function logger($name, $content = null) {
    return !$content ? self::get($name) : self::write($name, $content);
  }

}
