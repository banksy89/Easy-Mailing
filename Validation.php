<?php

	class Validation {
		
		public $error,
			   $work = TRUE,
			   $missing = array();
	
		
		public function check_empty ( $fields )
		{
			if ( !is_array( $fields ) )
			{
				$fields = explode( ',', $fields );
			}
			
			foreach ( $fields as $key => $error )
			{
				
				if( $_POST[ $key ] == '' )
				{
					if( is_string ( $error ) )
					{
						$this->error .= '<p class="msg-error"><span>*</span>' . $error . '.</p>';
					}
					elseif( !is_string ( $error ) )
					{
						$this->error .= '<p class="msg-error"><span>*</span>Please provide your ' . $key . '.</p>';
					}
					
					array_push( $this->missing, $error ) ;
					
					$this->work = FALSE;
				}
			}
			return $this;
		}
		
		public function valid_email ( $string )
		{
			if( filter_var( $_POST[ $string ], FILTER_VALIDATE_EMAIL ) == FALSE )
			{
				$this->error .= '<p class="msg-error"><span>*</span>Email Address is not a valid format.</p>';
				
				$this->work = FALSE;
				
				array_push ( $this->missing, $string );
			}
			return $this;
		}
	}


?>