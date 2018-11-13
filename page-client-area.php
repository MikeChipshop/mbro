<?php get_header(); ?>
<?php 
	$attachment_id = get_field('page_background');
	$size = "full";
	$image = wp_get_attachment_image_src( $attachment_id, $size );
?>
<section class="mb_client-page-signin" style="background:url('<?php echo $image[0] ?>') no-repeat center center; background-size:cover;">
	<div class="mb_signin-box">
		<h2>Sign in</h2>
		<form>
			<input type="text" value="Username or Email">
			<input type="password" value="password">
			<button>Sign In</button>
		</form>
		<div class="mb_signin-forgot"><a href="#">Forgot your password?</a></div>
	</div>
</section>
<?php get_footer(); ?>