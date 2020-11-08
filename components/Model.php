<?php

abstract class Model{
    abstract protected function init();
    abstract protected function validate($object);
}

?>