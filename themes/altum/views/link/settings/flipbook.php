<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>

<div class="card">
    <div class="card-body">

        <form name="update_flipbook" action="" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />
            <input type="hidden" name="request_type" value="update" />
            <input type="hidden" name="type" value="flipbook" />
            <input type="hidden" name="link_id" value="<?= $data->link->link_id ?>" />

            <div class="notification-container"></div>

            <div class="form-group">
                <label for="url"><i class="fas fa-fw fa-bolt fa-sm text-muted mr-1"></i> <?= l('link.settings.url') ?></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <?php if(count($data->domains)): ?>
                            <select name="domain_id" class="appearance-none custom-select form-control input-group-text">
                                <?php if(settings()->links->main_domain_is_enabled || \Altum\Authentication::is_admin()): ?>
                                    <option value="" <?= $data->link->domain ? 'selected="selected"' : null ?> data-full-url="<?= SITE_URL ?>"><?= remove_url_protocol_from_url(SITE_URL) ?></option>
                                <?php endif ?>

                                <?php foreach($data->domains as $row): ?>
                                    <option value="<?= $row->domain_id ?>" <?= $data->link->domain && $row->domain_id == $data->link->domain->domain_id ? 'selected="selected"' : null ?>  data-full-url="<?= $row->url ?>" data-type="<?= $row->type ?>"><?= remove_url_protocol_from_url($row->url) ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php else: ?>
                            <span class="input-group-text"><?= remove_url_protocol_from_url(SITE_URL) ?></span>
                        <?php endif ?>
                    </div>

                    <input
                            id="url"
                            type="text"
                            class="form-control"
                            name="url"
                            placeholder="<?= l('global.url_slug_placeholder') ?>"
                            value="<?= $data->link->url ?>"
                            maxlength="<?= $this->user->plan_settings->url_maximum_characters ?? 64 ?>"
                            onchange="update_this_value(this, get_slug)"
                            onkeyup="update_this_value(this, get_slug)"
                        <?= !$this->user->plan_settings->custom_url ? 'readonly="readonly"' : null ?>
                        <?= $this->user->plan_settings->custom_url ? null : get_plan_feature_disabled_info() ?>
                    />
                </div>
                <small class="form-text text-muted"><?= l('link.settings.url_help') ?></small>
            </div>

            <?php if(count($data->domains)): ?>
                <div id="is_main_link_wrapper" class="form-group custom-control custom-switch">
                    <input id="is_main_link" name="is_main_link" type="checkbox" class="custom-control-input" <?= $data->link->domain_id && $data->domains[$data->link->domain_id]->link_id == $data->link->link_id ? 'checked="checked"' : null ?>>
                    <label class="custom-control-label" for="is_main_link"><?= l('link.settings.is_main_link') ?></label>
                    <small class="form-text text-muted"><?= l('link.settings.is_main_link_help') ?></small>
                </div>
            <?php endif ?>

            <div class="form-group">
                <label for="pdf"><i class="fas fa-fw fa-file-pdf fa-sm text-muted mr-1"></i> <?= l('link.settings.flipbook.pdf') ?></label>
                <?php if(!empty($data->link->settings->pdf)): ?>
                    <div class="mb-3">
                        <i class="fas fa-fw fa-sm fa-file-pdf text-muted"></i> <a href="<?= \Altum\Uploads::get_full_url('flipbooks') . $data->link->settings->pdf ?>" target="_blank"><?= $data->link->settings->pdf ?></a>
                    </div>
                <?php endif ?>
                <input id="pdf" type="file" name="pdf" accept=".pdf" class="form-control-file altum-file-input" />
                <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), '.pdf') . ' ' . sprintf(l('global.accessibility.file_size_limit'), $this->user->plan_settings->flipbooks_file_size_limit ?? settings()->links->flipbooks_file_size_limit) ?></small>
            </div>

            <h2 class="h4 my-4"><?= l('link.settings.flipbook.appearance_header') ?></h2>

            <div class="form-group">
                <label for="start_page"><i class="fas fa-fw fa-file-lines fa-sm text-muted mr-1"></i> <?= l('link.settings.flipbook.start_page') ?></label>
                <input id="start_page" type="number" name="start_page" class="form-control" value="<?= $data->link->settings->start_page ?? 1 ?>" min="1" />
                <small class="form-text text-muted"><?= l('link.settings.flipbook.start_page_help') ?></small>
            </div>

            <div class="form-group">
                <label for="direction"><i class="fas fa-fw fa-compass fa-sm text-muted mr-1"></i> <?= l('link.settings.flipbook.direction') ?></label>
                <select id="direction" name="direction" class="custom-select">
                    <option value="ltr" <?= ($data->link->settings->direction ?? 'ltr') == 'ltr' ? 'selected="selected"' : null ?>><?= l('link.settings.flipbook.direction_ltr') ?></option>
                    <option value="rtl" <?= ($data->link->settings->direction ?? '') == 'rtl' ? 'selected="selected"' : null ?>><?= l('link.settings.flipbook.direction_rtl') ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="background_color"><i class="fas fa-fw fa-palette fa-sm text-muted mr-1"></i> <?= l('link.settings.flipbook.background_color') ?></label>
                <input type="hidden" name="background_color" class="form-control" value="<?= $data->link->settings->background_color ?? '#ffffff' ?>" data-color-picker />
                <small class="form-text text-muted"><?= l('link.settings.flipbook.background_color_help') ?></small>
            </div>

            <div class="form-group">
                <label for="shadow_intensity"><i class="fas fa-fw fa-layer-group fa-sm text-muted mr-1"></i> <?= l('link.settings.flipbook.shadow_intensity') ?></label>
                <input type="range" min="0" max="100" id="shadow_intensity" name="shadow_intensity" class="form-control" value="<?= $data->link->settings->shadow_intensity ?? 50 ?>" />
                <small class="form-text text-muted"><?= l('link.settings.flipbook.shadow_intensity_help') ?></small>
            </div>

            <div class="form-group custom-control custom-switch">
                <input id="sound_on_turn" name="sound_on_turn" type="checkbox" class="custom-control-input" <?= $data->link->settings->sound_on_turn ?? true ? 'checked="checked"' : null ?>>
                <label class="custom-control-label" for="sound_on_turn"><?= l('link.settings.flipbook.sound_on_turn') ?></label>
            </div>

            <h2 class="h4 my-4"><?= l('link.settings.flipbook.controls_header') ?></h2>

            <div class="form-group custom-control custom-switch">
                <input id="display_download" name="display_download" type="checkbox" class="custom-control-input" <?= $data->link->settings->display_download ?? true ? 'checked="checked"' : null ?>>
                <label class="custom-control-label" for="display_download"><?= l('link.settings.flipbook.display_download') ?></label>
            </div>

            <div class="form-group custom-control custom-switch">
                <input id="display_print" name="display_print" type="checkbox" class="custom-control-input" <?= $data->link->settings->display_print ?? true ? 'checked="checked"' : null ?>>
                <label class="custom-control-label" for="display_print"><?= l('link.settings.flipbook.display_print') ?></label>
            </div>

            <div class="form-group custom-control custom-switch">
                <input id="display_thumbnails" name="display_thumbnails" type="checkbox" class="custom-control-input" <?= $data->link->settings->display_thumbnails ?? true ? 'checked="checked"' : null ?>>
                <label class="custom-control-label" for="display_thumbnails"><?= l('link.settings.flipbook.display_thumbnails') ?></label>
            </div>

            <div class="form-group custom-control custom-switch">
                <input id="display_zoom" name="display_zoom" type="checkbox" class="custom-control-input" <?= $data->link->settings->display_zoom ?? true ? 'checked="checked"' : null ?>>
                <label class="custom-control-label" for="display_zoom"><?= l('link.settings.flipbook.display_zoom') ?></label>
            </div>

            <div class="form-group custom-control custom-switch">
                <input id="display_fullscreen" name="display_fullscreen" type="checkbox" class="custom-control-input" <?= $data->link->settings->display_fullscreen ?? true ? 'checked="checked"' : null ?>>
                <label class="custom-control-label" for="display_fullscreen"><?= l('link.settings.flipbook.display_fullscreen') ?></label>
            </div>

            <?php if(settings()->links->pixels_is_enabled): ?>
                <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#pixels_container" aria-expanded="false" aria-controls="pixels_container">
                    <i class="fas fa-fw fa-adjust fa-sm mr-1"></i> <?= l('link.settings.pixels_header') ?>
                </button>

                <div class="collapse" id="pixels_container">
                    <div class="form-group">
                        <div class="d-flex flex-column flex-xl-row justify-content-between">
                            <label><i class="fas fa-fw fa-sm fa-adjust text-muted mr-1"></i> <?= l('link.settings.pixels_ids') ?></label>
                            <a href="<?= url('pixels') ?>" target="_blank" class="small mb-2"><i class="fas fa-fw fa-sm fa-plus mr-1"></i> <?= l('pixels.create') ?></a>
                        </div>

                        <div class="row">
                            <?php $available_pixels = require APP_PATH . 'includes/pixels.php'; ?>
                            <?php foreach($data->pixels as $pixel): ?>
                                <div class="col-12 col-lg-6">
                                    <div class="custom-control custom-checkbox my-2">
                                        <input id="pixel_id_<?= $pixel->pixel_id ?>" name="pixels_ids[]" value="<?= $pixel->pixel_id ?>" type="checkbox" class="custom-control-input" <?= in_array($pixel->pixel_id, $data->link->pixels_ids) ? 'checked="checked"' : null ?>>
                                        <label class="custom-control-label d-flex align-items-center" for="pixel_id_<?= $pixel->pixel_id ?>">
                                            <span class="text-truncate" title="<?= $pixel->name ?>"><?= $pixel->name ?></span>
                                            <small class="badge badge-light ml-1" data-toggle="tooltip" title="<?= $available_pixels[$pixel->type]['name'] ?>">
                                                <i class="<?= $available_pixels[$pixel->type]['icon'] ?> fa-fw fa-sm" style="color: <?= $available_pixels[$pixel->type]['color'] ?>"></i>
                                            </small>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#protection_container" aria-expanded="false" aria-controls="protection_container">
                <i class="fas fa-fw fa-user-shield fa-sm mr-1"></i> <?= l('link.settings.protection_header') ?>
            </button>

            <div class="collapse" id="protection_container">
                <div <?= $this->user->plan_settings->password ? null : get_plan_feature_disabled_info() ?>>
                    <div class="<?= $this->user->plan_settings->password ? null : 'container-disabled' ?>">
                        <div class="form-group" data-password-toggle-view data-password-toggle-view-show="<?= l('global.show') ?>" data-password-toggle-view-hide="<?= l('global.hide') ?>">
                            <label for="qweasdzxc"><i class="fas fa-fw fa-key fa-sm text-muted mr-1"></i> <?= l('global.password') ?></label>
                            <input id="qweasdzxc" type="password" class="form-control" name="qweasdzxc" value="<?= $data->link->settings->password ?>" autocomplete="new-password" <?= !$this->user->plan_settings->password ? 'disabled="disabled"': null ?> />
                            <small class="form-text text-muted"><?= l('link.settings.password_help') ?></small>
                        </div>
                    </div>
                </div>

                <div <?= $this->user->plan_settings->sensitive_content ? null : get_plan_feature_disabled_info() ?>>
                    <div class="<?= $this->user->plan_settings->sensitive_content ? null : 'container-disabled' ?>">
                        <div class="form-group custom-control custom-switch">
                            <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="sensitive_content"
                                    name="sensitive_content"
                                <?= !$this->user->plan_settings->sensitive_content ? 'disabled="disabled"': null ?>
                                <?= $data->link->settings->sensitive_content ? 'checked="checked"' : null ?>
                            >
                            <label class="custom-control-label" for="sensitive_content"><?= l('link.settings.sensitive_content') ?></label>
                            <small class="form-text text-muted"><?= l('link.settings.sensitive_content_help') ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#advanced_container" aria-expanded="false" aria-controls="advanced_container">
                <i class="fas fa-fw fa-user-tie fa-sm mr-1"></i> <?= l('link.settings.advanced_header') ?>
            </button>

            <div class="collapse" id="advanced_container">
                <?php if(settings()->links->projects_is_enabled): ?>
                <div class="form-group">
                    <div class="d-flex flex-column flex-xl-row justify-content-between">
                        <label for="project_id"><i class="fas fa-fw fa-sm fa-project-diagram text-muted mr-1"></i> <?= l('projects.project_id') ?></label>
                        <a href="<?= url('project-create') ?>" target="_blank" class="small mb-2"><i class="fas fa-fw fa-sm fa-plus mr-1"></i> <?= l('projects.create') ?></a>
                    </div>
                    <select id="project_id" name="project_id" class="custom-select">
                        <option value=""><?= l('global.none') ?></option>
                        <?php foreach($data->projects as $row): ?>
                            <option value="<?= $row->project_id ?>" <?= $data->link->project_id == $row->project_id ? 'selected="selected"' : null?>><?= $row->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <?php endif ?>
            </div>

            <div class="mt-4">
                <button type="submit" name="submit" class="btn btn-block btn-primary" data-is-ajax><?= l('global.update') ?></button>
            </div>
        </form>

    </div>
</div>

<?php $html = ob_get_clean() ?>


<?php ob_start() ?>
<script>
    /* Form handling */
    $('form[name="update_flipbook"]').on('submit', event => {
        let form = $(event.currentTarget)[0];
        let data = new FormData(form);

        let notification_container = event.currentTarget.querySelector('.notification-container');
        notification_container.innerHTML = '';
        pause_submit_button(event.currentTarget.querySelector('[type="submit"][name="submit"]'));

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            url: `${url}link-ajax`,
            data: data,
            dataType: 'json',
            success: (data) => {
                display_notifications(data.message, data.status, notification_container);
                notification_container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                enable_submit_button(event.currentTarget.querySelector('[type="submit"][name="submit"]'));

                if(data.status == 'success') {
                    update_main_url(data.details.url);

                    /* If the file was updated, refresh the page */
                    if(data.details.refresh) {
                        setTimeout(() => {
                           redirect(window.location.href);
                        }, 500);
                    }
                }
            },
            error: () => {
                enable_submit_button(event.currentTarget.querySelector('[type="submit"][name="submit"]'));
                display_notifications(<?= json_encode(l('global.error_message.basic')) ?>, 'error', notification_container);
            },
        });

        event.preventDefault();
    })
</script>
<?php $javascript = ob_get_clean() ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>