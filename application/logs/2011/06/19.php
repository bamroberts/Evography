<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-06-19 10:07:57 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'system' in 'field list' [ INSERT INTO `albums` (`id`, `parent_id`, `user_id`, `name`, `desc`, `private`, `comments`, `published`, `open`, `cart`, `export`, `theme`, `type`, `cover_image_id`, `route_id`, `add_date`, `add_user_id`, `mod_date`, `mod_user_id`, `order`, `system`, `count`) VALUES ('0', '15', '16', 'Name 223', '', '0', '0', '0', '0', '0', '0', '0', 'album', '0', '0', '2011-Jun-19 10:07:56', '16', '2011-Jun-19 10:07:56', '16', '0', '0', '0') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2011-06-19 10:08:38 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'count' in 'field list' [ INSERT INTO `albums` (`id`, `parent_id`, `user_id`, `name`, `desc`, `private`, `comments`, `published`, `open`, `cart`, `export`, `theme`, `type`, `cover_image_id`, `route_id`, `add_date`, `add_user_id`, `mod_date`, `mod_user_id`, `order`, `count`) VALUES ('0', '15', '16', 'Name 223', '', '0', '0', '0', '0', '0', '0', '0', 'album', '0', '0', '2011-Jun-19 10:08:38', '16', '2011-Jun-19 10:08:38', '16', '0', '0') ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]