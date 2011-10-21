<?php
class facebook {


  static function like($url=false) {
    if (!$url) $url=Request::current()->url();
    if (is_array($url)) $url=Request::current()->url($url);
    $url=URL::site($url,'http');
    return "
    <iframe class=\"facebook-like\" src=\"http://www.facebook.com/plugins/like.php?app_id=179663692087801&amp;href={$url}&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35\" scrolling=\"no\" frameborder=\"0\"  allowTransparency=\"true\"></iframe> 
    ";
  }

}