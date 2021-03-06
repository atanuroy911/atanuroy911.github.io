<?php
/**
 * Embed Any Document Plus Settings Template.
 *
 * @package embed-any-document-plus
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<div class="ead-title-wrap">
		<h1><?php esc_html_e( 'Embed Any Document by AWSM.in', 'embed-any-document-plus' ); ?></h1>
	</div>
	<?php
	/**
	 * Customize the settings tabs.
	 *
	 * @since 2.4.0
	 *
	 * @param array $settings_tabs Settings tabs.
	 */
	$settings_tabs = apply_filters( 'awsm_ead_settings_tabs', array( 'general', 'cloud', 'updates' ) );

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$settings_tab = isset( $_GET['tab'] ) ? sanitize_title( $_GET['tab'] ) : 'general';
	if ( ! in_array( $settings_tab, $settings_tabs, true ) ) {
		$settings_tab = 'general';
	}
	?>
	<div class="nav-tab-wrapper">
		<?php
			/**
			 * Hook: before_awsm_ead_settings_main_tabs.
			 *
			 * @since 2.4.0
			 *
			 * @param string $settings_tab Current setting tab.
			 */
			do_action( 'before_awsm_ead_settings_main_tabs', $settings_tab );
		?>
		<a class="nav-tab<?php echo esc_attr( $this->getactive_menu( $settings_tab, 'general' ) ); ?>" href="<?php echo esc_url( 'options-general.php?page=' . $this->settings_slug . '&tab=general' ); ?>" data-tab="general">
			<?php esc_html_e( 'General Settings', 'embed-any-document-plus' ); ?>
		</a>
		<a class="nav-tab<?php echo esc_attr( $this->getactive_menu( $settings_tab, 'cloud' ) ); ?>" href="<?php echo esc_url( 'options-general.php?page=' . $this->settings_slug . '&tab=cloud' ); ?>" data-tab="ead-cloud">
			<?php esc_html_e( 'Cloud Settings', 'embed-any-document-plus' ); ?>
		</a>
		<?php
			/**
			 * Hook: after_awsm_ead_settings_main_tabs.
			 *
			 * @since 2.4.0
			 *
			 * @param string $settings_tab Current setting tab.
			 */
			do_action( 'after_awsm_ead_settings_main_tabs', $settings_tab );
		?>

		<a class="nav-tab<?php echo esc_attr( $this->getactive_menu( $settings_tab, 'updates' ) ); ?>" href="<?php echo esc_url( 'options-general.php?page=' . $this->settings_slug . '&tab=updates' ); ?>" data-tab="ead-cloud">
			<?php esc_html_e( 'License', 'embed-any-document-plus' ); ?>
		</a>
	</div>
	<div class="row clearfix">
		<div class="ead-left-wrap">
			<div class="ead-tabs">
				<?php
					/**
					 * Hook: before_awsm_ead_settings_tab_content.
					 *
					 * @since 2.4.0
					 *
					 * @param string $settings_tab Current setting tab.
					 */
					do_action( 'before_awsm_ead_settings_tab_content', $settings_tab );
				?>
				<?php if ( $settings_tab === 'general' ) : ?>
				<form method="post" action="options.php">
					<?php settings_fields( 'ead-settings-group' ); ?>
					<table class="form-table">
						<?php
							/**
							 * Hook: before_awsm_ead_general_settings.
							 *
							 * @since 2.4.0
							 */
							do_action( 'before_awsm_ead_general_settings' );
						?>
						<tr valign="top">
							<th scope="row">
								<?php esc_html_e( 'Default size', 'embed-any-document-plus' ); ?>
							</th>
							<td>
								<div class="f-left ead-frame-width">
									<?php esc_html_e( 'Width', 'embed-any-document-plus' ); ?>
									<input type="text" class="small" name="ead_width" value="<?php echo esc_attr( get_option( 'ead_width', '100%' ) ); ?>" />
								</div>
								<div class="f-left ead-frame-height">
									<?php esc_html_e( 'Height', 'embed-any-document-plus' ); ?>
									<input type="text" class="small" name="ead_height" value="<?php echo esc_attr( get_option( 'ead_height', '500px' ) ); ?>" />
								</div>
								<div class="clear"></div>
								<span class="note"><?php esc_html_e( 'Enter values in pixels or percentage (Example: 500px or 100%)', 'embed-any-document-plus' ); ?></span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php esc_html_e( 'Show download link', 'embed-any-document-plus' ); ?>
							</th>
							<td>
								<?php
								$downoptions = array(
									'all'    => __( 'For all users', 'embed-any-document-plus' ),
									'logged' => __( 'For Logged-in users', 'embed-any-document-plus' ),
									'none'   => __( 'No Download', 'embed-any-document-plus' ),
								);
								$this->selectbuilder( 'ead_download', $downoptions, esc_attr( get_option( 'ead_download', 'none' ) ) );
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php esc_html_e( 'Download text', 'embed-any-document-plus' ); ?>
							</th>
							<td>
								<input type="text" class="" name="ead_text" value="<?php echo esc_attr( get_option( 'ead_text', 'Download' ) ); ?>" />
							</td>
						</tr>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php esc_html_e( 'Show file size', 'embed-any-document-plus' ); ?>
							</th>
							<td>
							<?php
							$downoptions = array(
								'yes' => __( 'Yes', 'embed-any-document-plus' ),
								'no'  => __( 'No', 'embed-any-document-plus' ),
							);
							$this->selectbuilder( 'ead_filesize', $downoptions, esc_attr( get_option( 'ead_filesize', 'yes' ) ) );
							?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php esc_html_e( 'Google Picker view', 'embed-any-document-plus' ); ?>
							</th>
							<td>
								<?php
									$gpicker_view = get_option( 'ead_gpicker_view', 'file' );
								?>
								<ul class="ead-list-inline">
									<li>
										<label for="ead_gpicker_file_view">
											<input type="radio" name="ead_gpicker_view" id="ead_gpicker_file_view" value="file"<?php checked( $gpicker_view, 'file' ); ?>><?php esc_html_e( 'File view', 'embed-any-document-plus' ); ?>
										</label>
									</li>
									<li>
										<label for="ead_gpicker_folder_view">
											<input type="radio" name="ead_gpicker_view" id="ead_gpicker_folder_view" value="folder"<?php checked( $gpicker_view, 'folder' ); ?>><?php esc_html_e( 'Folder view', 'embed-any-document-plus' ); ?>
										</label>
									</li>
								</ul>
								<span class="note"><?php esc_html_e( 'Select default view for your Google Drive Picker interface', 'embed-any-document-plus' ); ?></span>
							</td>
						</tr>
						<?php
							/**
							 * Hook: after_awsm_ead_general_settings.
							 *
							 * @since 2.4.0
							 */
							do_action( 'after_awsm_ead_general_settings' );
						?>
					</table>
					<div class="ead-form-footer">
						<?php submit_button(); ?>
					</div>
				</form>
				<?php endif; ?>
				<?php if ( $settings_tab === 'cloud' ) : ?>
				<form method="post" action="options.php">
					<?php settings_fields( 'ead-cloud-group' ); ?>
					<div class="form-table">
						<ul class="cloudform">
							<?php
								/**
								 * Hook: before_awsm_ead_cloud_settings.
								 *
								 * @since 2.4.0
								 */
								do_action( 'before_awsm_ead_cloud_settings' );
							?>
							<li>
								<div class="ead-cloud ead-service">
									<img width="40" src="<?php echo esc_url( $this->plugin_url ); ?>images/icon-dropbox.png"><span><?php esc_html_e( 'Dropbox', 'embed-any-document-plus' ); ?></span>
								</div>
								<div class="ead-cloud ead-setup">
									<div class="ead-inputholder">
										<label>
											<?php esc_html_e( 'API Key', 'embed-any-document-plus' ); ?>
										</label>
										<input type="text" name="ead_dropbox" value="<?php echo esc_attr( get_option( 'ead_dropbox' ) ); ?>" />
									</div>
								</div>
								<div class="ead-cloud ead-config">
									<ol>
										<li>
											<a href="https://www.dropbox.com/developers/apps/create?app_type_checked=dropins" target="_blank">
												<?php esc_html_e( 'Obtain API key', 'embed-any-document-plus' ); ?>
											</a>
										</li>
										<li>
											<a href="http://awsm.in/ead-plus-documentation/#dropboxapi" target="_blank">
												<?php esc_html_e( 'How to do it ?', 'embed-any-document-plus' ); ?>
											</a>
										</li>
									</ol>
								</div>
							</li>
							<li>
								<div class="ead-cloud ead-service">
									<img width="40" src="<?php echo esc_url( $this->plugin_url ); ?>images/icon-drive.png"><span><?php esc_html_e( 'Google Drive', 'embed-any-document-plus' ); ?></span>
								</div>
								<div class="ead-cloud ead-setup">
									<div class="ead-inputholder">
										<label>
											<?php esc_html_e( 'Client ID', 'embed-any-document-plus' ); ?>
										</label>
										<input type="text" name="ead_driveClient" value="<?php echo esc_attr( get_option( 'ead_driveClient' ) ); ?>" />
									</div>
									<div class="ead-inputholder">
										<label>
											<?php esc_html_e( 'API Key', 'embed-any-document-plus' ); ?>
										</label>
										<input type="text" name="ead_drivekey" value="<?php echo esc_attr( get_option( 'ead_drivekey' ) ); ?>" />
									</div>
								</div>
								<div class="ead-cloud ead-config">
									<ol>
										<li>
											<a href="https://console.developers.google.com/project" target="_blank">
												<?php esc_html_e( 'Obtain Client ID and API Key', 'embed-any-document-plus' ); ?>
											</a>
										</li>
										<li>
											<a href="http://awsm.in/ead-plus-documentation/#driveapi" target="_blank">
												<?php esc_html_e( 'How to do it ?', 'embed-any-document-plus' ); ?>
											</a>
										</li>
									</ol>
								</div>
							</li>
							<li>
								<div class="ead-cloud ead-service">
									<img width="60" src="<?php echo esc_url( $this->plugin_url ); ?>images/icon-box.png"><span><?php esc_html_e( 'Box.com', 'embed-any-document-plus' ); ?></span>
								</div>
								<div class="ead-cloud ead-setup">
									<div class="ead-inputholder">
										<label>
											<?php esc_html_e( 'API Key', 'embed-any-document-plus' ); ?>
										</label>
										<input type="text" name="ead_box" value="<?php echo esc_attr( get_option( 'ead_box' ) ); ?>" />
									</div>
								</div>
								<div class="ead-cloud ead-config">
									<ol>
										<li>
											<a href="https://app.box.com/developers/services/edit/" target="_blank">
												<?php esc_html_e( 'Obtain API key', 'embed-any-document-plus' ); ?>
											</a>
										</li>
										<li>
											<a href="http://awsm.in/ead-plus-documentation/#boxapi" target="_blank">
												<?php esc_html_e( 'How to do it ?', 'embed-any-document-plus' ); ?>
											</a>
										</li>
									</ol>
								</div>
							</li>
							<?php
								/**
								 * Hook: after_awsm_ead_cloud_settings.
								 *
								 * @since 2.4.0
								 */
								do_action( 'after_awsm_ead_cloud_settings' );
							?>
						</ul>
					</div>
					<div class="ead-form-footer">
						<?php submit_button(); ?>
					</div>
				</form>
				<?php endif; ?>
				<?php if ( $settings_tab === 'updates' ) : ?>
					<form method="post" action="options.php">
						<?php settings_fields( 'ead-settings-envato' ); ?>
						<div class="form-table">
							<ul class="cloudform purchase-key">
								<li>
									<div class="ead-cloud ead-service">
										<img width="40" src="<?php echo esc_url( $this->plugin_url ); ?>images/icon-envato.png"><span><?php esc_html_e( 'envato', 'embed-any-document-plus' ); ?></span>
									</div>
									<div class="ead-cloud ead-setup">
										<div class="ead-inputholder">
											<label>
												<?php esc_html_e( 'Envato purchase key', 'embed-any-document-plus' ); ?>
											</label>
											<input type="text" class="" name="ead_envato_key" value="<?php echo esc_attr( get_option( 'ead_envato_key' ) ); ?>" />
										</div>
									</div>
									<div class="ead-cloud ead-config">
										<ol>
											<li>
												<a href="https://codecanyon.net/downloads" target="_blank">
													<?php esc_html_e( 'Obtain purchase key', 'embed-any-document-plus' ); ?>
												</a>
											</li>
											<li>
												<a href="https://goo.gl/BF6Jk6" target="_blank">
													<?php esc_html_e( 'How to get it ?', 'embed-any-document-plus' ); ?>
												</a>
											</li>
										</ol>
									</div>
								</li>
							</ul>
						</div>
						<div class="ead-form-footer">
							<?php submit_button(); ?>
						</div>
					</form>
				<?php endif; ?>
				<?php
					/**
					 * Hook: after_awsm_ead_settings_tab_content.
					 *
					 * @since 2.4.0
					 *
					 * @param string $settings_tab Current setting tab.
					 */
					do_action( 'after_awsm_ead_settings_tab_content', $settings_tab );
				?>
			</div>
		</div>
		<!-- .ead-left-wrap -->
		<div class="ead-right-wrap">
			<div class="ead-right-widget we-are-awsm">
				<div class="awsm-branding">
					<img src="<?php echo esc_url( $this->plugin_url ); ?>/images/awsm-logo.png" width="67" height="67" alt="AWSM Innovations">
					<div class="left-clear">
						<h2><?php esc_html_e( 'Designed and developed by', 'embed-any-document-plus' ); ?></h2>
						<h3><a href="http://awsm.in/" target="_blank" title="awsm innovations">awsm innovations</a></h3>
						<ul class="awsm-social">
							<li><a href="https://www.facebook.com/awsminnovations" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-facebook"><?php esc_html_e( 'Facebook', 'embed-any-document-plus' ); ?></span></a></li>
							<li><a href="https://twitter.com/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-twitter"><?php esc_html_e( 'Twitter', 'embed-any-document-plus' ); ?></span></a></li>
							<li><a href="https://github.com/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-github"><?php esc_html_e( 'Github', 'embed-any-document-plus' ); ?></span></a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- .ead-right-inner -->
			<div class="clearfix row-2 ead-right-widget">
				<div class="col-2">
					<a href="http://goo.gl/wJTQlc" target="_blank">
			   <img src="<?php echo esc_url( $this->plugin_url ); ?>images/star.gif"><?php esc_html_e( 'Like the plugin?', 'embed-any-document-plus' ); ?><br/><?php esc_html_e( 'Rate Now!', 'embed-any-document-plus' ); ?>
			   </a>
				</div>
				<!-- .col-2 -->
				<div class="col-2">
					<a href="http://awsm.in/support" target="_blank">
			   <img src="<?php echo esc_url( $this->plugin_url ); ?>images/ticket.gif"><?php esc_html_e( 'Need Help?', 'embed-any-document-plus' ); ?><br/><?php esc_html_e( 'Open a Ticket', 'embed-any-document-plus' ); ?>
			   </a>
				</div>
				<!-- .col-2 -->
			</div>
			<!-- .row -->
			<div class="ead-right-inner">
				<h3><?php esc_html_e( 'Quick Help', 'embed-any-document-plus' ); ?></h3>
				<ol>
					<li>
						<a href="http://awsm.in/ead-plus-documentation/#embedding" target="_blank" title="<?php esc_html_e( 'How to Embed Documents?', 'embed-any-document-plus' ); ?>">
							<?php esc_html_e( 'How to Embed Documents?', 'embed-any-document-plus' ); ?>
						</a>
					</li>
					<li>
						<a href="http://awsm.in/ead-plus-documentation/#viewers" target="_blank" title="<?php esc_html_e( 'About Viewers', 'embed-any-document-plus' ); ?>">
							<?php esc_html_e( 'About Viewers', 'embed-any-document-plus' ); ?>
						</a>
					</li>
					<li>
						<a href="http://awsm.in/ead-plus-documentation/#shortcode" target="_blank" title="<?php esc_html_e( 'Shortcode & Attributes', 'embed-any-document-plus' ); ?>">
							<?php esc_html_e( 'Shortcode & Attributes', 'embed-any-document-plus' ); ?>
						</a>
					</li>
					<li>
						<a href="http://awsm.in/support" target="_blank" title="<?php esc_html_e( 'FAQs', 'embed-any-document-plus' ); ?>">
							<?php esc_html_e( 'FAQs', 'embed-any-document-plus' ); ?>
						</a>
					</li>
				</ol>
			</div>
			<!-- .ead-right-inner -->
		</div>
		<!-- .ead-right-wrap -->
	</div>
	<!-- .row -->
</div>
<!-- .wrap -->
