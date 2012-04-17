<?php

	/**
	* Handles the processing of the form
	*/
	
	include ( 'Validation.php' );
	include ( 'Mail.php' );
	
	class Handle_form {
	
		private $_validation,
				$_mail,
				$_columns = array ();
		
		public function __Construct ()
		{
			$this->_validation = new Validation;
			$this->_mail = new Mail;
			return $this;
		}
		
		public function setColumns ( $columns )
		{
			$this->_columns = $columns;
			return $this;
		}
		
		public function process ()
		{
			if ( !!$_POST )
			{
				$this->_validation->check_empty( $this->_columns )
					 ->valid_email( 'email' );
					 
				if ( $this->_validation->work )
				{
					$this->_mail->setter ( RECIPENT, 'me@me.com' )
					            ->setter ( SUBJECT, 'A subject' )
					  			->setter ( FROM, 'me@me.com' )
					  			->setBody ( $_SERVER['DOCUMENT_ROOT'] . '/Email/Email.php', $_POST );
					  
					$this->_mail->send ();
					
					return TRUE;
				}
				else
				{
					return $this->_validation->error;	
				}
			}
		}
		
	}
?>