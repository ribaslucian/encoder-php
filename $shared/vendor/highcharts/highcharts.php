<?php

/**
 * Gerador de gráficos para a biblioteca javascript Highcharts.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
class Highcharts {

    /**
     * Converte os dados para ser apresentado em um histograma.
     * 
     * @param array $values
     * @return json
     */
    public static function histogram(array $values, $sufix_category = null) {
        $graph = array(
            'categories' => array(/* eixo X */),
            'series' => array(/* funcao */),
        );

        foreach ($values as $value) {
            $fields = array_keys($value = (array) $value);

            $graph['categories'][] = ($value[$fields[0]] ?: 'outros(as)') . $sufix_category;
            $graph['series'][] = floatval($value[$fields[1]]);
        }

        return json($graph);
    }

    /**
     * Converte os dados para ser apresentado em um gráfico de colunas.
     * 
     * @param array $values
     * @return json
     */
    public static function columns(array $values) {
        $graph = array(/* array( categories / labels => serie / funcao ) */);

        foreach ($values as $value) {
            $fields = array_keys($value = (array) $value);
            $graph[] = array($value[$fields[0]], intval($value[$fields[1]]));
        }

        return str_replace(array('{', '}'), array('[', ']'), json_encode($graph));
    }

}
