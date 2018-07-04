<?php
add_action( 'wp_ajax_nopriv_contact_form_splash', 'contact_form_splash' );
add_action( 'wp_ajax_contact_form_splash', 'contact_form_splash' );

function contact_form_splash()
{
  $res = process_contact_form_splash();
  echo json_encode($res);
  wp_die();
}

function process_contact_form_splash()
{
  $to = get_field('splash_contact_email', 'option');
  $post = (!empty($_POST)) ? true : false;

  if ($post) {

    $name = $_POST['name'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];

    $error = '';

    // Check name

    if (!$name) {
        $error .= 'Please enter your first and last name.<br />';
    }

    // Check location

    if (!$name) {
        $error .= 'Please enter your location.<br />';
    }

    // Check email

    if (!$email) {
        $error .= 'Please enter an e-mail address.<br />';
    }

    if ($email && !ValidateEmail($email)) {
        $error .= 'Please enter a valid e-mail address.<br />';
    }

    $headers = '';
    $headers .= 'From: ' . $name . ' <' . $email . '>' . "\r\n";
    $headers .= "Reply-To: " .  $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

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
        'text' => 'Location',
        'val' => $_POST['location']
      )
    );

    $message = "";

    foreach($fields as $field) {
      $message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
    }

    if (!$error) {
        $mail = wp_mail($to, $subject, $message, $headers);

        if ($mail) {
            return 'OK';
        }
    } else {
        return '<div class="notification_error">'.$error.'</div>';
    }
  } else {
    return 'no data';
  }

}

function ValidateEmail($value)
{
	$regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';

	if($value == '') {
		return false;
	} else {
		$string = preg_replace($regex, '', $value);
	}

	return empty($string) ? true : false;
}
