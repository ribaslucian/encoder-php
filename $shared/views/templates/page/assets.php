<?php

# inclusão das tags CSS
# A partir do arquivo "assets/stylesheets/application.css" incluímos todos 
# arquivos referenciados por 
# |  include: relative_file_path
# O conteúdo de application.css é requerido após a inclusão destes arquivos.
echo stylesheets();


# inclusão das tags JavaScript
# A partir do arquivo "assets/javascript/application.js" incluímos todos 
# arquivos referenciados por 
# |  include: relative_file_path
# O conteúdo de application.js é requerido após a inclusão destes arquivos.
echo javascripts();
