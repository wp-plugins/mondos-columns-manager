<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.squareonemd.co.uk
 * @since      1.0.0
 *
 * @package    Mondos_Columns
 * @subpackage Mondos_Columns/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mondos_Columns
 * @subpackage Mondos_Columns/admin
 * @author     Elliott Richmond elliott@squareonemd.co.uk
 */
class Mondos_Columns_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $mondos_columns    The ID of this plugin.
	 */
	private $mondos_columns;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $mondos_columns       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $mondos_columns, $version ) {

		$this->mondos_columns = $mondos_columns;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mondos_Columns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mondos_Columns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->mondos_columns, plugin_dir_url( __FILE__ ) . 'css/mondos-columns-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mondos_Columns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mondos_Columns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->mondos_columns, plugin_dir_url( __FILE__ ) . 'js/mondos-columns-admin.js', array( 'jquery' ), $this->version, false );

	}
	
    /**
     * Add options page
     */
    public function add_plugin_page()
    {

        // This page will sit under "Settings"
        add_options_page(
            'Settings Mondos Columns', 
            'Columns Manager', 
            'manage_options', 
            'mondos-setting-admin', 
            array( $this, 'mondos_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function mondos_admin_page()
    {
        // Set class property
        $this->options = get_option( 'mondos_posts_columns_options' );
        ?>
			   
		<div id="mondos" class="wrap">
			
			<div id="icon-options-general" class="icon32"></div>
			<h2>Mondos Columns Manager</h2>
			
			<div id="poststuff">
			
				<div id="post-body" class="metabox-holder columns-2">
				
					<!-- main content -->
					<div id="post-body-content">
						
						<div class="meta-box-sortables ui-sortable">
							
							<div class="postbox">
							
								<h3><span>Settings</span></h3>
								<div class="inside">
									
						            <form method="post" action="options.php">
						            <?php
						                // This prints out all hidden setting fields
						                settings_fields( 'mondos_post_columns_option_group' );   
						                do_settings_sections( 'mondos-columns-setting-admin' );
						                submit_button(); 
						            ?>
						            </form>
						            
								</div> <!-- .inside -->
							
							</div> <!-- .postbox -->
							
						</div> <!-- .meta-box-sortables .ui-sortable -->
						
					</div> <!-- post-body-content -->
					
					<!-- sidebar -->
					<div id="postbox-container-1" class="postbox-container">
						
						<div class="meta-box-sortables">
							
							<div class="postbox">
							
								<h3><span>What to do</span></h3>
								<div class="inside">
									This is a simple plugin to help remove columns from the WordPress list view for Posts, Pages & Users,
									when activating the checkbox the column for the that section will be removed.
								</div> <!-- .inside -->
								
							</div> <!-- .postbox -->
							
						</div> <!-- .meta-box-sortables -->
						
					</div> <!-- #postbox-container-1 .postbox-container -->
					
				</div> <!-- #post-body .metabox-holder .columns-2 -->
				
				<br class="clear">
			</div> <!-- #poststuff -->
			
		</div> <!-- .wrap -->
        <?php
    }


    /**
     * Register and add settings
     * @TODO clean up comments
     * @TODO add a title option
     * @TODO add a css overide option,
     *   check priorty loading and css specificity 
     *   the theme might override naturally 
     */
    public function page_init()
    {        
        register_setting(
            'mondos_post_columns_option_group', // Option group
            'mondos_posts_columns_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Disable Post Columns', // Title
            array( $this, 'print_post_section_info' ), // Callback
            'mondos-columns-setting-admin' // Page
        );  

        add_settings_field(
            'mondos_post_author', // ID
            'Disable Author Column', // Title 
            array( $this, 'mondos_post_author_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'mondos_post_categories', // ID
            'Disable Categories Column', // Title 
            array( $this, 'mondos_post_categories_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'mondos_post_tags', // ID
            'Disable Tags Column', // Title 
            array( $this, 'mondos_post_tags_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'mondos_post_comments', // ID
            'Disable Comments Column', // Title 
            array( $this, 'mondos_post_comments_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'mondos_post_date', // ID
            'Disable Date Column', // Title 
            array( $this, 'mondos_post_date_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_section(
            'setting_page_columns_id', // ID
            'Disable Page Columns', // Title
            array( $this, 'print_page_section_info' ), // Callback
            'mondos-columns-setting-admin' // Page
        );  

        add_settings_field(
            'mondos_page_author', // ID
            'Disable Author Column', // Title 
            array( $this, 'mondos_page_author_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_page_columns_id' // Section           
        );      

        add_settings_field(
            'mondos_page_comments', // ID
            'Disable Comments Column', // Title 
            array( $this, 'mondos_page_comments_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_page_columns_id' // Section           
        );

        add_settings_field(
            'mondos_page_date', // ID
            'Disable Date Column', // Title 
            array( $this, 'mondos_page_date_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_page_columns_id' // Section           
        );      

        add_settings_section(
            'setting_user_columns_id', // ID
            'Disable User Columns', // Title
            array( $this, 'print_user_section_info' ), // Callback
            'mondos-columns-setting-admin' // Page
        );  

        add_settings_field(
            'mondos_user_name', // ID
            'Disable Name Column', // Title 
            array( $this, 'mondos_user_name_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_user_columns_id' // Section           
        );      

        add_settings_field(
            'mondos_user_email', // ID
            'Disable E-mail Column', // Title 
            array( $this, 'mondos_user_email_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_user_columns_id' // Section           
        );

        add_settings_field(
            'mondos_user_role', // ID
            'Disable Role Column', // Title 
            array( $this, 'mondos_user_role_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_user_columns_id' // Section           
        );      

        add_settings_field(
            'mondos_user_posts', // ID
            'Disable Posts Column', // Title 
            array( $this, 'mondos_user_posts_callback' ), // Callback
            'mondos-columns-setting-admin', // Page
            'setting_user_columns_id' // Section           
        );      


    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['mondos_post_author'] ) )
            $new_input['mondos_post_author'] = (bool)strip_tags( $input['mondos_post_author'] );

        if( isset( $input['mondos_post_categories'] ) )
            $new_input['mondos_post_categories'] = (bool)strip_tags( $input['mondos_post_categories'] );

        if( isset( $input['mondos_post_tags'] ) )
            $new_input['mondos_post_tags'] = (bool)strip_tags( $input['mondos_post_tags'] );

        if( isset( $input['mondos_post_comments'] ) )
            $new_input['mondos_post_comments'] = (bool)strip_tags( $input['mondos_post_comments'] );

        if( isset( $input['mondos_post_date'] ) )
            $new_input['mondos_post_date'] = (bool)strip_tags( $input['mondos_post_date'] );

        if( isset( $input['mondos_page_author'] ) )
            $new_input['mondos_page_author'] = (bool)strip_tags( $input['mondos_page_author'] );

        if( isset( $input['mondos_page_comments'] ) )
            $new_input['mondos_page_comments'] = (bool)strip_tags( $input['mondos_page_comments'] );

        if( isset( $input['mondos_page_date'] ) )
            $new_input['mondos_page_date'] = (bool)strip_tags( $input['mondos_page_date'] );

        if( isset( $input['mondos_user_name'] ) )
            $new_input['mondos_user_name'] = (bool)strip_tags( $input['mondos_user_name'] );

        if( isset( $input['mondos_user_email'] ) )
            $new_input['mondos_user_email'] = (bool)strip_tags( $input['mondos_user_email'] );

        if( isset( $input['mondos_user_role'] ) )
            $new_input['mondos_user_role'] = (bool)strip_tags( $input['mondos_user_role'] );

        if( isset( $input['mondos_user_posts'] ) )
            $new_input['mondos_user_posts'] = (bool)strip_tags( $input['mondos_user_posts'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_post_section_info()
    {
        print '<p class="description">Manage all core post columns:</p>';
    }
	
    /** 
     * Print the Section text
     */
    public function print_page_section_info()
    {
        print '<p class="description">Manage all core page columns:</p>';
    }
	
    /** 
     * Print the Section text
     */
    public function print_user_section_info()
    {
        print '<p class="description">Manage all core user columns:</p>';
    }
	
    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_post_author_callback()
    {
	    if (isset($this->options['mondos_post_author'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_post_author]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Posts Author column when viewing all Posts.</p>
        <?php 
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_post_categories_callback()
    {
 	    if (isset($this->options['mondos_post_categories'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
       ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_post_categories]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Posts Categories column when viewing all Posts.</p>
        <?php

    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_post_tags_callback()
    {
 	    if (isset($this->options['mondos_post_tags'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_post_tags]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Posts Tags column when viewing all Posts.</p>
        <?php

    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_post_comments_callback()
    {
 	    if (isset($this->options['mondos_post_comments'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_post_comments]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Posts Comments column when viewing all Posts.</p>
        <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_post_date_callback()
    {
 	    if (isset($this->options['mondos_post_date'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_post_date]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Posts Dates column when viewing all Posts.</p>
        <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_page_author_callback()
    {
 	    if (isset($this->options['mondos_page_author'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_page_author]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Pages Author column when viewing all Pages.</p>
        <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_page_comments_callback()
    {
 	    if (isset($this->options['mondos_page_comments'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_page_comments]" value="1" <?php checked( $checked, 1 ); ?> />
         <p class="description">The Pages Comments column when viewing all Pages.</p>
       <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_page_date_callback()
    {
 	    if (isset($this->options['mondos_page_date'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_page_date]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Pages Date column when viewing all Pages.</p>
        <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_user_name_callback()
    {
 	    if (isset($this->options['mondos_user_name'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_user_name]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Users Name column when viewing all Users.</p>
        <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_user_email_callback()
    {
 	    if (isset($this->options['mondos_user_email'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_user_email]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Users Email column when viewing all Users.</p>
        <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_user_role_callback()
    {
 	    if (isset($this->options['mondos_user_role'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_user_role]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Users Role column when viewing all Users.</p>
        <?php
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function mondos_user_posts_callback()
    {
 	    if (isset($this->options['mondos_user_posts'])) {
		    $checked = 1;
	    } else {
		    $checked = null;
	    }
        ?>
        <input type="checkbox" name="mondos_posts_columns_options[mondos_user_posts]" value="1" <?php checked( $checked, 1 ); ?> />
        <p class="description">The Users Posts column when viewing all Users.</p>
        <?php
    }

	public function mondos_managed_columns( $columns ) {
		$this->options = get_option( 'mondos_posts_columns_options' );
		$unset_columns = (array)$this->options;

		if (isset($unset_columns['mondos_post_author'])) {
			unset($columns['author']);
		}
		if (isset($unset_columns['mondos_post_categories'])) {
			unset($columns['categories']);
		}
		if (isset($unset_columns['mondos_post_tags'])) {
			unset($columns['tags']);
		}
		if (isset($unset_columns['mondos_post_comments'])) {
			unset($columns['comments']);
		}
		if (isset($unset_columns['mondos_post_date'])) {
			unset($columns['date']);
		}
		//xdebug_break();
		return $columns;
	}

	public function mondos_managed_page_columns( $columns ) {
		$this->options = get_option( 'mondos_posts_columns_options' );
		$unset_columns = (array)$this->options;

		if (isset($unset_columns['mondos_page_author'])) {
			unset($columns['author']);
		}
		if (isset($unset_columns['mondos_page_comments'])) {
			unset($columns['comments']);
		}
		if (isset($unset_columns['mondos_page_date'])) {
			unset($columns['date']);
		}
		//xdebug_break();
		return $columns;
	}

	public function mondos_managed_user_columns( $columns ) {
		$this->options = get_option( 'mondos_posts_columns_options' );
		$unset_columns = (array)$this->options;

		if (isset($unset_columns['mondos_user_name'])) {
			unset($columns['name']);
		}
		if (isset($unset_columns['mondos_user_email'])) {
			unset($columns['email']);
		}
		if (isset($unset_columns['mondos_user_role'])) {
			unset($columns['role']);
		}
		if (isset($unset_columns['mondos_user_posts'])) {
			unset($columns['posts']);
		}
		//xdebug_break();
		return $columns;
	}
    
    
}
