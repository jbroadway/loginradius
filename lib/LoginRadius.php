<?php

  class LoginRadius
    {

     public $ID,$EmailID,$FirstName,$LastName,$Provider,$IsAuthenticate,$IsVaryfied; 
      
		 
       public function __construct($ApiSecrete)
        {
          
            $IsAuthenticate = false;
			

			
            if (isset($_REQUEST['id']) &&  isset($_REQUEST['token']))
            {

                

        $ValidateUrl = "http://hub.loginradius.com/ValidateToken.ashx?token=".$_REQUEST['token']."&apisecrete=".$ApiSecrete."";
				
				
				
				$IsVaryfied = file_get_contents($ValidateUrl);
                

                if ($IsVaryfied == TRUE)
                {
                    $this->ID = $_REQUEST['id'];
                    $this->EmailID = $_REQUEST['email'];
                     $this->FirstName = $_REQUEST['fname'];
                    $this->LastName = $_REQUEST['lname'];
                    $this->Provider = $_REQUEST['provider'];
                    $this->IsAuthenticate = true;
					
					
                }
            }
        }
	
    }

    
    
 ?>    