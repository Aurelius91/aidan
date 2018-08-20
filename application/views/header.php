    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale = 1.0">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/images/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/images/favicon/favicon-16x16.png" sizes="16x16" />

    <meta name="description" content="<?= $metatag->description; ?>">
    <meta name="author" content="<?= $metatag->author; ?>">
    <meta name="keywords" content="<?= $metatag->keywords; ?>">

    <? if ($metatag->name  == ''): ?>
        <title>Aidan &amp; Ice - <?= $title; ?></title>
    <? else: ?>
        <title><?= $metatag->name; ?></title>
    <? endif; ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123154144-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-123154144-1');
    </script>

