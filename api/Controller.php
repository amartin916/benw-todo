<?php
namespace App;

use App\DB;

class Controller{

  private $db;

  function __construct(){ 
    $this->db = new DB();
  }

  public function getOne($request, $id){
    $result = $this->db->get($id);
    if(!$result) return ['type'=>'error', 'message'=>'Could not connect to database'];

    return ['type'=>'success', 'data'=>$result];
  }


  public function getAll($request){
    $result = $this->db->getAll();
    if($result === false) return ['type'=>'error', 'message'=>'Could not connect to database'];

    return ['type'=>'success', 'data'=>$result];
  }


  public function createOne($request){
    $result = $this->db->store($request);
    if(!$result) return ['type'=>'error', 'message'=>'Could not connect to database'];

    return ['type'=>'success'];
  }


  public function updateOne($request, $id){
    $result = $this->db->update($id, $request);
    if(!$result) return ['type'=>'error', 'message'=>'Could not connect to database'];

    return ['type'=>'success'];
  }


  public function deleteOne($request, $id){
    $result = $this->db->delete($id);
    if(!$result) return ['type'=>'error', 'message'=>'Could not connect to database'];

    return ['type'=>'success'];
  }
}