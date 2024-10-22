<?php
    //Ontrack #1037
    class BrowserCheck{
        public function check($authController){
            global $sugar_config;

            if(!$this->is_allowed_browser()){
                $this->show_message($sugar_config['site_url']);
                session_start();
			    session_destroy();
                die();
            }
            
        }

        public function is_allowed_browser(){
            $result = true;
            $browser = $this->get_browser();

            if($browser == 'Internet explorer'){
                $result = false;
            }

            //$result = 'false';

            return $result;
        }

        private function show_message($site_url){
            echo <<<EOD
            <div id="dialog-message" title="Browser Not Supported">
                <p>
                Internet Explorer is not supported. Please use other browsers instead.
                </p>
            </div>

                <link rel="stylesheet" href="include/javascript/jquery/themes/base/jquery-ui.css" />
                <style type="text/css">
                .ui-dialog-titlebar-close {
                    visibility: hidden;
                }
                </style>
                <script type="text/javascript" src="include/javascript/jquery/jquery-min.js"></script>
                <script type="text/javascript" src="include/javascript/jquery/jquery-ui-min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function(e){
                        $( "#dialog-message" ).dialog({
                            modal: true,
                            draggable: false,
                            resizable: false,
                            closeOnEscape: false,
                            open: function(event, ui) {
                                $(".ui-dialog-titlebar-close", ui.dialog || ui).hide();
                            },
                            buttons: {
                              OK: function() {
                                $( this ).dialog( "close" );
                                window.location.href = "{$site_url}";
                              }
                            }
                          });
                    });
                    
                </script>
EOD;
        }

        private function get_browser(){
            $result = '';

            if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
                $result = 'Internet explorer';
            elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
                $result = 'Internet explorer';
            elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
                $result = 'Mozilla Firefox';
            elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
                $result = 'Google Chrome';
            elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
                $result = "Opera Mini";
            elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
                $result = "Opera";
            elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
                $result = "Safari";

            return $result;
        }
    }
?>