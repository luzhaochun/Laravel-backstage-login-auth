<?php

return [

    //七牛云配置
    'access_key'        =>  'f4KwwRppdni9NhqWilSIGlMinivNCZ3RuVRBCapf',
    'secret_key'        =>  'i3zc-WccvbPjh6sdrRimIIMxAeJHCUgs9sj4D6EQ',
    'bucket_key'        =>  [
        1               => 'id-images', //身份证
        2               => 'avator-images', //头像
        3               => 'drugstore-images', //药店营业执照
        4               => 'product-images', //产品图片
        5               => 'article-images', //文章图片
        6               => 'topic-images', //话题图片章
        7               => 'ue-images', //ueditor上传图片
        8               => 'slide-images', //幻灯片
        9               => 'test-paper-images', //题卷图片
        10              => 'event-images', //活动图片
        11              => 'audio', //音频
        12              => 'video',// 视频
        13              => 'group-images',// 群组头像
    ],
    'default_pageSize'  => 15, //默认分页条数
    'page_size' => 10,
    'page_no' => 1
];
