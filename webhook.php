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
shell_exec("echo {$signature} >> {$path}/test.txt");

if ($signature) {
  $hash = "sha1=".hash_hmac('sha1', file_get_contents("php://input"), $secret);
  shell_exec("echo {$hash} >> {$path}/test.txt");
  if (strcmp($signature, $hash) == 0) {
    $exec = shell_exec("cd {$path} && /usr/bin/git reset --hard origin/master && /usr/bin/git clean -f && /usr/bin/git pull 2>&1");
    echo $exec;
    shell_exec("echo {$exec} >> {$path}/test.txt");
    exit();
  }
}

http_response_code(404);