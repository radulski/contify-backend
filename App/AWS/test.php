<?php

require '../../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$bucket = 'bucket260711';
$keyname = 'h3u28Bto3bhxBHLdb3iwSnhd8TsW2DolqVFndqWK';

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'sa-east-1'
]);


 // Upload data.
 $result = $s3->putObject([
    'Bucket' => $bucket,
    'Key'    => $keyname,
    'Body'   => 'Hello, world!',
    'ACL'    => 'public-read'
]);


/*
try {
    // Upload data.
    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key'    => $keyname,
        'Body'   => 'Hello, world!',
        'ACL'    => 'public-read'
    ]);

    // Print the URL to the object.
    echo $result['ObjectURL'] . PHP_EOL;
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
*/

/*
//Listing all S3 Bucket
$buckets = $s3Client->listBuckets();
foreach ($buckets['Buckets'] as $bucket) {
    echo $bucket['Name'] . "\n";
    
}
*/