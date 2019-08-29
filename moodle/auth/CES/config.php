<?php
$config['client_id'] = 'mooc_vsu_ru';
$config['partnerid'] = 'b6ed04bdfd8f4aa68f26145b77bebd5e';    // идентефикатор платформы
$config['institution'] = 'b65be69515444378ac6cdb78ebb66e14';  // идентефикатор правообладателя
$config['id'] = '3921b805-10d1-45f0-8a2b-8e3436e367fa';       // идентефикатопр пользователя
$config['client_secret'] = '7b9ff246-d7d9-48e9-83c6-4e51d985838d';

$config['openid_conf'] = 'https://sso.online.edu.ru/realms/portfolio/.well-known/openid-configuration';

$config['point_auth'] = 'https://sso.online.edu.ru/realms/portfolio/protocol/openid-connect/auth';
$config['response_type'] = 'code';
$config['redirect_url'] = 'https://mooc.vsu.ru';

$config['token_url'] = 'https://sso.online.edu.ru/realms/portfolio/protocol/openid-connect/token';