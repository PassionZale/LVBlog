<?php

return [
    // url
    'url' => env('QINIU_URL'),
    // AK
    'accessKey' => env('QINIU_AK'),
    // SK
    'secretKey' => env('QIUNIU_SK'),
    // 上传的空间
    'bucket' => env('QINIU_BUCKET'),
    // 文件的公共前缀
    'prefix' => env('QINIU_PREFIX', ''),
    // 图片样式
    'imgClass' => env('QINIU_IMGCLASS', ''),
];
