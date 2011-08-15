<?php
/*
Template Name: Eneagram Scoring
*/
?>

<?php get_header(); ?>

<div id="wrapper1">
   <div id="wrapper2">
	<div id="container">
	
	   <?php get_template_part( 'nav' ) ; // left column navigation ?>
	   
	   <?php get_sidebar(); ?> 
	   
	   <div id="page_content">	   
	   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	   <h1><?php the_title(); ?></h1>
	   <?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>

	   <h2>The Enneagram Type Indicator Sampler Results</h2>
	   RHETI Version 2.5<br />
	   Questionnaire Date <?php echo "$today" ?><br />
	   <p>The following numerical scores are calculated from your answers to the Sampler
	   questionnaire. If you have answered honestly and accurately, your basic
	   personality type should be <em>one of the top three scores</em>. (You might want to
	   print out this result; if you do not, you will have to retake the Sampler if
	   you want these scores later since they are not saved anywhere.) To confirm
	   which type you might be, read the short type descriptions below, in the
	   Riso-Hudson Enneagram books, or on their website at
	   <a target="_blank" href="http://www.enneagramInstitute.com">www.EnneagramInstitute.com</a>.</p>
	   <?php
	   //*** initialize variables
	   $i = 0;
	   $num_questions = 0;
	   $total_questions = 36;
	   $types = 9;
	   
	   // create mapping for answers
	   $mapping['A'] = 9;
	   $mapping['B'] = 6;
	   $mapping['C'] = 3;
	   $mapping['D'] = 1;
	   $mapping['E'] = 4;
	   $mapping['F'] = 2;
	   $mapping['G'] = 8;
	   $mapping['H'] = 5;
	   $mapping['I'] = 7;
	   
	   //ABCDEFGHI
	   for ($i = 1; $i <= $types; ++$i)
	   {
		 $alpha[$i] = 0;
	   }
	   
	   //go thru user's answers and calculate score
	   foreach ($HTTP_POST_VARS as $name => $val)
	   {
		   if(preg_match('/(\w)(\w)(\d+)/', $name, $char))
		   {
			if ($val == 0)
		   {
			   ++$alpha[$mapping[$char[1]]];
		   }
		   else
		   {
			   ++$alpha[$mapping[$char[2]]];
			}
			++$num_questions;
		}
	   }
	   
	   //warn if not all the questions are answered
	   if ($num_questions == $total_questions)
	   {
	     echo "<p>You have answered all the questions -- terrific!<p>";
	   }
	   else
	   {
	     echo "<p>You have answered <b>$num_questions</b> questions out of <b>$total_questions</b>.";
	     echo "For best results, you should answer all the questions that apply.<p>";
	   }
	   ?>
	   
	   <!-- output answer table -->
	   <center><table border="1" cellpadding="2">
	   <tr style="font-size: x-small">
	   <?php for ($i = 1; $i <= $types; ++$i)
		   {
			echo "<td>Type $i</td>";
		   }
	   ?>
	   </tr>
	   <tr>
	   <?php for ($i = 1; $i <=9; ++$i)
		   {
			   echo "<td>$alpha[$i]</td>";
		   }
	   ?>
	   </tr>
	   </table></center>
	   
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
	   
	   </div> <!-- page content -->
	   </div> <!-- container -->
	   
	   <?php get_footer(); ?>