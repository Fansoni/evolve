<?php

class Unidade extends Exec {

    public function __construct($params = "") {
        parent::__construct(strtolower(get_class()), $params);
    }
    
}
