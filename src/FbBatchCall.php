<?php
class FbBatchCall {
  
  private $id;
  private $path;
  private $method;
  private $params;
  
  private $rawResult;
  private $result;
  private $isOk;
  private $error;
  
  /**
   * 
   * @param string $path
   * @param string $method
   * @param array $params
   */
  public function __construct($path, $method = 'GET', $params = array()) {
    $this->id = uniqid();
    $this->path = $path;
    $this->method = $method;
    $this->params = $params;
  }
  
  /**
   * 
   * @return array
   */
  public function getRequestParams() {
    return array('name' => $this->id,
                 'method' => $this->method,
                 'relative_url' => $this->path,
                 'omit_response_on_success' => false);
  }
  
  /**
   * 
   * @param string $field
   * @return string
   */
  public function getParam($field) {
    return '{result=' . $this->id . ':$.' . $field . '}';
  }
  
  /**
   * 
   * @param array $raw
   */
  public function setRawResult($raw) {
    $this->rawResult = $raw;
    $this->isOk = $this->rawResult['code'] == 200;
    
    $body = json_decode($this->rawResult['body'], true);
    
    if(!$this->isOk) {
      $this->result = null;
      $this->error = $body['error'];
    }else {
      $this->result = $body;
    }
  }
  
  /**
   * 
   * @return array
   */
  public function getResult() {
    return $this->result;
  }
  
  /**
   * 
   * @return bool
   */
  public function isOk() {
    return $this->isOk;
  }
  
  /**
   * 
   * @return array
   */
  public function getError() {
    return $this->error;
  }
  
  /**
   * 
   * @return array
   */
  public function getRaw() {
    return $this->rawResult;
  }
}