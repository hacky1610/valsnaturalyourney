<?php

class AdminTools{
    static $version = '0.9.94';
    static $version_file = '0.9.94';
    static $namespace = "shop-notify";
    public $notifySettingsEditor;

    function __construct(){
        add_action('admin_menu', array($this, 'createMenu'));
        add_action('init',array($this, 'init') );
    }

    function init() {
       $this->RegisterPostType();
    }

    public function RegisterPostType()
    {
        $labels = array(
            'name'                => _x( 'Vals Admin Tools', 'Post Type General Name', self::$namespace),
            'singular_name'       => _x( 'Vals Admin Tools', 'Post Type Singular Name', self::$namespace ),
            'menu_name'           => __( 'Vals Admin Tools', self::$namespace ),
            'parent_item_colon'   => __( 'Parent Movie', self::$namespace )          
        );

        $args = array(
            'public' => true,
            'label'  => 'Vals Admin Tools',
            'labels' => $labels,
            'publicly_queryable' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => null,
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title'),
            'menu_icon' => 'dashicons-media-spreadsheet',
          );
        register_post_type( 'vnj-admin-tools', $args );
    }

    public function SendMails()
    {
        
        if(isset($_POST['mails'])) 
        { 
            $content = $_POST['mails'];
            $array=explode( "\r\n", $content );
            for ($i = 0; $i <= count($array); $i++) 
            {
                $this->SendMail(trim($array[$i]));
            }
        }
        $uri = $_SERVER['PHP_SELF']  . '?post_type=vnj-admin-tools&page=vnj_admin_send';
        ?>
        
        <form action="<?php echo $uri; ?>" method="post">
        
        <TEXTAREA name="mails" rows="20" cols="80"></TEXTAREA>
        <p><input type="submit" /></p>
       </form>
       <?php
    }

    public function SearchUsers()
    {
       if(isset($_POST['users'])) 
        { 
             $content = $_POST['users'];
            $array=explode( "\r\n", $content );
            for ($i = 0; $i <= count($array); $i++) 
            {
              
                $user = get_user_by( 'email', $array[$i] );
                if(!empty($user))
                {
                    echo $user->user_email;
                     echo "<br/>";
                } 
            } 
        }
        $uri = $_SERVER['PHP_SELF']  . '?post_type=vnj-admin-tools&page=vnj_admin_search';
        ?>
        
        <form action="<?php echo $uri; ?>" method="post">
            <TEXTAREA name="users" rows="20" cols="80"></TEXTAREA>
            <p><input type="submit" /></p>
       </form>
       <?php
    }

    function SendMail($mail)
    {
        try {
            include_once dirname( __FILE__ ) . '/RegistrationEmail.php';
            $user = get_user_by( 'email', $mail );
            $user_login = stripslashes($user->user_login);
            $key = get_password_reset_key( $user );
            $rp_link =  wp_login_url() ."?action=rp&key=$key&login=" . rawurlencode($user_login); 
            $wc_emails = new RegistrationEmail();
            $wc_emails->trigger($user->ID,$rp_link);
        } catch (Exception $e) {
            echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
        }
    }

    public function createMenu(){
        $namespace = self::$namespace;
        add_submenu_page("edit.php?post_type=vnj-admin-tools", __('Send mail',"shop-notify"), __("Send mail","shop-notify"), 'manage_options', 'vnj_admin_send', array( $this, 'SendMails' ));
        add_submenu_page("edit.php?post_type=vnj-admin-tools", __('Search Users',"shop-notify"), __("Search Users","shop-notify"), 'manage_options', 'vnj_admin_search', array( $this, 'SearchUsers' ));
    }
}

