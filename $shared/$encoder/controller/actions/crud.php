<?php

namespace actions;

trait Crud {

    use Paginate,
        Add,
        Edit,
        Remove,
        GroupRemove;
}
