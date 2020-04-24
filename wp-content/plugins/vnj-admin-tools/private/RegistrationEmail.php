<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Email' ) ) {
	return;
}

        class RegistrationEmail extends WC_Email {

        /**
         * User login name.
         *
         * @var string
         */
        public $user_login;

        /**
         * User email.
         *
         * @var string
         */
        public $user_email;

        public $login_uri;
        public $first_name;
        public $subject;
        public $heading;

        /**
         * Constructor.
         */
        public function __construct() {
            $this->id             = 'customer_new_account';
            $this->customer_email = true;
            $this->title          = __( 'New account', 'woocommerce' );
            $this->description    = __( 'Customer "new account" emails are sent to the customer when a customer signs up via checkout or account pages.', 'woocommerce' );
            parent::__construct();
        }

        /**
         * Get email subject.
         *
         * @since  3.1.0
         * @return string
         */
        public function get_default_subject() {
            return $this->subject;
        }

        /**
         * Get email heading.
         *
         * @since  3.1.0
         * @return string
         */
        public function get_default_heading() {
            return $this->heading;
        }

        /**
         * Trigger.
         *
         * @param int    $user_id User ID.
         * @param string $user_pass User password.
         * @param bool   $password_generated Whether the password was generated automatically or not.
         */
        public function trigger( $user_id,$uri,$newUser ) {
            $this->setup_locale();

            if ( $user_id ) {
                $this->object = new WP_User( $user_id );
                if(empty($this->object->first_name ))
                {
                    $this->first_name         = stripslashes( $this->object->user_login );
                }
                else
                {
                    $this->first_name         = $this->object->first_name;
                }
              
                $this->user_login         = stripslashes( $this->object->user_login );
                $this->user_email         = stripslashes( $this->object->user_email );
                $this->recipient          = $this->user_email;
                $this->user_login_uri     = $uri;
                $this->subject = "La méthode d'accès au BOOST LA POUSSE DE TES CHEVEUX a changé";
                $this->heading = "La méthode d'accès au BOOST LA POUSSE DE TES CHEVEUX a changé";
                if($newUser)
                {
                    $this->template_html  = 'emails/customer-registration.php';
                }
                else
                {
                    $this->template_html  = 'emails/customer-membership-change.php';
                    
                }
            }

            if ( $this->is_enabled() && $this->get_recipient() ) {
                $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
            }

            $this->restore_locale();
        }

        /**
         * Get content html.
         *
         * @return string
         */
        public function get_content_html() {
            return wc_get_template_html(
                $this->template_html, array(
                    'email_heading'      => $this->get_heading(),
                    'user_login'         => $this->user_login,
                    'first_name'         => $this->first_name,
                    'user_login_uri'     => $this->user_login_uri,
                    'blogname'           => $this->get_blogname(),
                    'password_generated' => $this->password_generated,
                    'sent_to_admin'      => false,
                    'plain_text'         => false,
                    'email'              => $this,
                )
            );
        }

        /**
         * Get content plain.
         *
         * @return string
         */
        public function get_content_plain() {
            return wc_get_template_html(
                $this->template_plain, array(
                    'email_heading'      => $this->get_heading(),
                    'user_login'         => $this->user_login,
                    'user_login_uri'     => $this->user_login_uri,
                    'blogname'           => $this->get_blogname(),
                    'password_generated' => $this->password_generated,
                    'sent_to_admin'      => false,
                    'plain_text'         => true,
                    'email'              => $this,
                )
            );
        }
    }

