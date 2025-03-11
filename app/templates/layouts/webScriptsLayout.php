<?php require_once __DIR__ . "/../../lang/{$GLOBALS['lang']}/layouts/webScriptsLang.php" ?>

<script type="text/javascript">
    const LANG = "<?= $GLOBALS['lang'] ?>";
    const URL_LANG = "<?= $GLOBALS['url-lang'] ?>";
    const URL_PATH = "<?= $GLOBALS['url-path'] ?>";
    const LANGUAGE = JSON.parse('<?= json_encode($GLOBALS['lang-layouts']['scripts'], JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) ?>');
</script>

<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['lib']['script']['jquery'] ?>"></script>
<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['lib']['script']['bootstrap'] ?>"></script>
<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['lib']['script']['select2'] ?>"></script>

<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['local']['script']['general'] ?>"></script>
<script type="text/javascript" src="<?= $GLOBALS['url-path'] . $GLOBALS['files']['local']['script']['methods'] ?>"></script>
<?php if (isset($GLOBALS['web-info']) && $GLOBALS['web-info']->scripts) {
    foreach ($GLOBALS['web-info']->scripts as $script) { 
        if ($script) {
            echo '<script type="text/javascript" src="'. $GLOBALS['url-path'] . $script .'" ></script>'; 
            echo "\n";
        }
    }
} ?>