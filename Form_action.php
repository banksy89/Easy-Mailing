<?php

include ( 'Validation.php' );
include ( 'Mail.php' );



function process_form ()
{
	$cols = array ( 'name' => 'Please provide your name', 
					'email' => 'Please provide your email address', 
					'message' => 'Please provide a message for email'
				   );
				   
	if ( !!$_POST )
	{
		$_val = new Validation;
		
		$_val->check_empty( $cols )
			 ->valid_email( 'email' );
		
		if ( $_val->work )
		{
			$_mail = new Mail;
			
			$_mail->setter ( RECIPENT, 'me@me.com' )
				  ->setter ( SUBJECT, 'A subject' )
				  ->setter ( FROM, 'me@me.com' )
				  ->setBody ( 'Email.php', $_POST );
				  
			$_mail->send ();
			
			return TRUE;
		}
		else
		{
			return $_val->error;	
		}
		
	}
}





?>