<?php
namespace App;

//Super Fake Database Class
class DB {

  private $table = 'todo';
  private $primaryKey = 'id';
  private $createFields = [
    'text'      => '',
    'created'   => 'timestamp',
    'completed' => ''
  ];
  private $updateRules = [
    'text'      => '',
    'completed' => 'timestamp'
  ];

  function __construct(){
    //start with one entry
    if(!isset($_SESSION[$this->table])) 
      $_SESSION[$this->table] = [ [
        'id'        => 0,
        'text'      => 'Get ye flask',
        'created'   => date('U'),
        'completed' => NULL
      ] ];
  }

  public function get($id){
    if(isset($_SESSION[$this->table][$id])) return $_SESSION[$this->table][$id];
    return false;
  }

  public function getAll(){
    if(!count($_SESSION[$this->table])) return [];
    return array_values($_SESSION[$this->table]);
  }

  public function store($params){
    if(isset($_SESSION[$this->table])) $new_id = 1 + max(array_keys($_SESSION[$this->table]));
    else $new_id = 1;
    
    foreach($this->createFields as $key=>$default){
      $fields[$key] = isset($params[$key]) ? $params[$key] : $this->mapDefaults($this->createFields, $key);
    }
    $fields[$this->primaryKey] = $new_id;

    $_SESSION[$this->table][$new_id] = $fields;
    return true;
  }

  public function update($id, $params){
    $old = $this->get($id);
    if(!$old) return false;

    foreach($this->updateRules as $key=>$default){
      if(isset($params[$key]))
        $old[$key] = $this->mapDefaults($this->updateRules, $key) ?: $params[$key];
    }

    $_SESSION[$this->table][$id] = $old;
    return true;
  }

  public function delete($id){
    $old = $this->get($id);
    if(!$old) return false;

    unset($_SESSION[$this->table][$id]);
    return true;
  }

  private function mapDefaults($map, $key){
    switch($map[$key]){
      case '':
        return null;
        break;
      case 'timestamp':
        return date('U');
        break;
    }
    return null;
  }

}
