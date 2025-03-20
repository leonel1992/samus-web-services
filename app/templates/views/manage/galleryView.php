<?php 
    $extImages = '';
    $extensions = JSON::open(__DIR__ . '/../../../../data/system/extensions.json');
    if (is_array($extensions['image'])) {
        $array = array_map('strtolower', $extensions['image']);
        $extImages = '.' . implode(',.', $array);
    }
?>

<section class="manage-view gallery-view scrollable">
    <div class="container py-3">

		<div id="manage-view-title" class="d-flex justify-content-between align-items-center mb-3">
			<h2 class="m-0"><?= $GLOBALS['lang-view']['view-title'] ?></h2>
			<button id="manage-show-form" type="button" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#manage-modal-form">
				<i class="bi bi-plus-lg"></i>
				<span class="px-1"><?= $GLOBALS['lang-view']['button-insert-view'] ?></span>
			</button>

		</div>

		<div id="manage-view-filter" class="manage-filter position-relative">
			<input type="text" id="manage-filter" class="form-control" placeholder="<?= $GLOBALS['lang-view']['view-filter'] ?>">
			<button id="manage-filter-search" class="btn-search border-0 bg-transparent position-absolute">
				<i class="bi bi-search"></i>
			</button>
			<button id="manage-filter-clean" class="btn-clean border-0 bg-transparent position-absolute">
				<i class="bi bi-x-lg"></i>
			</button>
		</div>

		<div id="manage-view-cards" class="position-relative">
			<?php include __DIR__ . '/../../layouts/manageResponseLayout.php'; ?>
			<div class="cards-container row g-3"></div>
		</div>

		<div id="manage-details"
			data-text-date="<?= $GLOBALS['lang-view']['view-date'] ?>"
			data-title-copy="<?= $GLOBALS['lang-view']['button-copy-card'] ?>"
			data-title-update="<?= $GLOBALS['lang-view']['button-update-card'] ?>"
			data-title-delete="<?= $GLOBALS['lang-view']['button-delete-card'] ?>"
		></div>

    </div>
</section>

<div class="modal modal-form fade" id="manage-modal-form" tabindex="-1" aria-labelledby="manage-view-form-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-dialog-scrollable">
		<div class="modal-content shadow-lg">
			
			<div class="modal-header bg-gradient position-relative">
				<div class="d-flex align-items-center gap-2">
					<i class="bi bi-images fs-3"></i>
					<h5 class="modal-title m-0 fw-bold" id="manage-view-form-label">
						<?= $GLOBALS['lang-view']['view-title'] ?>
					</h5>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
			</div>

			<div class="modal-body">
				<form id="manage-form" class="validate-form">
					<div id="input-group-name" class="input-group-label">
						<label class="input-label fixed" for="name"><?= $GLOBALS['lang-view']['form-name-label'] ?></label>
						<input id="name" type="text" class="form-control" placeholder="<?= $GLOBALS['lang-view']['form-name-placeholder'] ?>" maxlength="50" validate-length="3" required> 
						<div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-name-invalid-feedback'] ?></div>
					</div>
					<div id="input-group-image" class="input-group-label">
						<div id="image" class="custom-file form-control"
							input-type="image"
							input-accept="<?= $extImages ?>"
							input-text="<?= $GLOBALS['lang-view']['form-image-input-text'] ?>"
							input-button="<?= $GLOBALS['lang-view']['form-image-input-button'] ?>"
							input-info-link="<?= $GLOBALS['lang-view']['form-image-info-link'] ?>"
							input-replace-view="true"
							validate-file-size="10000"
							validate-file="true"
							required>
						</div>
						<div class="invalid-feedback"><?= $GLOBALS['lang-view']['form-image-invalid-feedback'] ?></div>
					</div>
					<?php include __DIR__ .'/../../layouts/manageFormButtonsLayout.php'; ?>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
echo getScript('new ManageGallery()');