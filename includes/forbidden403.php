<?
//Import the global functions
include_once dirname($_SERVER["DOCUMENT_ROOT"])."/core/global-functions.php";
//Import config file
include_once include_local_file("/includes/a_config.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
	<!-- Head tags -->
	<?php include_once include_local_file("/includes/head-tags.php"); ?>
</head>

<body>
	<!-- Navbar -->
	<?php include_once include_local_file("/includes/navbar.php"); ?>
	<!-- Top Section -->
	<section class="hero is-danger">
	  <div class="hero-body">
	    <div class="container has-text-centered">
	      <h1 class="title is-1">
	        Forbidden
	      </h1>
	    </div>
	  </div>
	</section>
	<div id="wrapper" class="has-text-centered mt-5">
		<h3 class="title is-3">403 - Access Denied</h3>
		<h2 class="subtitle is-6">You do not have permission to access this page</h2>
		<a href="/" class="button is-rounded is-primary">Home</a>
	</div>
	<!-- Footer -->
	<?php include_once include_local_file("/includes/footer.php"); ?>
</body>
</html>