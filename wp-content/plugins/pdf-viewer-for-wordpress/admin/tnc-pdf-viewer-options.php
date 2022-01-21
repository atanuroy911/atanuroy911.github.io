<?php
add_action( 'admin_menu', 'tnc_pdf_menu' );
function tnc_pdf_menu() {
    add_submenu_page( 'edit.php?post_type=pdfviewer', 'Import PDF File - PDF Viewer for WordPress', 'Import PDF File', 'upload_files', 'themencode-pdf-viewer-import-file', 'tnc_import_pdf_file', 4);
    add_submenu_page( 'edit.php?post_type=pdfviewer', 'Activation & Updates', 'Activation & Updates', 'manage_options', 'themencode-pdf-viewer-updates', 'tnc_pdf_viewer_updates', 5);
    add_submenu_page( 'edit.php?post_type=pdfviewer', 'Migrate Settings', 'Migrate Settings', 'manage_options', 'themencode-pdf-viewer-migrate-settings', 'tnc_pdf_viewer_migrate_settings', 6);
}

function tnc_import_pdf_file(){
    if ( !current_user_can( 'upload_files' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    include dirname(__FILE__)."/import-pdf-file.php";
}
function tnc_pdf_viewer_updates(){
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    include dirname(__FILE__)."/update-registration.php";
}

function tnc_pdf_viewer_migrate_settings(){
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    include dirname(__FILE__)."/migrate-settings.php";
}