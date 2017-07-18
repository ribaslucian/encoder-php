<?php

/**
 * <Encoder Framework>
 * A classe {App} tem como objetivo desempenhar as funcionalidades referentes
 * a interações temporais, como verifição de datas, comparação, cálculos, 
 * nomeações.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Date {

    /**
     * Verifica se uma data é válida.
     * 
     * @param string $date Data que deseja verificar.
     * @param string $format Formato da data que deseja verificar.
     * 
     * @return boolean
     */
    public static function is($date, $format = 'Y-m-d H:i') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Compara duas datas, informado se são iguais ou qual é superior ou 
     * inferior à outra, em questões temporais.
     * 
     * @param string $date01 Primeira data da comparação.
     * @param string $date02 Segunda data comparação
     * @param string $format01 Formato da primeira data
     * @param string $format02 Formato da segunda data
     * 
     * @return int 0 As datas são iguas
     * @return int 1 Primeira data é maior que a segunda
     * @return int 2 Segunda data é maior que a primeira
     * @return null Data(s) inválidas
     */
    public static function compare($date01, $date02, $format01 = 'Y-m-d H:i', $format02 = 'Y-m-d H:i') {
        $date01 = DateTime::createFromFormat($format01, $date01);
        $date02 = DateTime::createFromFormat($format02, $date02);

        if ($date02 > $date01)
            return 2;

        if ($date01 == $date02)
            return 0;

        if ($date01 > $date02)
            return 1;

        return null;
    }

    /**
     * Verifica se uma data representa o momento no passado.
     * 
     * @param string $date Data que deseja verifica
     * @param string $format Formato da data que deseja verificar.
     * 
     * @return boolean
     */
    public static function isPast($date, $format = 'Y-m-d H:i') {
        return self::compare($date, date($format), $format, $format) == 2;
    }

    /**
     * Verifica se uma data representa o momento atual.
     * 
     * @param string $date Data que deseja verifica
     * @param string $format Formato da data que deseja verificar.
     * 
     * @return boolean
     */
    public static function isNow($date, $format = 'Y-m-d H:i') {
        return self::compare($date, date($format), $format, $format) == 0;
    }

    /**
     * Verifica se uma data representa o momento no futuro.
     * 
     * @param string $date Data que deseja verifica
     * @param string $format Formato da data que deseja verificar.
     * 
     * @return boolean
     */
    public static function isFuture($date, $format = 'Y-m-d H:i') {
        return self::compare($date, date($format), $format, $format) == 1;
    }

    /**
     * Verifica se um valor representa uma hora válida.
     * Baseando-se no formato 'H:i'.
     * 
     * @param string $hour Hora que deseja verificar 
     * @return boolean
     */
    public static function isHour($hour) {
        $hour = explode(':', $hour);

        if (!array_key_exists(0, $hour) || !is_numeric($hour[0]) || $hour[0] < 0 || $hour[0] > 23)
            return false;

        if (!array_key_exists(1, $hour) || !is_numeric($hour[1]) || $hour[1] < 0 || $hour[1] > 59)
            return false;

        return true;
    }

    /**
     * Formata uma data.
     * 
     * @param string $date Data que deseja formatar
     * @param string $format Formato de entrada da data
     * @param string $format_to Formato de saída da data
     * 
     * @return false Datas inválidas
     * @return string Data formatada
     */
    public static function format($date, $format = 'd/m/Y H:i', $format_to = 'Y-m-d H:i') {
        if (!$date = \DateTime::createFromFormat($format, $date))
            return FALSE;

        return date_format($date, $format_to);
    }

    /**
     * Obtém a diferença entre duas datas convertida em quantidade de dias.
     * 
     * @param string $date01 Primeira data
     * @param string $date02 Segunda data
     * @param string $format01 Formato da primeira data
     * @param string $format02 Formato da segunda data
     * 
     * @return int Quantidade de dias
     */
    public static function daysDifference($date01, $date02, $format01 = 'Y-m-d H:i', $format02 = 'Y-m-d H:i') {
        $date01 = (array) \DateTime::createFromFormat($format01, $date01);
        $date02 = (array) \DateTime::createFromFormat($format02, $date02);

        // difference in seconds
        $date01 = strtotime($date02['date']) - strtotime($date01['date']);

        // Calcula a diferença de dias
        return (int) floor($date01 / (60 * 60 * 24)); // 225 dias
    }

    /**
     * Obtém a data centra de duas datas.
     * 
     * @param string $date01 Primeira data
     * @param string $date02 Segunda data
     * @param string $format01 Formato da primeira data
     * @param string $format02 Formato da segunda data
     * 
     * @return string Data central
     */
    public static function middle($date01, $date02, $format01 = 'Y-m-d H:i', $format02 = 'Y-m-d H:i') {

        # obtemos o timestamp da data01
        $date01str = (array) \DateTime::createFromFormat($format01, $date01);
        $date01str = strtotime($date01str['date']);

        # obtemos a diferença das datas em dias
        $daysDiff = static::daysDifference($date01, $date02, $format01, $format02);

        # verificamos se existe uma data no intervalo central das duas, caso contrário retornamos a date01
        if ($daysDiff <= 1)
            return $date01;

        $daysDiff = floor($daysDiff / 2);

        return date($format01, strtotime('+' . $daysDiff . ' days', $date01str));
    }

}
