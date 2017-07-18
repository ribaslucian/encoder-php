<?php

/**
 * Arquivo de funções básicas do <Encoder>.
 * Muitas funções são apenas um nome mais elegante para a referência de um
 * método a partir de sua classe.
 *
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

/**
 * Função básica para efetuar a auto inclusão de arquivos e classes.
 *
 * @param string $name Nome da classe que será auto-incluída.
 */
function encoder_autoload($name) {
    # echo $name . '<br/>';
    # verificamos se o arquivo existe
    if (!$class = dir_class_application($name))
        throw new MissingClass('Class Name Not Found: "' . $name . '"');

    # incluímos a classe.
    include $class;

    # referenciamos o método @onInclude caso possua.
    if (method_exists($name, $onInclude = object_method_on_include()))
        $name::$onInclude();
}

/**
 * Ao lançar uma execeção, será renderizado uma visão personalizada definido
 * pela sua própria classe controladora de execeções.
 *
 * @param Exception $exception Execeção a ser apresentada.
 */
function encoder_exception($exception) {
    EncoderException::render($exception);
}

/* array */ {

    function array_required_index($array, $indexes) {
        return Vetor::requireIndex($array, $indexes);
    }

    function required_index($array, $indexes) {
        return Vetor::requireIndex($array, $indexes);
    }

    function pr($array) {
        return Vetor::show($array);
    }

    function p($var) {
        return pr($var);
    }

    function str_to_array($string, $explode = ',') {
        return Vetor::byStrSlim($string, $explode);
    }

    /**
     * Captura todos os últimos galhos de um Array
     * independente de quantos sub-galhos o mesmo tenha.
     *
     * @param array $array que será capturado os últimos galhos
     * @param array $match recipiente para os últimos galhos
     * @param int $cb número do galho atual
     */
    function array_last_branches(array $array, &$match, $cb = 0) {
        foreach ($array as $key => $value)
            is_array($value) ? array_last_branches($value, $match, $cb++) : $match[$cb][] = $value;
    }

    /**
     * Captura todos os últimos galhos de um Array
     * independente de quantos sub-galhos o mesmo tenha.
     *
     * @param array $array que será capturado os últimos galhos
     * @param array $match recipiente para os últimos galhos
     * @param int $cb número do galho atual
     */
    function array_last_branches_separated(array $array, &$match, $cb = 0) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                array_last_branches($value, $match, $cb++);
            } else {
                $match[$cb][] = $value;
            }
        }
    }

    function array_max_branches(array $array) {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = array_max_branches($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }

}

/** Lib */ {


    /**
     * Die.
     *
     * @param type $var
     */
    function d($var = null) {
        die($var);
    }

    /**
     * Printa um array através da função pr() e interrompe o ponteiro de
     * interpretação do código.
     *
     * @param array $var
     */
    function dp($var) {
        die(pr($var));
    }

    /**
     * Die Dump
     * @param type $var
     */
    function dd($var) {
        var_dump($var);

        die;
    }

    /**
     * Verifica se existe uma sub string.
     */
    function has_string_on_text($sub, $text) {
        preg_match("/$sub/", $text, $matches, PREG_OFFSET_CAPTURE);
        return !empty($matches);
    }

}

/** Encoder */ {

    function encoder_timer() {
        return Encoder::timer();
    }

    function encoder_controller($set = null) {
        return Encoder::controller($set);
    }

    function encoder_model($set = null) {
        return Encoder::model($set);
    }

    function encoder_is_controller($className) {
        return Encoder::isController($className);
    }

    function encoder_is_model($className) {
        return Encoder::isModel($className);
    }

    function encoder_init_class($className) {
        return Encoder::initClass($className);
    }

    function globals($name = null, $value = null) {
        return Encoder::globals($name, $value);
    }

}

/** Object */ {

    function object_method_on_include($set = null) {
        return Object::methodOnInclude($set);
    }

    function object_method_construct_static($set = null) {
        return Object::methodConstructStatic($set);
    }

    function object_method_after_instantiation($set = null) {
        return Object::methodAfterInstantiation($set);
    }

}

/** Cache */ {

    function cache($key, $value = null) {
        return Cache::_cache($key, $value);
    }

    function cache_folder($set = null) {
        return Cache::folder($set);
    }

    function cache_time($set = null) {
        return Cache::time($set);
    }

    function cache_reload() {
        return Cache::reload();
    }

}

/** Dir */ {

    function dir_classes_application() {
        return Dir::applicationClasses();
    }

    function dir_class_application($class_name = null) {
        return Dir::classDir($class_name);
    }

}

/** Security */ {

    function security_salt($set = null) {
        return Security::salt($set);
    }

    function security_random($length = 32) {
        return Security::random($length);
    }

    function security_encrypt_pass($data, $pass = null) {
        return Security::encryptPass($data, $pass);
    }

    function security_decrypt_pass($encrypted, $pass = null) {
        return Security::dencryptPass($encrypted, $pass);
    }

}

/** Format */ {

    function format_megabytes($bytes) {
        return Format::megabytes($bytes);
    }

    function format_money($float) {
        return Format::money($float);
    }

    function format_money_to_float($money) {
        return Format::moneyToFloat($money);
    }

    function format_limit_str($string, $max_chars = 16, $complete_with = '...') {
        return Format::limitStr($string, $max_chars, $complete_with);
    }

    function compress($string) {
        return Format::compress($string);
    }

    function json($value) {
        return Format::json($value);
    }

}

/** Date */ {

    function date_is($date, $format = 'Y-m-d H:i') {
        return Date::is($date, $format);
    }

    function date_is_hour($hour) {
        return Date::isHour($hour);
    }

    function date_compare($date01, $date02, $format01 = 'Y-m-d H:i', $format02 = 'Y-m-d H:i') {
        return Date::compare($date01, $date02, $format01, $format02);
    }

    function date_days_difference($date01, $date02, $format01 = 'Y-m-d H:i', $format02 = 'Y-m-d H:i') {
        return Date::daysDifference($date01, $date02, $format01, $format02);
    }

    function date_formated($date, $format = 'd/m/Y H:i', $format_to = 'Y-m-d H:i') {
        return Date::format($date, $format, $format_to);
    }

    function date_is_past($date, $format = 'd/m/Y H:i') {
        return Date::isPast($date, $format);
    }

    function date_is_now($hour, $format = 'Y-m-d H:i') {
        return Date::isNow($date, $format);
    }

    function date_is_future($date, $format = 'd/m/Y H:i') {
        return Date::isFuture($date, $format);
    }

    function date_middle($date01, $date02, $format01 = 'Y-m-d H:i', $format02 = 'Y-m-d H:i') {
        return Date::middle($date01, $date02, $format01, $format02);
    }

}

/** Url */ {

    function url_protocol() {
        return Url::protocol();
    }

    function url_host() {
        return Url::host();
    }

    function url_current() {
        return Url::current();
    }

    function url_application() {
        return Url::application();
    }

    function redirect($link) {
        return Url::go($link);
    }

}

/** Route */ {

    function route_current() {
        return Route::current();
    }

    function route_controller($set = null) {
        return Route::controller($set);
    }

    function route_action($set = null) {
        return Route::action($set);
    }

    function route_defined($route = null) {
        return Route::defined($route);
    }

    function route_is($tell_me_why = true) {
        return Route::isValid($tell_me_why);
    }

    function route_call() {
        return Route::call();
    }

    function route_add($route, $locale) {
        Route::add($route, $locale);
    }

}

/** Mail */ {

    function mail_host($set = null) {
        return Mail::host($set);
    }

    function mail_name($set = null) {
        return Mail::name($set);
    }

    function mail_password($set = null) {
        return Mail::password($set);
    }

    function mail_username($set = null) {
        return Mail::username($set);
    }

}

/** Log */ {

    function log_path($set = null) {
        return Log::path($set);
    }

    function log_line_end($set = null) {
        return Log::lineEnd($set);
    }

    function log_write($name, $content) {
        return Log::write($name, $content);
    }

}

/** Connection */ {

    function connections($connections) {
        return Connection::connections($connections);
    }

}

/** Auth */ {

    function auth_request() {
        return Auth::request();
    }

    function login($username, $password) {
        return Auth::login($username, $password);
    }

    function hierarchy() {
        return Auth::hierarchy();
    }

    function logout() {
        return Auth::logout();
    }

    function confirm_account($hash) {
        return Auth::confirmAccount($hash);
    }

    function unlock_account($hash) {
        return Auth::unlockAccount($hash);
    }

    function auth_model() {
        return Auth::model();
    }

    function auth_encrypt($password) {
        return Auth::passwordEncrypt($password);
    }

    function csfr_validation($csfr = null) {
        return Request::csfrValid($csfr);
    }

    function user($key = null) {
        return Auth::field($key);
    }

}

/** Flash */ {

    function flash($message, $element = 'success', $scope = null) {
        return Flash::set($message, 'toastr/' . $element, $scope);
    }

    function flash_i($message, $escope = null) {
        return flash($message, 'info', $escope);
    }

    function flash_w($message, $escope = null) {
        return flash($message, 'warning', $escope);
    }

    function flash_e($message, $escope = null) {
        return flash($message, 'error', $escope);
    }

    function flashes($scope = null) {
        return Flash::get($scope);
    }

}

/** Controllers */ {

    function set($var, $value) {
        $controller = route_controller();
        View::setVar($controller::view(route_action()), $var, $value);
    }

    function go($route = '/') {
        Route::redirect($route);
    }

}

/** Views */ {

    function partial($view, $vars = array(), $layout = null) {
        return View::partial($view, $vars, $layout);
    }

    function element($view, $vars = array(), $layout = null) {
        return View::element($view, $vars, $layout);
    }

    function assets() {
        return element('page/assets');
    }

    function loader() {
        return element('page/load');
    }

    function timer() {
        return element('page/timer');
    }

    function view($view, $vars = array(), $layout = null) {
        return View::get($view, $vars, $layout);
    }

    function render($view, $layout = null, $vars = array()) {
        View::render($view, $layout, $vars);
    }

    function page($view, $layout = null, $vars = array()) {
        return element('page' . I . $view, $vars, $layout);
    }

    function menu($view = null, $layout = null, $vars = array()) {
        $view = $view ? : hierarchy();
        return element('menus' . I . $view, $vars, $layout);
    }

    function menu_color() {
        if ($colors = globals('color'))
            return $colors;

        $colors = array(
            'green darken-3', 'cyan darken-3', 'blue darken-3',
            'indigo darken-4', 'red darken-4', 'pink darken-3',
            'purple darken-4', 'deep-orange darken-4', 'brown',
        );

        return globals('color', $colors[rand(0, count($colors) - 1)]);
    }

    function menu_active($action, $class = 'active') {
        return route_action() == $action ? $class : '';
    }

    function menu_url($action, $default = '#') {
        return route_action() != $action ? url_action($action) : $default;
    }

    function table($records) {
        return partial('table', array('entities' => $records));
    }

}

/** Show */ {

    function show_id($id) {
        return Show::id($id);
    }

    function show_name($full_name) {
        return Show::name($full_name);
    }

    function show_first_name($full_name) {
        return Show::firstName($full_name);
    }

    function show_email($email) {
        return Show::email($email);
    }

    function show_status($status) {
        return Show::status($status);
    }

    function show_date_hour($date) {
        return Show::dateHour($date);
    }

}

/** Html */ {

    function stylesheets($files = array()) {
        return Html::stylesheets($files);
    }

    function javascripts($files = array()) {
        return Html::javascripts($files);
    }

}

/** Inflector */ {

    function singularize($str) {
        return Inflector::singularize($str);
    }

    function pluralize($str) {
        return Inflector::pluralize($str);
    }

    function delimit($str, $delimiter = '_') {
        return Inflector::delimit($str, $delimiter);
    }

}

/** Request */ {

    function data($key = null, $method = null) {
        return Request::param($key, $method);
    }

    function is_post() {
        return Request::post();
    }

    function is_get() {
        return Request::get();
    }

    function is_ajax() {
        return Request::isAjax();
    }

    function ip() {
        return Request::ip();
    }

    function client_name() {
        return Request::getClientName();
    }

    function get($key = null) {
        return data($key, 'get');
    }

    function post($key) {
        return data($key, 'post');
    }

}

/** Session */ {

    function session_get($key = null, $destroy = false) {
        return Session::get($key, $destroy);
    }

    function request_count() {
        return Session::getRequestCount();
    }

}

/** Paginate */ {

    function paginate_find($entity, $in = array()) {
        return Paginate::find($entity, $in);
    }

    function paginate_page_exists($page = null) {
        return Paginate::pageExists($page);
    }

    function paginate_in() {
        return Paginate::in();
    }

    function paginate_out() {
        return Paginate::out();
    }

    function paginate_method() {
        return Paginate::method();
    }

    function paginate_fields() {
        return Paginate::fields();
    }

    function paginate_limit() {
        return Paginate::limit();
    }

    function paginate_where() {
        return Paginate::where();
    }

    function paginate_order() {
        return Paginate::order();
    }

    function paginate_offset() {
        return Paginate::offset();
    }

    function paginate_page_current() {
        return Paginate::pageCurrent();
    }

    function paginate_page_previous() {
        return Paginate::pagePrevious();
    }

    function paginate_page_forward() {
        return Paginate::pageForward();
    }

    function paginate_pages_count() {
        return Paginate::pagesCount();
    }

    function paginate_record_start() {
        return Paginate::recordStart();
    }

    function paginate_record_end() {
        return Paginate::recordEnd();
    }

    function paginate_records_count() {
        return Paginate::recordsCount();
    }

    function paginate_url_back() {
        return Paginate::urlBack();
    }

    function paginate_url_forward() {
        return Paginate::urlForward();
    }

    function paginate_link_sort($column, $text, $class = '') {
        return Paginate::linkSort($column, $text, $class);
    }

    function paginate_line_number() {
        return Paginate::lineNumber();
    }

    function responser_paginate_link_sort($column, $text) {
        return Paginate::responserLinkSort($column, $text);
    }

}

/** Go funcions */ {

    function go_auth($route = '') {
        return Auth::redirect($route);
    }

    function go_action($action = '') {
        $controller = route_controller();
        Route::redirect($controller::route($action));
    }

    function go_paginate() {
        go_action('paginate');
    }

    function allow_if_my_area() {
        return Auth::allowIfMyArea();
    }

}

/** Route genarate funcions */ {

    function url($route = '') {
        return Route::url($route);
    }

    function url_auth($controller = '') {
        return Auth::url($controller);
    }

    function url_action($action = '') {
        $c = route_controller();
        return url($c::route($action));
    }

    function url_add() {
        return url_action('add');
    }

    function url_paginate() {
        return url_action('paginate');
    }

}

/** Dir */ {

    function has_class($name) {
        return Dir::hasClass($name);
    }

}

/** encoder\Model */ {

    function h($model) {
        return $model->html();
    }

    function model_request($entity, $method = 'post') {
        return $entity::request($method);
    }

    function query($sql, $connection = 'default') {
        return Db::query($sql, $connection);
    }

    function tables($connection = 'default') {
        encoder\Model::connection($connection);
        return encoder\Model::tables();
    }

}

/** Form */ {

    function submit($text = null, $class = '') {
        return element('form/submit', array(
            'text' => $text,
            'class' => $class,
        ));
    }

    function submit_icon($icon, $text, $class = 'light-blue darken-2') {
        return Form::submitIcon($icon, $text, $class);
    }

    function form_open($options = array()) {
        return Form::open($options);
    }

    function form_close() {
        return Form::close();
    }

    function label($options = array()) {
        return Form::label($options);
    }

    function input($options = array()) {
        return Form::input($options);
    }

    function input_message($options = null, $field = null) {
        return Form::message($options, $field);
    }

    function field_id($options = array()) {
        return Form::fieldId($options);
    }

    function field($options = array(), $label = NULL, $more_options = array()) {
        return Form::field($options, $label, $more_options);
    }

    function field_icon($icon, $options = array(), $label = NULL, $more_options = NULL) {
        $more_options['icon'] = $icon;
        return Form::field($options, $label, $more_options);
    }

    function csfr() {
        return Form::csfr();
    }

    function input_name($entity, $field) {
        return "name='{$entity->html()->name($field)}'";
    }

    function input_id($entity, $field) {
        return 'id="' . $entity->html()->id($field) . '"';
    }

    function label_for($entity, $field) {
        return 'for="' . $entity->html()->id($field) . '"';
    }

}

/** File */ {

    function file_get($path) {
        return file_get_contents($path);
    }

}
