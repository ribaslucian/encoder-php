<div class="row">

    <!-- l:desktop m:tablet s:mobile -->
    <div class="col s0 m2 l3">&nbsp;</div>

    <div class="col s12 m8 l6" style="position: relative;">

        <div style="position: absolute; top: 0; right: 0;" class="cursor pointer">
            <div class="text-darken-1 red-text form-search-button-cancel">
                <small>
                    <i class="material-icons">&#xE5CD;</i>

                    <b class="relative" style="top: -8px">
                        Cancelar
                    </b>
                </small>
            </div>
        </div>

        <div>
            Filtrar
        </div>

        <i class="material-icons grey-text">&#xE8B6;</i>
        <small class="grey-text" style="position: relative; top: -8px;">
            Preecha os campos a baixo para filtrar os registros:
        </small>

        <br/>
        <br/>

        <form action="<?php echo url(); ?>" method="get" class="small">
            <div class="row">
                <div class="input-field col s3">
                    <input name="admin\user\Search[name]" type="text" id="name" maxlength="92" autofocus value="<?php echo @$_GET['admin\user\Search']['name']; ?>" />

                    <label for="name">
                        <b>Nome:</b>
                    </label>
                </div>

                <div class="input-field col s3">
                    <input name="admin\user\Search[cpf]" type="text" id="cpf" class="mask cpf" value="<?php echo @$_GET['admin\user\Search']['cpf']; ?>" />

                    <label for="cpf">
                        <b>CPF:</b>
                    </label>
                </div>


                <div class="input-field col s3">
                    <input name="admin\user\Search[email]" type="email" id="email" class="mask email" maxlength="92" value="<?php echo @$_GET['admin\user\Search']['email']; ?>" />

                    <label for="email">
                        <b>Email:</b>
                    </label>
                </div>

                <div class="input-field col s3">
                    <input name="admin\user\Search[phone]" type="text" id="phone" class="mask phone" value="<?php echo @$_GET['admin\user\Search']['phone']; ?>" />

                    <label for="phone">
                        <b>Telefone:</b>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s2">
                    <input name="admin\user\Search[address_state]" type="text" id="address_state" maxlength="92" value="<?php echo @$_GET['admin\user\Search']['address_state']; ?>" />

                    <label for="address_state">
                        <b>Estado:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[address_city]" type="text" id="address_city" maxlength="92" value="<?php echo @$_GET['admin\user\Search']['address_city']; ?>" />

                    <label for="address_city">
                        <b>Cidade:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[address_zipcode]" type="text" id="address_zipcode" class="mask cep" maxlength="92" value="<?php echo @$_GET['admin\user\Search']['address_zipcode']; ?>" />

                    <label for="address_zipcode">
                        <b>CEP:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[address_street]" type="text" id="address_street" maxlength="92" value="<?php echo @$_GET['admin\user\Search']['address_street']; ?>" />

                    <label for="address_street">
                        <b>Rua:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[address_neighborhood]" type="text" id="address_neighborhood" maxlength="92" value="<?php echo @$_GET['admin\user\Search']['address_neighborhood']; ?>" />

                    <label for="address_neighborhood">
                        <b>Bairro:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[address_number]" type="number" id="address_number" class="mask natural number" maxlength="12" value="<?php echo @$_GET['admin\user\Search']['address_number']; ?>" />

                    <label for="address_number">
                        <b>Número:</b>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s2">
                    <input name="admin\user\Search[id]" type="text" id="id" maxlength="64" value="<?php echo @$_GET['admin\user\Search']['id']; ?>" />

                    <label for="id">
                        <b>ID:</b>
                    </label>
                </div>

                <div class="input-field col s3" style="position: relative; margin-top: -0px;">
                    <label for="login_attempts_start" style="margin-top: -5px;">
                        <b><small>Conexões —</small> Tentativas:</b>
                    </label>

                    <div class="row">
                        <div class="input-field col s6">
                            <input name="admin\user\Search[login_attempts_start]" type="text" id="login_attempts_start" class="mask natural number" maxlength="12" placeholder="De:" value="<?php echo @$_GET['admin\user\Search']['login_attempts_start']; ?>" />
                        </div>

                        <div class="input-field col s6">
                            <input name="admin\user\Search[login_attempts_end]" type="text" class="mask natural number" maxlength="12" placeholder="Até:" value="<?php echo @$_GET['admin\user\Search']['login_attempts_end']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="input-field col s3" style="position: relative; margin-top: -0px;">
                    <label for="login_count_start" style="margin-top: -5px;">
                        <b><small>Conexões —</small> Efetuadas:</b>
                    </label>

                    <div class="row">
                        <div class="input-field col s6">
                            <input name="admin\user\Search[login_count_start]" type="text" id="login_count_start" class="mask natural number" maxlength="12" placeholder="De:" value="<?php echo @$_GET['admin\user\Search']['login_count_start']; ?>" />
                        </div>

                        <div class="input-field col s6">
                            <input name="admin\user\Search[login_count_end]" type="text" id="login_count" class="mask natural number" maxlength="12" placeholder="Até:" value="<?php echo @$_GET['admin\user\Search']['login_count_end']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[hierarchy]" type="text" id="hierarchy" maxlength="32" value="<?php echo @$_GET['admin\user\Search']['hierarchy']; ?>" />

                    <label for="hierarchy">
                        <b>Hierarquia:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <select class="browser-default" name="admin\user\Search[status]">
                        <option value="" disabled selected>Status</option>
                        <option value="unactive" <?php echo @$_GET['admin\user\Search']['status'] == 'unactive' ? 'selected' : '' ?> >Desativada</option>
                        <option value="active" <?php echo @$_GET['admin\user\Search']['status'] == 'active' ? 'selected' : '' ?> >Ativada</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s4">
                    <input name="admin\user\Search[hash_confirm_account]" type="text" id="hash_confirm_account" maxlength="64" value="<?php echo @$_GET['admin\user\Search']['hash_confirm_account']; ?>" />

                    <label for="hash_confirm_account">
                        <b><small>Cod. —</small> Conf. de Conta:</b>
                    </label>
                </div>

                <div class="input-field col s4">
                    <input name="admin\user\Search[hash_password_renew]" type="text" id="hash_password_renew" maxlength="64" value="<?php echo @$_GET['admin\user\Search']['hash_password_renew']; ?>" />

                    <label for="hash_password_renew">
                        <b><small>Cod. —</small> Ren. de Senha:</b>
                    </label>
                </div>

                <div class="input-field col s4">
                    <input name="admin\user\Search[hash_unlock_account]" type="text" id="hash_unlock_account" maxlength="64" value="<?php echo @$_GET['admin\user\Search']['hash_unlock_account']; ?>" />

                    <label for="hash_unlock_account">
                        <b><small>Cod. —</small> Desb. de Conta:</b>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s4">
                    <input name="admin\user\Search[created_date_start]" type="text" id="created_date_start" class="mask date" value="<?php echo @$_GET['admin\user\Search']['created_date_start']; ?>" />

                    <label for="created_date_start">
                        <b><small>Data —</small> Inserção Inicial:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[created_date_start_hour]" type="text" id="created_date_start_hour" class="mask hour" value="<?php echo @$_GET['admin\user\Search']['created_date_start_hour'] ? : '00:00'; ?>" />

                    <label for="created_date_start_hour">
                        <b>Hora</b>
                    </label>
                </div>

                <div class="input-field col s4">
                    <input name="admin\user\Search[created_date_end]" type="text" id="created_date_end" class="mask date" value="<?php echo @$_GET['admin\user\Search']['created_date_end']; ?>" />

                    <label for="created_date_end">
                        <b><small>Data —</small> Inserção Final:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[created_date_end_hour]" type="text" id="created_date_end_hour" class="mask hour" value="<?php echo @$_GET['admin\user\Search']['created_date_end_hour'] ? : '23:59'; ?>" />

                    <label for="created_date_end_hour">
                        <b>Hora</b>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s4">
                    <input name="admin\user\Search[updated_date_start]" type="text" id="updated_date_start" class="mask date" value="<?php echo @$_GET['admin\user\Search']['updated_date_start']; ?>" />

                    <label for="updated_date_start">
                        <b><small>Data —</small> Edição Inicial:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[updated_date_start_hour]" type="text" id="updated_date_start_hour" class="mask hour" value="<?php echo @$_GET['admin\user\Search']['updated_date_start_hour'] ? : '00:00'; ?>" />

                    <label for="updated_date_start_hour">
                        <b>Hora</b>
                    </label>
                </div>

                <div class="input-field col s4">
                    <input name="admin\user\Search[updated_date_end]" type="text" id="updated_date_end" class="mask date" value="<?php echo @$_GET['admin\user\Search']['updated_date_end']; ?>" />

                    <label for="updated_date_end">
                        <b><small>Data —</small> Edição Final:</b>
                    </label>
                </div>

                <div class="input-field col s2">
                    <input name="admin\user\Search[updated_date_end_hour]" type="text" id="updated_date_end_hour" class="mask hour" value="<?php echo @$_GET['admin\user\Search']['updated_date_end_hour'] ? : '23:59'; ?>" />

                    <label for="updated_date_end_hour">
                        <b>Hora</b>
                    </label>
                </div>
            </div>

            <br/>
            <?php echo submit_icon('&#xE8B6;', 'Buscar'); ?>
        </form>
    </div>
</div>

<br/>