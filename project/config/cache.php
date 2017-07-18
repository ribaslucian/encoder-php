<?php

/**
 * @config Cache
 */

# definindo diretório onde será armazenado os arquivos cacheados.
cache_folder(DATA . 'cache' . I);

# deletamos todas as caches salvas
# cache_reload();

# definindo o tempo de recacheamento das informações.
cache_time('1440 minutes');
