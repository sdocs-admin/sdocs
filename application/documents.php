<?php

$folders = array(
   'Входящие' => array('dirname' => 'incomming', 'in_archve' => true, 'role' => 'manager', 'security' => 'public'),
   'Исходящие' => array('dirname' => 'outgoing', 'in_archve' => true, 'role' => 'manager', 'security' => 'public'),
   'Приказы' => array('dirname' => 'order', 'in_archve' => true, 'role' => 'manager', 'security' => 'private'),
   'Заявления' => array('dirname' => 'statement', 'in_archve' => true, 'role' => 'user', 'security' => 'private'),
   'Служебные' => array('dirname' => 'memorandum', 'in_archve' => true, 'role' => 'user', 'security' => 'private'),
);

