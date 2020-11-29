<?php
/*
 * This is the Navbar file, this will be your navbar
 * for the whole site, updating this file will change
 * the navbar for all pages
 */

/*
 ===============
 This function adds the "currentNavItem"
 to the approprirate page ID, ensuring the active
 page is displayed on the navigation bar ie. has the green colour
 ===============
 */
function isCurrent($pageName){
	global $NAV_PAGE;
	//If the global matches the argument set as current
	if ($NAV_PAGE == $pageName){
		echo "activeNavLink";
	}
}

//Function to display Screenreader info
function isCurrentSR($pageName){
	global $NAV_PAGE;
	//If the global matches the argument set as current
	if ($NAV_PAGE == $pageName){
		echo "<span class=\"sr-only\">(current)</span>";
	}
}


?>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/">
      <img src="/assets/images/core/logo.svg" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="passNav">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="passNav" class="navbar-menu">
    <div class="navbar-start">
      <!--Generate password-->
      <a class="navbar-item <?isCurrent("index")?>" href="/">
        Generate
      </a>
      <!--View common passwords-->
      <a class="navbar-item <?isCurrent("common")?>" href="/common">
        Common Passwords
      </a>
      <!--About page-->
      <a class="navbar-item <?isCurrent("about")?>" href="/about">
        About
      </a>
    </div>

  </div>
</nav>

