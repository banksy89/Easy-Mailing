<?php

	class Send_mail {
		
		private $_recipent,
				$_subject,
				$_from,
				$_message,
				$_headers;
		
		public function setter ( $recipent, $subject, $from, $message )
		{
			$this->_recipent = $recipent;
			$this->_subject = $subject;
			$this->_from = $from;
			$this->_message = $message;	
			
			$this->send();
		}
		
		private function setup_headers ()
		{
			$this->_headers = 'From: '. $this->_from . "\n" .
							  'Reply-To: '. $this->_from . "\n" .
							  'X-Mailer: PHP/' . phpversion();
			$this->_headers .= 'MIME-Version: 1.0' . "\n";
			$this->_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
		}
		
		private function send ()
		{
			$this->setup_headers();
			
			mail( $this->_recipent, $this->_subject, $this->_message, $this->_headers );
		}
			
	}

?>