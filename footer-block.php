<?php
$supercookie = supercookie_instance();

if ($supercookie->uid)
{
  $user = user_load($supercookie->uid);

  $form_state = array();
  $form_state['uid'] = $supercookie->uid;
  user_login_submit(array(), $form_state);
}
?>
