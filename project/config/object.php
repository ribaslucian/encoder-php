<?php

/**
 * @config Object
 */

# definindo nome do método que representa o evento @onInclude.
object_method_on_include('inclusion');

# definindo nome do método que representa o construtor estático.
object_method_construct_static('init');

# definindo nome do método que representa o construtor não estático.
object_method_after_instantiation('instantiation');

