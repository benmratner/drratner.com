<?php
add_action( 'wp_ajax_nopriv_contact_form', 'contact_form' );
add_action( 'wp_ajax_contact_form', 'contact_form' );

function contact_form()
{
  $res = process_contact_form();
  echo json_encode($res);
  wp_die();
}

function process_contact_form()
{
  $to = get_field('contact_email', 'option');
  $subject = $_POST['subject'];

  if($to) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $fields = array(
      0 => array(
        'text' => 'Name',
        'val' => $_POST['name']
      ),
      1 => array(
        'text' => 'Email address',
        'val' => $_POST['email']
      ),
      2 => array(
        'text' => 'Message',
        'val' => $_POST['message']
      )
    );

    $message = "";

    foreach($fields as $field) {
      $message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
    }

    $headers = '';
    $headers .= 'From: ' . $name . ' <' . $email . '>' . "\r\n";
    $headers .= "Reply-To: " .  $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)){
      $arrResult = array ('response'=>'success');
    } else{
      $arrResult = array ('response'=>'error');
    }

  } else {
    $arrResult = array ('response'=>'error');
  }
  return $arrResult;
}
