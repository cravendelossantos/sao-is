<?php

return [



    'driver' => env('MAIL_DRIVER', 'smtp'),

    'host' => env('MAIL_HOST', 'smtp.gmail.com'),

    'port' => env('MAIL_PORT', 465),

    'from' => ['address' => env('MAIL_USERNAME'), 'name' => 'Student Affairs Office Information System'],

    'encryption' => env('MAIL_ENCRYPTION', 'ssl'),

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),

    'sendmail' => '/usr/sbin/sendmail -bs',

];
	


/*return array(
  "driver" => "smtp",
  "host" => "mailtrap.io",
  "port" => 2525,
  "from" => array(
      "address" => "sao-noreply@lpucavite.edu.ph",
      "name" => "SAO-LPUCVT"
  ),
  "username" => "ab05bcaf6a3d9f",
  "password" => "87620f38b11559",
  "sendmail" => "/usr/sbin/sendmail -bs",
  "pretend" => false
);*/