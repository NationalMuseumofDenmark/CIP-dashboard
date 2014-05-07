<?php
define('DATA_VERSION', 4);
define('TEMP_FILE', 'data.json.temp');
define('UPDATE_INTERVAL', 3600); // 3600 seconds == 1 hour

  // If we have a recent copy (1 hour) of the data -- return that
  // -- force data reload with `data.json.php?force_update=1`
  $last_modified = filemtime(TEMP_FILE); // UNIX timestamp (seconds since Epoch)
  if (!isset($_GET['force_update']) && time() - $last_modified < UPDATE_INTERVAL) {
    echo file_get_contents(TEMP_FILE);
    exit(0);
  }

  try {
    $m = new \MongoClient(getenv('CIP_DASHBOARD_MONGODB_URL'));
  } catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    // header('Content-Type: text');
    $error_msg = <<<EOS
CIPdashboard: Could not connect to MongoDB.
You need to either define the environment variable CIP_DASHBOARD_MONGODB_URL or
have a MongoDB database running on the same machine as the CIP-dashboard.
See README.md for more info.
EOS;
    die($error_msg);
  }

  $uuid_adequate_registration = '{dbafdb2c-2256-48e4-b882-0985a9eb507b}';
  $uuid_license = '{f5d1dcd8-c553-4346-8d4d-672c85bb59be}';
  $uuid_copyright_notice = '{af4b2e2c-5f6a-11d2-8f20-0000c0e166dc}';

  $db = $m->natmus;
  $collection = $db->cip_stats;

  $cursor = $collection->find(array('data_version' => DATA_VERSION))->sort(array('timestamp' => -1))->limit(1);
  $document = $cursor->getNext();


  // Save to temp file
  $json = json_encode($document);
  file_put_contents(TEMP_FILE, $json);

  // Write response
  echo $json;
?>
