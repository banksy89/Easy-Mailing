<?php
	
	define ( 'SUBJECT', 'subject' );
	define ( 'FROM', 'from' );
	define ( 'RECIPENT', 'recipent' );
	
	class Mail {
		
		private $_recipent,
				$_subject,
				$_from,
				$_message,
				$_headers;
				
		public function setter ( $field, $value )
		{
			$this->{'_'. $field } = $value;
			return $this;	
		}
		
		public function setBody ( $email, $columns )
		{
			$message = file_get_contents( $email );
	
			foreach ( $cols as $col => $key )
				$this->_message = str_replace( '{' . strtoupper( $col ) . '}', $key, $message );
				
			return $this;
		}
		
		private function setHeaders ()
		{
			$this->_headers = 'From: '. $this->_from . "\n" .
							  'Reply-To: '. $this->_from . "\n" .
							  'X-Mailer: PHP/' . phpversion();
			$this->_headers .= 'MIME-Version: 1.0' . "\n";
			$this->_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
			
			return $this;
		}
		
		public function send ()
		{
			$this->setHeaders();
			
			mail ( $this->_recipent, $this->_subject, $this->_message, $this->_headers );
		}
			
	}

?>