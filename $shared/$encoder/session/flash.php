<?php

/**
 * <Encoder Framework>
 * A classe {Flash} tem como objetivo desempenhar funcionaliades voltadas as
 * mensagens da sessão do usuário, mensagens flash.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Flash extends Object {

    /**
     * Todas as mensagens flash irão possuir um escopo, ou seja, um índice na 
     * váriavel global de sessão. Possibilitando o agrupamento de mensagens por 
     * classe.
     * 
     * @var string
     */
    private static $defaultScope = 'no_scope';

    /**
     * Método {Setter} e {Getter} genérico para o atributo {$defaultScope}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, vai apenas retornar.
     * 
     * @return string $set
     */
    public static function defaultScope($set = null) {
        if (empty($set))
            return self::$defaultScope;

        return self::$defaultScope = $set;
    }

    /**
     * Define uma mensagem flash na sessão do usuário atual.
     * 
     * @param string $message Mensagem que será apresentada ao usuário.
     * @param string $element Nome da visão que será utilizada para renderizar a mensagem.
     * @param string $escope
     * @return void
     */
    public static function set($message, $element = 'default', $scope = null) {
        # Capturando todas as mensagens flash definidas na sessão, caso 
        # não exista nenhuma, convertemos para array o retorno da sessão.
        $flashs = Session::get('flash') ? : array();

        # Definindo escopo da mensagem;
        $scope = $scope ? : self::$defaultScope;

        # Dentro do escopo :flash, criamos o escopo do paramêtro $scope e inserimos a 
        # msg dentro deste. Caso já exista o escopo, será apenas inserido a msg.
        $flashs[$scope][$element][] = $message;

        # Salvamos os novos valores do índice :flash na sessão.
        return Session::set('flash', $flashs);
    }

    /**
     * Obtém uma mensagem flash definida anteriormente. Será rederizado o 
     * elemento de visão corresponde a flash definida.
     * 
     * @param string $scope Escopo das mensagens que deseja renderizar.
     * @return string
     */
    public static function get($scope = null) {
        # definindo escopo da mensagem;
        $scope = $scope ? : self::$defaultScope;

        # Capturamos as mensagens salvas na sessão, caso existão.
        if ($flashs = Session::get('flash', true)) {
            foreach ($flashs[$scope] as $element => $msgs) {
                foreach ($msgs as $msg) {
                    echo View::element('flashs/' . $element, array(
                        'message' => $msg
                    ), 'flash');
                }
            }
        }
    }

}
