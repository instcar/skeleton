<?php
require_once __DIR__.'/aliyun-php-sdkv2-20130815/aliyun.php';

use Aliyun\OSS\OSSClient;
use Aliyun\OSS\Models\OSSOptions;

class Aliyun
{
    public function createClient($accessKeyId, $accessKeySecret)
    {
        return OSSClient::factory(array(
            OSSOptions::ACCESS_KEY_ID => $accessKeyId,
            OSSOptions::ACCESS_KEY_SECRET => $accessKeySecret,
            OSSOptions::ENDPOINT => 'http://oss-cn-qingdao.aliyuncs.com',
        ));
    }

    public function listObjects(OSSClient $client, $bucket)
    {
        $result = $client->listObjects(array(
            'Bucket' => $bucket,
        ));
        foreach ($result->getObjectSummarys() as $summary) {
            echo 'Object key: ' . $summary->getKey() . "\n";
        }
    }

    public function putStringObject(OSSClient $client, $bucket, $key, $content)
    {
        $result = $client->putObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'Content' => $content,
        ));
        echo 'Put object etag: ' . $result->getETag();
    }

    public function putResourceObject(OSSClient $client, $bucket, $key, $content, $size)
    {
        $result = $client->putObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'Content' => $content,
            'ContentLength' => $size,
        ));
        echo 'Put object etag: ' . $result->getETag();
    }

    public function getObject(OSSClient $client, $bucket, $key)
    {
        $object = $client->getObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
        ));

        echo "Object: " . $object->getKey() . "\n";
        echo (string) $object;
    }

    public function deleteObject(OSSClient $client, $bucket, $key)
    {
        $client->deleteObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
        ));
    }
}