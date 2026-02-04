<?php
$current = basename($_SERVER['PHP_SELF'], '.php');
?>

<aside class="sidebar">
  <h2 class="logo">Student Portal</h2>

  <nav class="menu">
    <a href="/Student-Portal/dashboard/index.php">Dashboard</a>
	<a href="/Student-Portal/subjects/subject.php">Subjects</a>
	<a href="/Student-Portal/results/results.php">Results</a>
	<a href="/Student-Portal/profile/profile.php">Profile</a>
	<a href="/Student-Portal/certificates/certificates.php">Degrees</a>
	<a href="/Student-Portal/projects/projects.php">Projects</a>

<a href="/Student-Portal/auth/logout.php" class="logout">Logout</a>
  </nav>
</aside>