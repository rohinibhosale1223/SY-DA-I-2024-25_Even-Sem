<?php
session_start();
session_destroy();
echo "<script>
    alert('You have been logged out successfully.');
    window.location.href = 'home.php';
</script>";
exit();
?>
