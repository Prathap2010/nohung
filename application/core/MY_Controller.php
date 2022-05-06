    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class MY_Controller extends CI_Controller {

        public $Usertype;
        public $Emailtype;
        public $MenuLunchCategory;
        public $MenuDinnerCategory;

        function __construct()
        {
            parent::__construct();
            $this->getSettingDetail();
            if( 
                (string)$this->uri->segment(1)."/" !== (string)ADMINFOLDER &&
                (string)$this->uri->segment(1) !== (string)"assets" &&
                FRONT_WEBSITE == 0
            ){
                redirect(ADMINFOLDER."login");
            }

            $this->Emailtype = array(
                1 => "Register",
                2 => "Reset Password"
            );
            /* $this->MenuLunchCategory = array(
                1 => "Rice",
                2 => "Dal",
                3 => "Bread",
                4 => "Veg",
                5 => "Non Veg",
                6 => "Others",
            ); */
            $this->MenuLunchCategory = array(
                1 => "Veg",
                2 => "Non Veg"
            );
            /* $this->MenuDinnerCategory = array(
                1 => "Rice",
                2 => "Dal",
                3 => "Bread",
                4 => "Veg",
                5 => "Non Veg",
                6 => "Others",
            ); */
        }

        function getSettingDetail()
        {
            $this->db->select('*');
            $query = $this->db->get_where('sitesetting');
            
            if ($query->num_rows() > 0) {
                $arr = $query->row_array();
                            
                define("SITE_NAME", $arr['sitename']);
                define("SITE_EMAIL", $arr['email']);
                define("TAX_ON_ORDER", $arr['taxonorder']);
                define("DELIVERY_CHARGE_PER_KM", $arr['delivery_charge_per_km']);
                define("RADIUS_IN_KM", $arr['radius_in_km']);
                define("SITE_LOGO", $arr['logo']);
                define("SITE_FAVICON", $arr['logo']);

                define("FACEBOOK_APP_ID",$arr['facebook_app_id']);
                define("FACEBOOK_APP_SECRET",$arr['facebook_app_secret']);
                
                define("GOOGLE_CLIENT_ID",$arr['google_client_id']);
                define("GOOGLE_CLIENT_SECRET",$arr['google_client_secret']);
                define("GOOGLE_API_KEY",$arr['google_api_key']);
                
                define("TWITTER_LINK",$arr['twitterlink']);
                define("FACEBOOK_LINK",$arr['facebooklink']);
                define("INSTAGRAM_LINK",$arr['instagramlink']);

                define("GOOGLE_MAP_API_KEY",$arr['mapapikey']);
                define("FRONT_WEBSITE",1);

                if(strtolower($arr['mailserver']) == 'smtp'){
                    define("MAIL_EMAIL", $arr['portemail']);
                    define("MAIL_HOST", $arr['mailhost']);
                    define("MAIL_PASSWORD", $arr['password']);
                    define("MAIL_PORTNO", $arr['portno']);
                    define("MAIL_SERVER", 'smtp');
                }else{
                    define("MAIL_EMAIL", '');
                    define("MAIL_HOST", '');
                    define("MAIL_PASSWORD", '');
                    define("MAIL_PORTNO", '25');
                    define("MAIL_SERVER", 'mail');
                }
                /* EMAIL CONFIGURATION CONSTANTS */
                define("EMAIL_CONFIG", serialize(array(
                        'protocol' => MAIL_SERVER,
                        'charset' => 'utf-8',
                        'wordwrap' => TRUE,
                        'mailtype' => 'html',
                        )
                    )
                );
            }
        }
    }


