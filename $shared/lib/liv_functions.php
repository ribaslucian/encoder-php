<?php

function user_benefits() {
    $alias = array();

    foreach (explode(',', user()->benefits_id) as $benefit_id)
        $alias[] = Benefit::first(array(
                    'fields' => 'benefit',
                    'where' => "id = $benefit_id"
                ))->benefit;

    return $alias;
}

function user_benefits_id() {
    $ids = array();

    foreach (explode(',', user()->benefits_id) as $benefit_id)
        $ids[] = strtolower(Inflector::slug($benefit_id));

    return $ids;
}
