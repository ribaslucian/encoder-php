<?php

/**
 * <Encoder Framework>
 * A classe {Security} tem como objetivo fornecer os recursos básicos de 
 * segurança da aplicação. Como geração de códigos únicos, criptografias, etc.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Security extends Object {

    /**
     * Salto de segurança da aplicação. 8, 16 or 32 caracteres.
     * 
     * @var string
     */
    private static $salt;

    /**
     * Método Getter & Setter do atributo {$salt}.
     * 
     * @param string $set Salto que deseja definir
     * @return string
     */
    public static function salt($set = null) {
        if (empty($set))
            return self::$salt;

        return self::$salt = $set;
    }

    /**
     * Criptografa um determinado valor a partir de uma senha de retorno.
     * 
     * @throws InvalidValue Senha de descriptografia inválida ou muito longa.
     * 
     * @param ? $data Valor que deseja criptografar.
     * @param string $pass 8, 32, 64 Senha de descriptografia.
     * 
     * @return string Valor encriptado.
     */
    public static function encryptPass($data, $pass = null) {
        if (isset($pass{32}))
            throw new InvalidValue('Pass ir more long "' . $pass . '", max 32 caracteres.');

        $pass = $pass ? : Security::$salt;
        $encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $pass, json_encode($data), MCRYPT_MODE_ECB);
        return trim(base64_encode($encrypt));
    }

    /**
     * Descriptografa um determinado valor a partir de uma senha.
     * 
     * @throws InvalidValue Senha de descriptografia inválida ou muito longa.
     * 
     * @param ? $data Valor que deseja descriptografar.
     * @param string $pass 8, 32, 64 Senha de descriptografia.
     * 
     * @return string Valor desencriptado.
     */
    public static function dencryptPass($encrypted, $pass = null) {
        if (isset($pass{32}))
            throw new InvalidValue('Pass ir more long "' . $pass . '", max 32 caracteres.');

        $pass = $pass ? : Security::$salt;
        $encrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $pass, base64_decode($encrypted), MCRYPT_MODE_ECB);
        return trim($encrypted);
    }

    /**
     * Efetua uma chamada GET passando um parâmetro 'data' com valor
     * criptografado.
     * 
     * @param string $url Endereço que deseja efetuar a chamada.
     * @param ? $data
     * @return ?
     */
    public static function request($url, $data) {
        $data = http_build_query(array(
            'data' => \Security::encryptPass(json($data))
        ));

        return json_decode(Security::dencryptPass(file_get_contents($url . '?' . $data)));
    }

    /**
     * Responde a uma chamada criptografada. Efetua a partir do método 
     * Security::request.
     * 
     * @param string $data
     */
    public static function respondRequest($data) {
        die(Security::encryptPass(json_encode($data)));
    }

    /**
     * Gerá uma hash aleatória.
     * 
     * @param int $length Tamanho da hash que deseja criar.
     * @param function($hash) $method_return
     * 
     * @return string
     */
    public static function random($length = 32, $method_return = null) {
        $hash = bin2hex(openssl_random_pseudo_bytes($length / 2));
        return $method_return ? $method_return($hash) : $hash;
    }

}
