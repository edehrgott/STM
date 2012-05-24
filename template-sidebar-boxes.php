<?php
/*
Template Name: Page w/ Sidebar Boxes
*/
?>

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
                     <?php echo $greenboxtitle; ?>
			   </td>
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
	   if( is_front_page() ) {  // for home page only show testimonials ?>
		<table  class="sidebarbox">
		   <tr>
			 <td class="brown_table_head">
			 Gratitudes
			 </td>
		   </tr>
		   <tr>
			 <td class="sidebarcontent">
			 <?php collision_testimonials(); ?>
			 <a href="/gratitudes/">More Gratitudes</a></td>
		   </tr>
		</table>		
		<br />
	   <?php } else {
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
	   }
         endwhile; else: ?>
	   <p><?php _e('Sorry, no posts matched your criteria.', 'tpSunrise'); ?></p><?php endif; ?>
         </div> <!-- right col -->
	   
	   <div id="page_content">
	   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	   <h1><?php the_title(); ?></h1>
	   <?php if( is_front_page() ) {  // for home page only first show section graphics ?>
		<div id="relaxmenu">
		  <p align="center"><a href="/html/massage.html" id="clickable_inline" title="Relax your body"></a></p>
		  </div>	
		<div id="pleasuremenu">
		  <p align="center"><a href="/html/pleasure.html" id="clickable_inline" title="Reclaim your pleasure"></a></p>
		</div>
		<div id="passionmenu">
		  <p align="center"><a href="/html/passion.html" id="clickable_inline" title="Find your passion"></a></p>
		</div>
		<p align="center"><?php sfc_like_button(); ?></p>
	   <?php } ?>	   
	   <?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>
	   <?php the_content(__('Read more', 'tpSunrise'));?>
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
		  <span id="events">
		   <p class="center"><a href="/mindful-self-loving/"><img src="/images/msl_banner.jpg" width="475" height="100" alt="Next Mindful Self Loving" style="border-width: 0px;" /></a></p>
               <?php
			$options = array('scope' => 'upcoming', 'artist' => 1, 'limit' => 5, 'show_feeds' => 'no');
			  echo "<span class=\"center\">";
			  echo "<span class=\"widget widget_gigpress\">" . gigpress_sidebar($options) . "</span>";
			  echo "</span>";
		   ?>
		  </span>
		   <div id="recent_posts">
		   <h2><a href="/my-blog/">Recent Blog Posts</a></h2>
		   <?php $args = array( 'numberposts' => 4 );
		   global $post;
		   $recent_posts_array = get_posts( $args );
		   foreach( $recent_posts_array as $post ) : setup_postdata($post); ?>
			<li class="recent_posts_item"><a href="<?php the_permalink(); ?>" class="recent_posts_title"><?php the_title(); ?></a><br />
			<div id="recent_posts_meta">
			   <p>Posted by <?php the_author(); ?> on <?php the_time('F j, Y'); ?><br />
			</div>
			<?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>			
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>">Read The Full Post</a>
		   <?php endforeach; ?>
		   </div>
		
		<?php } ?>
	   
	   </div> <!-- page content -->
         
	   </div> <!-- container -->
	   
	   <?php if( is_front_page() ) {  // for home page only - script to control clickable image resizing ?>	
		<script type="text/javascript">
		jQuery(document).ready(function() {
	     
		function imageresize() {
		   var contentwidth = jQuery('#page_content').width();
		   if ((contentwidth) < '660'){ // little window
			jQuery('#relaxmenu a').css({
			   'height': '150px',
			   'width': '475px',
			   'background': 'url(/images/body_button_sm.jpg) 0 0 no-repeat'
			});
			jQuery('#pleasuremenu a').css({
			   'height': '150px',
			   'width': '475px',
			   'background': 'url(/images/pleasure_button_sm.jpg) 0 0 no-repeat'
			});
			jQuery('#passionmenu a').css({
			   'height': '150px',
			   'width': '475px',
			   'background': 'url(/images/passion_button_sm.jpg) 0 0 no-repeat'
			});
			// handle hovers - adjust sliding windows
			jQuery('#relaxmenu a').mouseenter(function(){
			   jQuery(this).css('background-position', '0px -150px');
			}).mouseleave(function(){
			   jQuery(this).css('background-position', '0 0');
			});
			jQuery('#pleasuremenu a').mouseenter(function(){
			   jQuery(this).css('background-position', '0px -150px');
			}).mouseleave(function(){
			   jQuery(this).css('background-position', '0 0');
			});
			jQuery('#passionmenu a').mouseenter(function(){
			   jQuery(this).css('background-position', '0px -150px');
			}).mouseleave(function(){
			   jQuery(this).css('background-position', '0 0');
			});			
			
		   } else { // big window
			jQuery('#relaxmenu a').css({
			   'height': '200px',
			   'width': '633px',
			   'background': 'url(/images/body_button.jpg) 0 0 no-repeat'
			});
			jQuery('#pleasuremenu a').css({
			   'height': '200px',
			   'width': '633px',
			   'background': 'url(/images/pleasure_button.jpg) 0 0 no-repeat'
			});
			jQuery('#passionmenu a').css({
			   'height': '200px',
			   'width': '633px',
			   'background': 'url(/images/passion_button.jpg) 0 0 no-repeat'
			});
			// handle hovers - adjust sliding windows
			jQuery('#relaxmenu a').mouseenter(function(){
			   jQuery(this).css('background-position', '0px -200px');
			}).mouseleave(function(){
			   jQuery(this).css('background-position', '0 0');
			});
			jQuery('#pleasuremenu a').mouseenter(function(){
			   jQuery(this).css('background-position', '0px -200px');
			}).mouseleave(function(){
			   jQuery(this).css('background-position', '0 0');
			});
			jQuery('#passionmenu a').mouseenter(function(){
			   jQuery(this).css('background-position', '0px -200px');
			}).mouseleave(function(){
			   jQuery(this).css('background-position', '0 0');
			});
			
		   }
            };
		  
		imageresize(); // triggers when document first loads    
		jQuery(window).bind("resize", function(){ // when browser resized
		   imageresize();
		});
		
		});
		</script>
	   <?php } 
	   
	   get_footer(); ?>