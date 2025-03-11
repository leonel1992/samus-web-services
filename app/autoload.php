<?php

session_cache_limiter('private_no_expire');
session_start(); 

require_once __DIR__ . '/helpers/date.php';
require_once __DIR__ . '/helpers/json.php';
require_once __DIR__ . '/helpers/permissions.php';
require_once __DIR__ . '/helpers/values.php';
require_once __DIR__ . '/helpers/varsData.php';

require_once __DIR__ . '/config.php';

require_once __DIR__ . '/models/data/resultModel.php';
require_once __DIR__ . '/models/data/webInfoModel.php';

require_once __DIR__ . '/core/orm.php';
require_once __DIR__ . '/core/controller.php';

require_once __DIR__ . '/services/databaseService.php';
require_once __DIR__ . '/services/emailService.php';
require_once __DIR__ . '/services/codeService.php';
require_once __DIR__ . '/services/loginService.php';

require_once __DIR__ . '/router.php';