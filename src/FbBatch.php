<?php
class FbBatch {
  
  private $fb;
  private $calls;
  
  /**
   * 
   * @param Facebook $fb
   */
  public function __construct(Facebook $fb) {
    $this->fb = $fb;
    $this->calls = array();
  }
  
  /**
   * Add an api call to the batch. Returns the call object
   * @param string $path
   * @param string $method
   * @param array $params
   * @return \FbBatchCall
   */
  public function api($path, $method = 'GET', $params = array()) {
    $request = new FbBatchCall($path, $method, $params);
    $this->calls[] = $request;
    return $request;
  }
  
  /**
   * 
   * @return array
   */
  public function send() {
    $batchParams = $this->buildBatchRequest();
    $result = $this->doApiCall($batchParams);
    $this->processBatchResult($result);
    return $this->calls;
  }
  
  private function buildBatchRequest() {
    $all = array();
    foreach($this->calls as $request) {
      $all[] = $request->getRequestParams();
    }
    return $all;
  }
  
  private function doApiCall($batchParams) {
    return $this->fb->api('/', 'POST', array('batch' => $batchParams));
  }
  
  private function processBatchResult($result) {
    foreach($result as $key => $value) {
      $this->calls[$key]->setRawResult($value);
    }
  }
  
}