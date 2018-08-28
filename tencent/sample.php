<?php
    class tencent
    {
        public static function getOssClient()
        {
            require 'vendor/autoload.php';
            if (!isset($_FILES['file'])) {
                throw new RuntimeException('无文件上传');
            }
            $file = $_FILES['file'];
            if ($file['error']) {
                throw new RuntimeException('上传失败');
            }
            $cosClient = new Qcloud\Cos\Client(array(
                'region' => 'ap-guangzhou',
                'credentials' => array(
                    'appId' => '1257141375',
                    'secretId' => 'AKIDVCk6IOZIBtQmwvJMsEOODrKciddSYj7L',
                    'secretKey' => 'LWbXIsHVXO4Y7aszvgFhz62mMly0rW0L',
                ),
            ));
            $bucket = 'wecheng-1257141375';
            $key = time().strrchr($file['name'],'.');
            $local_path = $file['tmp_name'];
            try {
                $result = $cosClient->putObject(array(
                    'Bucket' => $bucket,
                    'Key' => $key,
                    'Body' => fopen($local_path, 'rb')
                ));
                $array = (array)$result;  
                $ObjectURL =array();
                foreach ($array as $key => $value) {
                    if($value['ObjectURL']){
                        $ObjectURL[] = $value['ObjectURL'];
                    }
                }
                //echo $result->ObjectURL;
                print_r($ObjectURL);
            } catch (\Exception $e) {
                echo($e);
            }
        }
    }
    $tencent = new tencent();
    $tencent->getOssClient();
?>
