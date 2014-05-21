<?php
require_once __DIR__.'/aliyun-php-sdkv2-20130815/aliyun.php';

use Aliyun\OSS\OSSClient;
use Aliyun\OSS\Models\OSSOptions;

class Aliyun
{
    protected $client = null;
    
    public function __construct($accessKeyId, $accessKeySecret, $endPoint)
    {
        $this->client = OSSClient::factory(array(
            OSSOptions::ACCESS_KEY_ID => $accessKeyId,
            OSSOptions::ACCESS_KEY_SECRET => $accessKeySecret,
            OSSOptions::ENDPOINT => $endPoint,

        ));
    }

    public function listObjects($bucket)
    {
        if(!$this->client) {
            throw new \Exception("Aliyun client must be an instance of Aliyun\OSS\OSSClient");
        }
        
        $result = $this->client->listObjects(array(
            'Bucket' => $bucket,
        ));

        return $result->getObjectSummarys();
        
        foreach ($result->getObjectSummarys() as $summary) {
            echo 'Object key: ' . $summary->getKey() . "\n";
        }
    }

    public function putStringObject($bucket, $key, $content)
    {
        if(!$this->client) {
            throw new \Exception("Aliyun client must be an instance of Aliyun\OSS\OSSClient");
        }
        
        $result = $this->client->putObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'Content' => $content,
        ));
        return $result;
        
        echo 'Put object etag: ' . $result->getETag();
    }

    public function putResourceObject($bucket, $key, $content, $size)
    {
        if(!$this->client) {
            throw new \Exception("Aliyun client must be an instance of Aliyun\OSS\OSSClient");
        }
        
        $result = $this->client->putObject(array(
            'Bucket'        => $bucket,
            'Key'           => $key,
            'Content'       => $content,
            'ContentLength' => $size,
        ));

        return $result;
        
        echo 'Put object etag: ' . $result->getETag();
    }

    public function getObject($bucket, $key)
    {
        if(!$this->client) {
            throw new \Exception("Aliyun client must be an instance of Aliyun\OSS\OSSClient");
        }
   
        $object = $this->client->getObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
        ));
        return $object;
        
        echo "Object: " . $object->getKey() . "\n";
        echo (string) $object;
    }

    public function deleteObject($bucket, $key)
    {
        if(!$this->client) {
            throw new \Exception("Aliyun client must be an instance of Aliyun\OSS\OSSClient");
        }
        
        return $this->client->deleteObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
        ));
    }
}