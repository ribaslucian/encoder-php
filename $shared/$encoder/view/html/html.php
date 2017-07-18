<?php

class Html {

    public static function javascripts($files = array()) {

        # se estiver vazia vamos renderizar todos os includes do application.css
        if (empty($files))
            return self::includesByApplication('javascript');

        # se for string é a inserção apenas de um arquivo
        if (is_string($files))
            return self::assetsInclude($files, 'javascript');

        $html = '';
        # inserindo um array de arquivos
        if (is_array($files))
            foreach ($files as $file)
                $html .= self::assetsInclude($file, 'javascript');

        return $html;
    }

    public static function stylesheets($files = array()) {

        # se estiver vazia vamos renderizar todos os includes do application.css
        if (empty($files))
            return self::includesByApplication('stylesheet');
        
        # se for string é a inserção apenas de um arquivo
        if (is_string($files))
            return self::assetsInclude($files, 'stylesheet');

        $html = '';
        # inserindo um array de arquivos
        if (is_array($files))
            foreach ($files as $file) {
                $html .= self::assetsInclude($file, 'stylesheet');
            }

        return $html;
    }

    #
    ##
    ###
    # PRIVATE #

    private static function includesByApplication($type = 'javascript') {
        $extension = $type == 'javascript' ? 'js' : 'css';
        
        if (!$file = @file_get_contents(($type == 'javascript' ? JAVASCRIPTS : STYLESHEETS) . 'application.' . $extension))
            return null;

        preg_match_all('/include: (.*?)\ /s', $file, $files);

        if (empty($files[0]))
            return self::assetsInclude('application', $type);

        $html = '';
        foreach ($files[0] as $file) {
            $file = trim(str_replace(array('include:', ''), '', $file));
            $html .= self::assetsInclude($file, $type);
        }
        
        $html .= self::assetsInclude('application', $type);

        return $html;
    }

    private static function assetsInclude($file, $type = 'javascript') {
        $extension = $type == 'javascript' ? 'js' : 'css';
        $type = $extension == 'js' ? JAVASCRIPTS : STYLESHEETS;

        # definindo diretório absoluto do .CSS; substituímos as barras do 
        # diretório relativo do arquivo para as barras corretas do S.O.
        $file_path = $type . str_replace(array('\\', '/'), I, $file) . '.' . $extension;

        if (file_exists($file_path)) {
            $stylesheet_encoder_path = '..' . I . '..' . I . str_replace(ROOT, '', ENCODER_LAYOUTS) . ($extension == 'css' ? 'stylesheet' : 'javascript');
            return view($stylesheet_encoder_path, array('file' => $file));
        }

        return '';
    }

}
