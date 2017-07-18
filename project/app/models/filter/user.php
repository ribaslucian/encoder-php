<?php

namespace filter;

class User extends \Model {

    static $validate = array(
        'email {email} {paginate}' => array(
            'E-mail inválido.'
        )
    );

    public function conditions() {

        ## PRÉ VALIDAÇÕES
        # formatos e preenchimentos
        if (!$this->valid()) {
            flash_e('Verifique os dados do formulário de busca.');
            return null;
        }
        
        return null;

        ## FORMATANDO DADOS

//        $formated = (object) array();
//
//        # valores
//        if (!empty($this->value_min))
//            $formated->value_min = \Format::moneyToFloat($this->value_min);
//
//        if (!empty($this->value_max))
//            $formated->value_max = \Format::moneyToFloat($this->value_max);
//
//        # data de validade
//        if (!empty($this->date_validate_start))
//            $formated->date_validate_start = \Date::format($this->date_validate_start, 'd/m/Y', 'Y-m-d 00:00');
//
//        if (!empty($this->date_validate_end))
//            $formated->date_validate_end = \Date::format($this->date_validate_end, 'd/m/Y', 'Y-m-d 23:59');
//
//        # data de validação
//        if (!empty($this->date_validation_start))
//            $formated->date_validation_start = \Date::format($this->date_validation_start, 'd/m/Y', 'Y-m-d 00:00');
//
//        if (!empty($this->date_validation_end))
//            $formated->date_validation_end = \Date::format($this->date_validation_end, 'd/m/Y', 'Y-m-d 23:59');
//
//        ## VERIFICAÇÃO DE VALORES DINÂMICOS
//        # comparando valores
//        if (!empty($formated->value_min) && !empty($formated->value_max))
//            if ($formated->value_min > $formated->value_max)
//                $this->message('value_max', 'Deve ser igual ou menor que o valor mínimo.');
//
//        # comprando datas de validação
//        if (!empty($formated->date_validate_start) && !empty($formated->date_validate_end))
//            if (\Date::compare($formated->date_validate_start, $formated->date_validate_end) == 1)
//                $this->message('date_validation_end', 'Deve ser igual ou anterior a data inicial.');
//
//        # comprando datas de validação
//        if (!empty($formated->date_validation_start) && !empty($formated->date_validation_end))
//            if (\Date::compare($formated->date_validation_start, $formated->date_validation_end) == 1)
//                $this->message('date_validation_end', 'Deve ser igual ou anterior a data inicial.');
//
//
//        ## PÓS VALIDAÇÕES
//        # formatações e comparações
//        if (!$this->valid()) {
//            flash_e('Verifique os dados do formulário de busca.');
//            return null;
//        }
//
//
//        # após validações com sucesso, criar o SQL
//        $sql = array();
//
//        # ids
//        if (!empty($this->id))
//            $sql[] = "(coupon_id = $this->id)";
//
//        if (!empty($this->id_ns))
//            $sql[] = "(coupon_id_ns ~* '$this->id_ns')";
//
//        # issuer
//        if (!empty($this->issuer))
//            $sql[] = "(issuer_name ~* '$this->issuer')";
//
//        if (!empty($this->issuer_cnpj))
//            $sql[] = "(issuer_cnpj ~* '$this->issuer_cnpj')";
//
//        # valores
//        if (!empty($this->value_min) && !empty($this->value_max)) {
//            $sql[] = "(value <= $formated->value_max AND value >= $formated->value_min)";
//        } else {
//            if (!empty($this->value_min))
//                $sql[] = "(value >= $formated->value_min)";
//
//            if (!empty($this->value_max))
//                $sql[] = "(value <= $formated->value_max)";
//        }
//
//        # data de validade
//        if (!empty($this->date_validate_start) && !empty($this->date_validate_end)) {
//            $sql[] = "(date_validate >= '$formated->date_validate_start' AND date_validate <= '$formated->date_validate_end')";
//        } else {
//            if (!empty($this->date_validate_start))
//                $sql[] = "(date_validate >= '$formated->date_validate_start')";
//
//            if (!empty($this->date_validate_end))
//                $sql[] = "(date_validate <= '$formated->date_validate_end')";
//        }
//
//        # data de validade
//        if (!empty($this->date_validation_start) && !empty($this->date_validation_end)) {
//            $sql[] = "(transaction_date >= '$formated->date_validation_start' AND transaction_date <= '$formated->date_validation_end')";
//        } else {
//            if (!empty($this->date_validation_start))
//                $sql[] = "(transaction_date >= '$formated->date_validation_start')";
//
//            if (!empty($this->date_validation_end))
//                $sql[] = "(transaction_date <= '$formated->date_validation_end')";
//        }
//
//        if (empty($sql))
//            return null;
//
//        return implode(' OR ', $sql);
    }

}
