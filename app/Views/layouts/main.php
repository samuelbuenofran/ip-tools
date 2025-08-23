<!DOCTYPE html>
<html lang="<?= $current_lang ?? 'pt-BR' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_title ?? 'IP Tools Suite' ?></title>
    <meta name="description" content="<?= $page_description ?? 'Professional-grade tools for geolocation tracking, network analysis, and digital forensics.' ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/projects/ip-tools/assets/favico.svg">
    <link rel="alternate icon" href="/projects/ip-tools/assets/favico.svg">
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/projects/ip-tools/assets/themes.css" rel="stylesheet">
    <link href="/projects/ip-tools/assets/navbar-fixes.css" rel="stylesheet">
    <link href="/projects/ip-tools/assets/dropdown-simple-fix.css" rel="stylesheet">
    
    <!-- Page-specific CSS -->
    <?php if (isset($page_css)): ?>
        <?= $page_css ?>
    <?php endif; ?>
    
    <!-- JavaScript Dependencies -->
    <script src="/projects/ip-tools/assets/theme-switcher.js" defer></script>
    <script src="/projects/ip-tools/assets/dropdown-simple-fix.js" defer></script>
    <script src="/projects/ip-tools/assets/translations.js" defer></script>
</head>
<body>
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../header.php'); ?>
    
    <!-- Main Content -->
    <main class="main-content">
        <?= $content ?? '' ?>
    </main>
    
    <!-- Footer -->
    <?php include(__DIR__ . '/../../footer.php'); ?>
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Page-specific JavaScript -->
    <?php if (isset($page_js)): ?>
        <?= $page_js ?>
    <?php endif; ?>
</body>
</html>
