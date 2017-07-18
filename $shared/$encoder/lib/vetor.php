<?php

/**
 * Métodos de manipulação de arrays (vetores).
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Vetor {

    /**
     * Verifica se existe determinados índices de um array.
     * Caso não existe lança uma exceção.
     * 
     * @param array $array
     * @param string $indexes 'index1, index2'
     */
    public static function requireIndex($array, $indexes) {
        foreach ($indexes as $index)
            if (!isset($array[$index]))
                throw new MissingIndex('Is required index #' . $index);
    }

    /**
     * print_r() convenience function
     *
     * In terminals this will act similar to using print_r() directly, when not run on cli
     * print_r() will also wrap <pre> tags around the output of given variable. Similar to debug().
     *
     * @param mixed $var Variable to print out
     * @return void
     * @see debug()
     * @link http://book.cakephp.org/3.0/en/core-libraries/global-constants-and-functions.html#pr
     * @see debug()
     */
    public static function show($array) {
        $template = php_sapi_name() !== 'cli' ? '<pre>%s</pre>' : '\n%s\n';
        printf($template, print_r($array, true));
    }

    /**
     * Converte uma string básica para um array básico.
     * 'val1, val2' >>>> array(val1, val2)
     * 
     * @param string $string
     * @param char $explode
     * @return array
     * 
     */
    public static function byStrSlim($string, $explode = ',') {
        if (stripos($string, $explode) === false)
            return trim($string);

        $string = explode($explode, $string);

        foreach ($string as $key => $value)
            $string[$key] = trim(str_replace(',', '', $value));

        return $string;
    }

    /**
     * Captura todos os últimos galhos de um Array 
     * independente de quantos sub-galhos o mesmo tenha.
     * 
     * @param array $array que será capturado os últimos galhos
     * @param array $match recipiente para os últimos galhos
     * @param int $cb número do galho atual
     * 
     * @return array
     */
    public static function lastBranches(array $array, &$match, $cb = 0) {
        foreach ($array as $key => $value)
            is_array($value) ? self::lastBranches($value, $match, $cb++) : $match[$cb][] = $value;
    }

    /**
     * @logicError
     * Conta a quantidade de raízes que possui o array.
     * 
     * @return integer.
     */
    public static function countBranches(array $array) {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = self::countBranches($value) + 1;

                if ($depth > $max_depth)
                    $max_depth = $depth;
            }
        }

        return $max_depth;
    }

    /**
     * Tranforma uma string em um array
     * ':key value :key value'
     * 
     * @param string $str
     * 
     * @return <array>
     */
    public static function byString($str) {
        preg_match_all("/:(.*?) /", ($str = $str . ':'), $matches);

        $a = array();
        foreach ($matches[1] as $key => $ind) {
            preg_match("/$ind(.*?):/", $str, $sub_matches);
            @$a[$ind] = $sub_matches[1];
        }

        return $a;
    }
}
