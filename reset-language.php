<?php
// Temporary script to reset language preference to Portuguese
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Reset Language</title>
</head>
<body>
    <h1>Resetting Language to Portuguese...</h1>
    <script>
        // Clear any existing language preference
        localStorage.removeItem('selected-language');
        
        // Set to Portuguese
        localStorage.setItem('selected-language', 'pt-BR');
        
        // Redirect back to main page
        window.location.href = '/projects/ip-tools/index.php';
    </script>
</body>
</html> 