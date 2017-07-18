<?php

/**
 * <Encoder Framework>
 * A classe {Http} tem como objetivo desempenhar funcionalidades voltadas ao 
 * protocolo HTTP. Como chamadas utilizando o método {GET} e {POST}.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessário sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Http extends Object {

    /**
     * Efetua uma chamada utilizando o método {POST}
     * 
     * @param string $url Endereço que deseja enviar a chamada.
     * @param ? $data Dados {POST} que serão enviandos junto a chamada.
     * 
     * @return ?
     */
    public static function post($url, $data) {
        // use key 'http' even if you send the request to https://...
        return file_get_contents($url, false, stream_context_create(array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        )));
    }

    /**
     * Efetua uma chamada utilizando o método {GET}
     * 
     * @param string $url Endereço que deseja enviar a chamada.
     * @param ? $data Dados {GET} que serão enviandos junto a chamada.
     * 
     * @return ?
     */
    public static function get($url, $data = array()) {
        return file_get_contents($url . '?' . http_build_query($data));
    }

    /**
     * A partir de uma váriavel {array/objeto} o método constrói um {query} no 
     * formato de {string} convertendo para parâmetros {GET} válidos. Restando
     * apenas concatenar a {string} na {URL} destino.
     * Caso a valor {$baseQuery} Não seja informado, será atribuído nos 
     * parâmentros {$_GET} da requisição atual.
     * 
     * @param string $key Índice que deseja atribuir um novo valor
     * @param ? $value Valor que deseja atribuir no índice {$key}
     * @param array $baseQuery Valor base que será criado a {query}
     * 
     * @return string
     */
    public static function makeQuery($key = null, $value = null, $baseQuery = null) {
        $get = $_GET;

        if ($key !== null && $value !== null)
            $get[$key] = $value;

        return http_build_query($get);
    }

}
