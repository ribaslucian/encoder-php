<?php
$url_back = paginate_url_back();
$url_forward = paginate_url_forward();

$back_message = $url_back ? "Retornar para pág. " . paginate_page_previous() : 'Não há página anterior.';
$forward_message = $url_forward ? "Ir para pág. " . paginate_page_forward() : 'Não há página posterior.';
?>

<!-- l:desktop m:tablet s:mobile-->

<div class="row encoder_paginate" current="<?php echo paginate_page_current(); ?>" total="<?php echo paginate_pages_count(); ?>">

    <div class="col l3 m6 s8 offset-l9 offset-m6 offset-s3">
        <div class="row">
            <a href="<?php echo $url_back ? : '#'; ?>" class="input-field col s2">
                <i class="material-icons tooltipped grey-text <?php echo $url_back ? 'text-darken-2' : 'text-lighten-2 disabled' ?>" data-position="top" data-delay="50" data-tooltip="<?php echo $back_message; ?>">&#xE5C4;</i>
            </a>

            <div class="input-field col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Digite a pág. que deseja acessar e pressione <enter>">
                <input id="paginate_page" type="text" style="text-align: center;" value="<?php echo paginate_page_current(); ?>" class="mask natural number" />

                <label for="paginate_page">Página</label>

                <small class="red-text relative message_current_page animated bounceIn" style="top: -10px; display: none; font-size: 70%;">
                    <br/>
                    <i class="material-icons" style="font-size: 16px; margin-right: 3px;">error</i>
                    <span class="relative bold" style="top: -4px;">
                        Esta é a página atual
                    </span>
                </small>

                <small class="red-text relative message_page_not_found animated bounceIn" style="top: -10px; display: none; font-size: 70%;">
                    <br/>
                    <i class="material-icons" style="font-size: 16px; margin-right: 3px;">error</i>
                    <span class="relative bold" style="top: -4px;">
                        Esta página não existe
                    </span>
                </small>
            </div>

            <a href="<?php echo $url_forward ? : '#'; ?>" class="input-field col s2">
                <i class="material-icons grey-text tooltipped <?php echo $url_forward ? 'text-darken-2' : 'text-lighten-2 disabled' ?>" data-position="left" data-delay="50" data-tooltip="<?php echo $forward_message; ?>">&#xE5C8;</i>
            </a>
        </div>

        <div class="center-align relative" style="top: -30px;">
            <small class="grey-text small-text-6 bold">
                Pág. 
                <b class="black-text"><?php echo paginate_page_current(); ?></b> 
                de 
                <b class="black-text"><?php echo paginate_pages_count(); ?></b> 
                | 
                <b class="black-text"><?php echo paginate_records_count(); ?></b>
                Registros
            </small>
        </div>
    </div>
</div>