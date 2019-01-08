<?php
if (isset($_COOKIE["WIpa"])) {
  get_template_part('content', 'pro');
} else {
  get_template_part('content', 'login');
}
?>