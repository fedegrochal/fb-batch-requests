FbBatch
============

La clase FbBatch te permite hacer uso de Facebook Batch Requests de manera muy sencilla. 
Que es Facebook Batch Requests?

>The standard version of the Graph API is designed to make it really easy to get data for an individual object and to browse connections between objects. It also includes a limited ability to retrieve data for a few objects at the same time.

>If your application needs the ability to access significant amounts of data in a single go - or you need to make changes to several objects at once, it is often more efficient to batch your queries rather than make multiple individual HTTP requests.

>To enable this, the Graph API supports Batching. Batching allows you to pass instructions for several operations in a single HTTP request. You can also specify dependencies between related operations (described in a section below). Facebook will process each of your independent operations in parallel and will process your dependent operations sequentially. Once all operations have been completed, a consolidated response will be passed back to you and the HTTP connection will be closed.

Mas info: https://developers.facebook.com/docs/reference/api/batch/.

## Ejemplos

#### Multiples llamadas
```php
<?php 
$fb = new Facebook(array('appId' => '####', 'secret' => '####'));
$batch = new FbBatch($fb);

$me = $batch->api('/me');
$friends = $batch->api('/me/friends');

$batch->send();

var_dump($me->getResult());
var_dump($friends->getResult());
?>
```

#### Multiples llamadas
```php
<?php 
$fb = new Facebook(array('appId' => '###', 'secret' => '###'));
$batch = new FbBatch($fb);

$pageIds = array('pageId1', 'pageId2', 'pageId3', 'pageId4', 'pageId5', 'pageIdN');
foreach($pageIds as $id) {
  $batch->api('/' . $id);
}

$calls = $batch->send();
foreach($calls as $call) {
  var_dump($call->getResult());
}
?>
```

#### Dependencias
```php
<?php 
$fb = new Facebook(array('appId' => '###', 'secret' => '###'));
$batch = new FbBatch($fb);

$me = $batch->api('/me');
$favoriteAthletes = $batch->api('?ids=' . $me->getParam('favorite_athletes.*.id'));

$batch->send();


var_dump($me->getResult());
var_dump($favoriteAthletes->getResult());
?>
```
