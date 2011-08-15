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
		   <h2>Recent Blog Posts</h2>
		   <?php $args = array( 'numberposts' => 5 );
		   $recent_posts_array = get_posts( $args );
		   foreach( $recent_posts_array as $post ) :	setup_postdata($post); ?>
			   <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br />
			   <div id="recent_posts_meta">
				by <?php the_author(); ?>, posted on <?php the_time('l, F jS, Y'); ?> | <?php comments_number(__('No Comments', 'tpSunrise'), __('1 Comment', 'tpSunrise'), '% ' . __('Comments', 'tpSunrise'));?><br />
			   </div>
			   <?php the_excerpt(); ?>				
		   <?php endforeach; ?>
		   </div>
		   <br />			
		<?php } ?>
	   
	   </div> <!-- page content -->
         
	   </div> <!-- container -->
	   
	   <?php get_footer(); ?>