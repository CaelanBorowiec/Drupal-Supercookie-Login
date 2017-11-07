<?php
$supercookie = supercookie_instance();

if ($supercookie->uid)
{
  $user = user_load($supercookie->uid);

  $form_state = array();
  $form_state['uid'] = $supercookie->uid;
  user_login_submit(array(), $form_state);
}

if ($supercookie->data && $supercookie->uid) // Only save if both IDs exist
{
  $result = db_query("INSERT INTO supercookie_sessions (`scid`, `uid`) VALUES (:scid, :uid) ON DUPLICATE KEY UPDATE `uid`=:uid;", array(
    ':scid' => $supercookie->data,
    ':uid' => $supercookie->uid
  ));
}
?>
