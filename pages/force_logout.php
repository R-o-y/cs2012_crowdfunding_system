<?php 
unset($_SESSION['email']); 
echo '<p>You are inactive for 10 mins. Please <a href = "./?_page=login">login</a> again</p>';
?>