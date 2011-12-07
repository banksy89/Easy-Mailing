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
			$_mail = new Send_mail;
			
			$message = file_get_contents( 'Email.php' );
	
			foreach ( $cols as $col => $key )
			{
				$message = str_replace( '{' . strtoupper( $col ) . '}', $_POST[ $col ], $message );
			}
			
			$_mail->setter ( $_POST['email'], 'Subject of choice', 'info@ashley.com', $message );
			
			return TRUE;
		}
		else
		{
			return $_val->error;	
		}
		
	}
}





?>