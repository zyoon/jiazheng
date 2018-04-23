<?php
return [
    'adminEmail' => '2587566052@qq.com',
    'supportEmail' => '785297147@qq.com',
    'user.passwordResetTokenExpire' => 3600,
    'qnConfig' => [
        'accessKey' => 'vu94ycBYu5LDye6uNMxYgQqw67V03MV4tNzSf9GU',
        'secretKey' => 'KGrnjp00BgDC3Wrq_F3qQ_M1SQiz3wAskOHUPinv',
        'scope'=>'yuanxiang',
        'cdnUrl' => 'http://p5ippdc3b.bkt.clouddn.com',//外链域名
    ],
    'webuploader' => [
        'version' => '?v=1.0.2',
        'frontendEndDomain' => 'http://www.yuanxiangwu.com/',
        'backendEndDomain' => 'http://backend.yuanxiangwu.com/',
        'fileDomain' => 'http://file.yuanxiangwu.com/',
    ],
    'ping++' => [
      'API_KEY' => 'sk_live_SG44i15CO0iDPCKG8408yTmT',
      'PAPP_ID' => 'app_PirPm9r9Gqb99W1S',
      'PRIVATE_KEY_DIR' => 'common/rsa_private_key.pem',
    ],
    'wechat' => [
      'wx_app_id' => 'wxb9c3ebef62b8856d',
      'wx_app_secret' => '1b855985edc92a69685d33dda6170ca8',
      'redirect_url' => 'http://backend.yuanxiangwu.com/yx-order/getwxcode',
    ]
];
