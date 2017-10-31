<?php
function  EWD_UFAQ_Submit_Question($success_message) {
	$Submit_Question_Captcha = get_option("EWD_UFAQ_Submit_Question_Captcha");
	$Admin_Question_Notification = get_option("EWD_UFAQ_Admin_Question_Notification");

	$Post_Title = sanitize_text_field($_POST['Post_Title']);
	$Post_Body = (isset($_POST['Post_Body']) ? sanitize_text_field($_POST['Post_Body']) : '');
	$Post_Author = sanitize_text_field($_POST['Post_Author']);

	if ($Submit_Question_Captcha == "Yes" and EWD_UFAQ_Validate_Captcha() != "Yes") {
		$user_message = __("Captcha number didn't match image.", 'ultimate-faqs'); 
		return $user_message;
	}

	$post = array(
		'post_content' => $Post_Body,
		'post_title' => $Post_Title,
		'post_type' => 'ufaq',
		'post_status' => 'draft' //Can create an option for admin approval of reviews here
	);
	$post_id = wp_insert_post($post);
	if ($post_id == 0) {$user_message = __("FAQ was not created succesfully.", 'ultimate-faqs'); return $user_message;}

	update_post_meta($post_id, "EWD_UFAQ_Post_Author", $Post_Author);

	if ($Admin_Question_Notification == "Yes") {
		EWD_UFAQ_Send_Admin_Notification_Email($post_id, $Post_Title, $Post_Body);
	}

	return $success_message;
}

function EWD_UFAQ_Send_Admin_Notification_Email($post_id, $Post_Title, $Post_Body) {
	if (get_option("EWD_UFAQ_Admin_Notification_Email") != "") {$Admin_Email = get_option("EWD_UFAQ_Admin_Notification_Email");}
	else {$Admin_Email = get_option( 'admin_email' );}

	$ReviewLink = site_url() . "/wp-admin/post.php?post=" . $post_id . "&action=edit";

	$Subject_Line = __("New Question Received", 'ultimate-faqs');

	$Message_Body = __("Hello Admin,", 'ultimate-faqs') . "<br/><br/>";
	$Message_Body .= __("You've received a new question titled", 'ultimate-faqs') . " '" . $Post_Title . "'.<br/><br/>";
	if ($Post_Body != "") {
		$Message_Body .= __("The answer reads:<br>", 'ultimate-faqs');
		$Message_Body .= $Post_Body . "<br><br><br>";
	}
	$Message_Body .= __("You can view the question in the admin area by going to the following link:<br>", 'ultimate-faqs');
	$Message_Body .= "<a href='" . $ReviewLink . "' />" . __("See the review", 'ultimate-faqs') . "</a><br/><br/>";
	$Message_Body .= __("Have a great day,", 'ultimate-faqs') . "<br/><br/>";
	$Message_Body .= __("Ultimate FAQs Team");

	$headers = array('Content-Type: text/html; charset=UTF-8');
	$Mail_Success = wp_mail($Admin_Email, $Subject_Line, $Message_Body, $headers);
}

?>
