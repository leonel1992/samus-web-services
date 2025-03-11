<!DOCTYPE html>
<html lang="<?= $GLOBALS['lang'] ?>">
    <head>
        <?php include __DIR__ . '/../layouts/webHeaderLayout.php'; ?>
    </head>
    <body module="<?= $GLOBALS['web-info']->module ?>" class="padding-top">
        <?php 
            include __DIR__ . '/../menus/sidebarMenu.php';
            include __DIR__ . '/../modals/sessionExpireModal.php';
            include __DIR__ . '/../layouts/webLoadingLayout.php'; 
            include __DIR__ . '/../layouts/webScriptsLayout.php'; 
        ?>
    </body>
</html>