<?php
// GitHub Webhook Secret.
// GitHub项目 Settings/Webhooks 中的 Secret
$secret = "houdunren";

// Path to your respostory on your server.
// e.g. "/var/www/respostory"
// 项目地址
$path = "/home/wwwroot/php7.4/vona/hd.vona.xin";

// Headers deliveried from GitHub
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if ($signature) {
  $hash = "sha1=".hash_hmac('sha1', file_get_contents("php://input"), $secret);
  if (strcmp($signature, $hash) == 0) {
  	$shell = "cd {$path} && /usr/bin/git reset --hard origin/master && /usr/bin/git clean -f && /usr/bin/git pull 2>&1";
    $exec = shell_exec($shell);
    echo $exec;
    shell_exec("cd {$path} && echo {$shell} >> test.txt 2>&1");
    shell_exec("cd {$path} && echo {$exec} >> test.txt 2>&1");
    exit();
  }
}

http_response_code(404);