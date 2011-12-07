<?php
include ( 'Form_action.php' );
$result = process_form ();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<form method="post" action="">
	<?php if ( is_bool ( $result ) && $result == TRUE ){ ?>
    	<p>Yay Form Posted</p>
    <?php } else { ?>
    	<?php echo $result; ?>
    <?php } ?>
	<p><label for="name">Name: </label><input type="input" name="name" id="name" /></p>
    <p><label for="email">Email: </label><input type="input" name="email" id="email" /></p>
    <p><label for="message">Message: </label><input type="input" name="message" id="message" /></p>
    <input type="submit" name="submit" value="submit" />
</form>
</body>
</html>
