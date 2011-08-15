<?php
/*
Template Name: Contact form page
*/
?>

<?php
if(isset($_POST['submitted'])) {
	if(trim($_POST['name']) === '') {
		$nameError = 'Please enter your name.';
		$hasError = true;
	} else {
		$name = trim($_POST['name']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['comments']) === '') {
		$commentError = 'Please enter a message.';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}

	if(!isset($hasError)) {
		$emailTo = get_option('tz_email');
		if (!isset($emailTo) || ($emailTo == '') ){
			$emailTo = get_option('admin_email');
		}
		$subject = '[Sacred Touch for Men] From '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}

} ?>

<?php get_header(); ?>

<div id="wrapper1">
   <div id="wrapper2">
	<div id="container">
	
	   <?php get_template_part( 'nav' ) ; // left column navigation ?>

	   <div id="right_col">
	   
		<?php get_search_form(); ?>
	   <br />
	   <?php if (have_posts()) : while (have_posts()) : the_post(); 
         // get postid to pass to sidebar for sidebar boxes
         global $wp_query;
         $post_id = $wp_query->post->ID;

         // get page sidebar bax custom field values
         $greenbox = get_post_meta($post_id, "greenbox", true);
		 $greenboxtitle = get_post_meta($post_id, "greenboxtitle", true);
         $yellowbox = get_post_meta($post_id, "yellowbox", true);
		 $yellowboxtitle = get_post_meta($post_id, "yellowboxtitle", true);
         $brownbox = get_post_meta($post_id, "brownbox", true);
	     $brownboxtitle = get_post_meta($post_id, "brownboxtitle", true);
         if ($greenbox) { ?>
		<table class="sidebarbox">
               <tr>
                  <td class="green_table_head">
                     <?php echo $greenboxtitle; ?></td>
               </tr>
               <tr>
                  <td class="sidebarcontent">
			   <?php echo $greenbox; ?>
                  </td>
               </tr>
            </table>
            <br />   
	   <?php }
         if ($yellowbox) { ?>
		<table class="sidebarbox">
               <tr>
                  <td class="yellow_table_head">
                     <?php echo $yellowboxtitle; ?></td>
               </tr>
               <tr>
                  <td class="sidebarcontent">
			   <?php echo $yellowbox; ?>
                  </td>
               </tr>
            </table>
            <br />   
	   <?php }
        if ($brownbox) { ?>
		<table class="sidebarbox">
               <tr>
                  <td class="brown_table_head">
                     <?php echo $brownboxtitle; ?></td>
               </tr>
               <tr>
                  <td class="sidebarcontent">
			   <?php echo $brownbox; ?>
                  </td>
               </tr>
            </table>
            <br />   
	   <?php }
         endwhile; else: ?>
	   <p><?php _e('Sorry, no posts matched your criteria.', 'tpSunrise'); ?></p><?php endif; ?>
         </div> <!-- right col -->
	   
	   <div id="page_content">
	   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	   <h1><?php the_title(); ?></h1>
	   <?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>
	   <?php the_content(__('Read more', 'tpSunrise'));?>
	
		<form name="comments" action="<?php the_permalink(); ?>" method="post">
		Your Name:<br />
		<input type="text" name="name" id="name" size="38" maxlength="50" /><br />
		Your Email:<br />
		<input type="text" name="email" id="email" size="38" maxlength="50" /><br />
		Your Phone:<br />
		<input type="text" name="phone" id="phone" size="18" maxlength="20" /><br />
		Preferred Date:<br />
		<script> jQuery(function() { jQuery( "#datepicker" ).datepicker(); }); </script>
		<input type="text" name="date" id="datepicker" size="18" maxlength="40" /><br />
		Preferred Time:<br />
		<input type="text" name="time" id="time" size="18" maxlength="40" /><br />
		Duration:<br />
		<select size="1" name="duration">
		<option value="60 minutes">60 minutes</option><option value="90 minutes">90 minutes</option><option value="2 hours">2 hours</option><option value="3 hours">3 hours</option><option>Coaching</option>
		</select><br />
		Comments:<br />
		<textarea name="comments" rows="10" cols="60"></textarea>
		<input type="hidden" name="submitted" id="submitted" value="true" />
		<script> jQuery(function() { jQuery( "button, input:submit, input:reset", ".stmbutton" ).button();  }); </script>
		<div class="stmbutton">
			<p class="center"><input name="submit" type="submit" value="Submit" />&nbsp;&nbsp;<input name="reset" type="reset" value="Reset" /></p></form>
		</div>

	   <!-- <?php trackback_rdf(); ?> -->
	   
        <div class="page-link">
            <?php wp_link_pages('before=<p>&after=</p>&next_or_number=number&pagelink=Page %'); ?>
        </div>

        <div class="edit-link">
            <?php edit_post_link( __('Edit', 'tpSunrise'), '<p>', '</p>' ); ?> 
        </div>

	   <?php endwhile; else: ?>
	   <p><?php _e('Sorry, no posts matched your criteria.', 'tpSunrise'); ?></p><?php endif; ?>
		  
	   <?php comments_template(); // Get wp-comments.php template ?>
	   
	   	<?php if( is_front_page() ) {  // for home page only do second loop to get 5 most recent post excerpts ?>
			<div id="recent_posts">
			<h2>Recent Blog Posts</h2>
			<?php $args = array( 'numberposts' => 5 );
			$recent_posts_array = get_posts( $args );
			foreach( $recent_posts_array as $post ) :	setup_postdata($post); ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br />
				<?php the_excerpt(); ?></li>
			<?php endforeach; ?>						
			</div>
		<?php } ?>
	   
	   </div> <!-- page content -->
         
	   </div> <!-- container -->
	   
	   <?php get_footer(); ?>