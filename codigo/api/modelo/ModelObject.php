<?php
abstract class ModelObject{
    abstract static  public function fromJson($json):ModelObject;
    abstract public function toJson():String;
}