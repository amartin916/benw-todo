<?php
namespace App;

class Controller{
  function __construct(){ }

  public function getOne($request, $id){
    $_SESSION['test'] = $id;
    echo "getting one $id";
  }
  public function getAll($request){
    echo "getting all".$_SESSION['test'];
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