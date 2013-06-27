<?php

class Mail
{
    /**
     * The email recipitent
     * 
     * @var string
     */
    public $to;


    /**
     * The email sender
     * 
     * @var string
     */
    public $from;


    /**
     * The email subject
     * 
     * @var string
     */
    public $subject;


    /**
     * Headers to be sent with the email
     * 
     * @var string
     * 
     * @access protected
     */
    protected $_headers;


    /**
     * The unique id for the mime type
     * used for attachments to emails
     * 
     * @var string
     * 
     * @access protected
     */
    protected $_mime_uid;


    /**
     * Holds the content for the email
     * 
     * @var string
     * 
     * @access protected
     */
    protected $_email_body;


    /**
     * The email attachment name
     * 
     * @var string
     * 
     * @access protected
     */
    protected $_attachment_name;


    /**
     * The email attachment content
     * 
     * @var string
     * 
     * @access protected
     */       
    protected $_attachment_content;
    

    public function __Construct($template="", $data=array())
    {   
        $this->set_email_content($template, $data);
    }
    

    /**
     * Sets the actual email content - replacing any tags with data
     * 
     * @param string $template
     * @param optional array $data
     * 
     * @return void
     */
    public function set_email_content($template, $data=array())
    {
        if( !!$data ) {
            $template = PATH.'assets/emails/'.$template.'.txt';

            if( file_exists($template) ) {
                $content = file_get_contents($template);

                foreach($columns as $col => $value) {
                    $content = str_replace('{'.strtoupper($col).'}', $value, $content);
                }

                $this->_email_body = $content;
            }
        } else {
            $this->_email_body = $template;
        }

        return $this;
    }


    /**
     * Set an attachment to an email
     * 
     * @param string $att - title of attachment
     * @param string $att - content for attachment
     * 
     * @return void
     */
    public function set_attachment( $att, $att_content )
    {
        $this->_mime_uid = md5(uniqid(time()));
        $this->_attachment_name = $att;
        $this->_attachment_content = $att_content;

        return $this;
    }


    /**
     * Set the headers for the email - sets standard or additional for attachment
     * 
     * @return void
     */
    private function set_headers()
    {
        $this->_headers = 'From: '. $this->from . "\n" .
                          'Reply-To: '. $this->from . "\n";

        $this->_headers .= "Message-ID: <".gettimeofday()." TheSystem@".$_SERVER['SERVER_NAME'].">"."\n";

        if (!!$this->_attachment_name && $this->_mine_uid) {
            $ext = strrchr( $this->_attachment_name , '.' );

            $ftype = "";
            if ( $ext == ".doc" ) $ftype = "application/msword";
            if ( $ext == ".jpg" ) $ftype = "image/jpeg";
            if ( $ext == ".gif" ) $ftype = "image/gif";
            if ( $ext == ".zip" ) $ftype = "application/zip";
            if ( $ext == ".pdf" ) $ftype = "application/pdf";
            if  ( $ftype==" " ) $ftype = "application/octet-stream";

            // build the headers for attachment and html
            $this->_headers = 'From: '. $this->from . "\n" .
                                'Reply-To: '. $this->from . "\n";
            $this->_headers .= 'MIME-Version: 1.0' . "\n";
            $this->_headers .= "Content-Type: multipart/mixed; boundary=\"".$this->_mime_uid."\"\n\n";
            $this->_headers .= "This is a multi-part message in MIME format.\n";
            $this->_headers .= "--".$this->_mime_uid."\n";
            $this->_headers .= "Content-type:text/html; charset=iso-8859-1\n";
            $this->_headers .= "Content-Transfer-Encoding: 7bit\r\n\n";
            $this->_headers .= $this->_email_body."\n\n";
            $this->_headers .= "--".$uid."\n";
            $this->_headers .= "Content-Type: ".$ftype."; name=\"".$this->_attachment_name."\"\n";
            $this->_headers .= "Content-Transfer-Encoding: base64\n";
            $this->_headers .= "Content-Disposition: attachment; filename=\"".$this->_attachment_name."\"\n\n";
            $this->_headers .= $this->_attachment_content."\n\n";
            $this->_headers .= "--".$this->_mime_uid."--";
        } else {
            $this->_headers .= "Content-type: text/html; charset=utf-8\n";
        }

        return $this;
    }


    /**
     * Sends the email
     */
    public function send ()
    {
        $this->set_headers();

        mail($this->to, $this->subject, $this->_email_body, $this->_headers);
    }


    /**
     * Magic method to set class attributes
     * 
     * @param string $key
     * @param string $value
     * 
     * @return void
     */
    public function __set($key, $value)
    {
        if( !!$this->{$key} ) {
            $this->{$key} = $value;
        }

        return $this;
    }
}
?>