<?php
global $user;
$supercookie = supercookie_instance();

if ($supercookie->data && $supercookie->uid) // Only save if both IDs exist
{
  db_query("INSERT INTO `supercookie_sessions` (`scid`, `uid`) VALUES (:scid, :uid) ON DUPLICATE KEY UPDATE `uid`=:uid;", array(
    ':scid' => $supercookie->data,
    ':uid' => $supercookie->uid
  ));
}

if (!$user->uid && $supercookie->data)  //Not logged in, but supercookie detected
{
  $result = db_query("SELECT `uid` FROM `supercookie_sessions` WHERE `scid` = :scid LIMIT 1", array(
    ':scid' => $supercookie->data
  ));
  $records = $result->fetchAll();

  foreach ($records as $record)
  {
    $user = user_load($record->uid);
    //echo 'found user ' .$record->uid;
    $form_state = array("uid" => $record->uid);
    $form_state['uid'] = $record->uid;
    user_login_submit(array(), $form_state);
  }
}
?>
