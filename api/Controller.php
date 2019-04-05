<?php
namespace App;

class Controller{
  function __construct(){ }

  public function getOne($request, $id){
    echo "getting one $id";
  }
  public function getAll($request){
    echo "getting all";
  }
  public function createOne($request){
    echo "createing one";
  }
  public function updateOne($request, $id){
    echo "updating one $id";
  }
  public function deleteOne($request, $id){
    echo "deleteing one $id";
  }
}