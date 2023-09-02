<?php extract($data); ?>

<div class="row">
  <div class="col-12 card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h4><?= $title ?></h4>
        <button onclick="window.history.back()" class="btn btn-sm btn-outline-secondary">Go Back</button>
      </div>
      <form method="post" action="/dashboard/settings/update">
        <div class="mb-3">
          <label for="setting" class="form-label">Value</label>
          <input type="text" class="form-control" id="setting" name="setting" aria-describedby="settingHelp"
                 value="<?= $setting->value ?>">
          <div id="emailHelp" class="form-text">Value of the setting.</div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>
