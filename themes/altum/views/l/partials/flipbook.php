<?php defined('ALTUMCODE') || die() ?>

<?php
/* Get the branding */
$branding = null;
if(
    !$this->user->plan_settings->removable_branding
    || (
        $this->user->plan_settings->removable_branding
        && $this->link->settings->display_branding
        && $this->user->plan_settings->custom_branding
    )
) {
    $branding = $this->link->settings->branding;
}
?>

<div class="container animate__animated animate__fadeIn">
    <div class="row">
        <div class="col-12 d-flex flex-column justify-content-center align-items-center">

            <!-- DF_Book_Container is the default container for dFlip -->
            <div id="DF_Book_Container"></div>

            <?php if($branding): ?>
                <div class="link-branding mt-4">
                    <a href="<?= $branding->url ? process_url($branding->url) : url() ?>" target="_blank">
                        <?php if(isset($branding->name) && !empty($branding->name)): ?>
                            <?= $branding->name ?>
                        <?php else: ?>
                            <?= settings()->main->branding ?>
                        <?php endif ?>
                    </a>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php ob_start() ?>
<link href="<?= ASSETS_FULL_URL . 'css/dflip.min.css' ?>" rel="stylesheet" media="screen">
<link href="<?= ASSETS_FULL_URL . 'css/themify-icons.min.css' ?>" rel="stylesheet" media="screen">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/dflip.min.js' ?>"></script>

<script>
    'use strict';

    /* Default options that you can override */
    let default_options = {
        height: '90vh',
        direction: '<?= $data->link->settings->direction ?>',
        backgroundColor: '<?= $data->link->settings->background_color ?>',
        pageMode: DFLIP.PAGE_MODE.AUTO,
        singlePageMode: DFLIP.SINGLE_PAGE_MODE.AUTO,
        shadowOpacity: (<?= $data->link->settings->shadow_intensity ?> / 100),
        soundEnable: <?= json_encode((bool) $data->link->settings->sound_on_turn) ?>,
        enableDownload: <?= json_encode((bool) $data->link->settings->display_download) ?>,
        enablePrint: <?= json_encode((bool) $data->link->settings->display_print) ?>,
        enableAnnotation: false,
        enableAnalytics: false,
        webgl: true,
        hard: 'cover',
        openPage: <?= $data->link->settings->start_page ?? 1 ?>,
        controlsPosition: DFLIP.CONTROLSPOSITION.BOTTOM,
        controlsTransparent: true,
        allControls: 'altPrev,pageNumber,altNext,play,outline,thumbnail,zoomIn,zoomOut,fullScreen,share,download,print,more,pageMode,startPage,endPage,sound',
        hideControls: 'annotation,search',
    };

    /* Controls to hide based on user settings */
    let hide_controls = ['annotation', 'search'];
    <?php if(!$data->link->settings->display_download) { echo "hide_controls.push('download');"; } ?>
    <?php if(!$data->link->settings->display_print) { echo "hide_controls.push('print');"; } ?>
    <?php if(!$data->link->settings->display_thumbnails) { echo "hide_controls.push('thumbnail', 'outline');"; } ?>
    <?php if(!$data->link->settings->display_zoom) { echo "hide_controls.push('zoomIn', 'zoomOut');"; } ?>
    <?php if(!$data->link->settings->display_fullscreen) { echo "hide_controls.push('fullScreen');"; } ?>

    default_options.hideControls = hide_controls.join(',');

    /* Custom branding logo overlay */
    <?php if($this->user->plan_settings->flipbook_custom_branding && !empty($this->user->preferences->white_label_logo)): ?>
    default_options.logo = '<?= \Altum\Uploads::get_full_url('white_label_logo') . $this->user->preferences->white_label_logo ?>';
    default_options.logoHeight = 40;
    <?php endif; ?>

    /* Initialize dFlip */
    let flipbook = $("#DF_Book_Container").flipBook({
        ...default_options,
        source: '<?= \Altum\Uploads::get_full_url('flipbooks') . $data->link->settings->pdf ?>',
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>