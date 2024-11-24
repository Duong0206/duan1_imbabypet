<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Website'; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- Nội dung chính -->
    <?= $content; ?>
    
    <!-- Include JS -->
    <script src="/assets/js/script.js"></script>
</body>
</html>