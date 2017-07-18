<?php

/**
 * <Encoder Framework>
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 * 
 * @exception
 */
class EncoderException extends Exception {

    /**
     * 
     * @param Exception $exception Exceção a ser renderizada.
     */
    public static function render($exception) {
        ob_end_clean(); # end buffer

        echo View::element('exceptions/default', array(
            'exception' => $exception
        ), 'exception');
    }

}
