<?php

require_once('/Applications/MAMP/htdocs/wordpress/wp-config.php'); // TODO: Fix this path on a real server
require_once('dropbox.php');
if( $_POST[ "wp_db_submit_hidden" ] == 'Y' ) {
                // Check if we should ask Dropbox api for a token for the given user
                if ( trim($_POST[ 'wp_db_password' ]) != '') {
                        $updateAuth = True;
                }
                $db_error = False;
                
                if ( $updateAuth ) {
                        $dbupf = make_dropbox_api($_POST[ 'dbapikey' ],$_POST[ 'dbapisecret' ]);
//
//				if ( empty( $dbapistuff["error"] ) ) {
//					update_option( 'db_auth_token', $dbapistuff["token"] );
//        			update_option( 'db_auth_token_secret', $dbapistuff["secret"] );
//				}
//				else {
//					?>
						<div class="updated"><p><strong><?php echo $dbapistuff["error"]; ?></strong></p></div>							
					<?php
//					$db_error = True;
//				}
                }
                
        // Save the posted value in the database
        update_option( 'db_username', $_POST[ 'wp_db_username' ] );
        update_option( 'db_path', $_POST[ 'db_path' ] );
        update_option( 'db_temp_path', $_POST[ 'db_temp_path' ] );
        update_option( 'db_allow_ext', $_POST[ 'db_allow_ext' ] );
        update_option( 'db_key', $_POST[ 'dbapikey' ] );
        update_option( 'db_secret', $_POST[ 'dbapisecret' ] );
?>		        <div class="updated"><p><strong> Authorization Complete</strong></p></div>
<?php		if (!$db_error) {
?>
        <div class="updated"><p><strong><?php _e('Options saved. Dropbox connection is okay, no need to update your password again.', 'mt_trans_domain' ); ?></strong></p></div>
<?php
}
    }
        
?>