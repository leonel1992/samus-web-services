<!DOCTYPE html>
<html lang="<?= $GLOBALS['lang'] ?>">
    <head>
        <?php include __DIR__ . '/../layouts/webHeaderLayout.php'; ?>
    </head>
    <body module="<?= $GLOBALS['web-info']->module ?>" class="panel-site">
        <?php 
            // include __DIR__ . '/../menus/sidebarMenu.php';
            echo "<div id='content'>{$GLOBALS['web-content']}</div>";
            include __DIR__ . '/../modals/sessionExpireModal.php';
            include __DIR__ . '/../layouts/webLoadingLayout.php';
            include __DIR__ . '/../layouts/webScriptsLayout.php'; 
        ?>
    </body>
</html>