<?php

/**
 * <Encoder Framework>
 * A classe {Format} tem como objetivo formatar valores básicos e transformá-los
 * em outro valor retornável, adaptando-ô para algum momento especifíco.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Format {

    /**
     * Formata um monetário para um valor primitivo {float}.
     * 
     * @param string $money
     * 
     * @return float
     */
    public static function moneyToFloat($money) {
        $money = str_replace(array('.', ','), array('', '.'), $money);
        return $money;
    }

    /**
     * Formata um float para uma string que representa o mesmo na moeda local.
     * 
     * @param string $money
     * 
     * @return float
     */
    public static function money($float) {
        return number_format($float, 2, ',', '.');
    }

    /**
     * Transforma {bytes} em {megabytes}. Útil durante o envio de arquivos.
     * 
     * @param int $bytes
     * 
     * @return int
     */
    public static function megabytes($bytes) {
        return number_format($bytes / 1048576, 2, '.', '');
    }

    /**
     * Limita uma {string} em uma quantidade máxima de caracteres e concatena
     * um valor indicando a limitação.
     * 
     * @param string $string Que deseja limitar
     * @param string $max_chars Quantidade máxima de caracteres
     * @param string $complete_with Valor que será concatenado
     * 
     * @return string Valor limitado
     */
    public static function limitStr($string, $max_chars = 16, $complete_with = '...') {
        return mb_strimwidth($string, 0, $max_chars, $complete_with);
    }

    /**
     * Comprimi uma string retirando todos seus espaços.
     * 
     * @param <string> $string
     * @return <string>
     */
    public static function compress($string) {
        $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace = array('>', '<', '\\1');
        return preg_replace($search, $replace, $string);
    }
    
    /**
     * Converte um valor para json.
     * 
     * @param ? $value
     * @return string json
     */
    public static function json($value) {
        return json_encode($value);
    }

}
