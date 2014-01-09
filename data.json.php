<?php
  if (!getenv('CIP_DASHBOARD_MONGODB_URL')) {
    header('HTTP/1.1 500 Internal Server Error');
    // header('Content-Type: text');
    die('CIPdashboard: You need to define the environment variable CIP_DASHBOARD_MONGODB_URL. See README.md for more info.');
  } else {
    $m = new \MongoClient(getenv('CIP_DASHBOARD_MONGODB_URL'));

    $uuid_adequate_registration = '{dbafdb2c-2256-48e4-b882-0985a9eb507b}';
    $uuid_license = '{f5d1dcd8-c553-4346-8d4d-672c85bb59be}';
    $uuid_copyright_notice = '{af4b2e2c-5f6a-11d2-8f20-0000c0e166dc}';

    $db = $m->natmus;
    $collection = $db->cip_stats;

    $cursor = $collection->find()->sort(array('_id' => -1))->limit(1);
    $document = $cursor->getNext();

    echo json_encode($document);
  }
?>
