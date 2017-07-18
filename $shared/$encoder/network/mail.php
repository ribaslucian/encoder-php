<?php

/**
 * <Encoder Framework>
 * A classe {Mail} tem como objetivo fornecer os recursos para gerenciamento 
 * de configuração para envio de email atravéz da aplicação.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Mail extends Object {

    /**
     * Host do servidor de email.
     * 
     * @var string
     */
    private static $host;

    /**
     * Nome de usuário/email do usuário que será o remetende dos emails.
     *
     * @var string
     */
    private static $username;

    /**
     * Senha da conta do usuário remetente dos emails.
     *
     * @var string
     */
    private static $password;

    /**
     * Nome do usuário remetente dos emails.
     *
     * @var string
     */
    private static $name;

    /**
     * Recurso/classe terceira responsável pelo envio de e-mails.
     *
     * @var string
     */
    private static $mail;

    /**
     * @staticConstruct
     */
    public static function init($data = array()) {
        self::mailler();
    }

    /**
     * Método {Getter} e {Setter} do atributo {host}.
     * 
     * @param string $set
     */
    public static function host($set = null) {
        if (empty($set))
            return self::$host;

        return self::$host = $set;
    }

    /**
     * Método {Getter} e {Setter} do atributo {username}.
     * 
     * @param string $set
     */
    public static function username($set = null) {
        if (empty($set))
            return self::$username;

        return self::$username = $set;
    }

    /**
     * Método {Getter} e {Setter} do atributo {password}.
     * 
     * @param string $set
     */
    public static function password($set = null) {
        if (empty($set))
            return self::$password;

        return self::$password = $set;
    }

    /**
     * Método {Getter} e {Setter} do atributo {name}.
     * 
     * @param string $set
     */
    public static function name($set = null) {
        if (empty($set))
            return self::$name;

        return self::$name = $set;
    }

    /**
     * Método {Setter} do atributo {mail}.
     * 
     * @return Mailer
     * @return void
     */
    private static function mailler() {
        if (!empty(self::$mail))
            return self::$mail;

        self::$mail = new PHPMailer();
        self::$mail->isHTML(true);
        self::$mail->CharSet = 'UTF-8';
        self::$mail->Port = 587;

        self::$mail->isSMTP();
        self::$mail->SMTPDebug = 0;
        self::$mail->SMTPAuth = true;
        # self::$mail->SMTPSecure = 'tls';
        self::$mail->Host = self::$host;
        self::$mail->Username = self::$username;
        self::$mail->Password = self::$password;
        self::$mail->From = self::$username;
        self::$mail->FromName = self::$name;
        ## message
        # self::$mail->Subject;
        # self::$mail->body;
        ## send
        # self::$mail->addAddress($to, 'Liv Web Contato');
        # return self::$mail->send();
    }

    /**
     * Método responsável pelo envio de emails.
     * 
     * @param string $to Destinatário do email
     * @param string $subject Assundo do email
     * @param string $message Mensagem do email
     * 
     * @return boolean Email enviado ou não
     */
    public static function send($to, $subject, $message) {
        self::$mail->addAddress($to, static::$name);
        self::$mail->Subject = $subject;
        self::$mail->Body = $message;
        return self::$mail->send();
    }

    /**
     * Método responsável pelo envio de emails a partir de uma view da aplicação.
     * 
     * @param string $to Destinatário do email
     * @param string $subject Assundo do email
     * @param string $view Visão que será utilizada para o contéudo do email
     * @param string $data Dados que serão passados para a View
     * 
     * @return boolean Email enviado ou não
     */
    public static function byView($to, $subject, $view, $data = array()) {
        return Mail::send($to, $subject, View::get($view, $data, 'mail'));
    }

}
