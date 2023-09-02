<?php extract($data); ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="col-12 d-flex justify-content-between mb-4">
          <h4>Accounts</h4>
          <a href="/dashboard/settings/create" class="btn btn-sm btn-outline-secondary">Create a New Setting</a>
        </div>
        <table class="table table-responsive w-100">
          <thead>
          <tr>
            <th class="col-1">#</th>
            <th class="col-auto">Name</th>
            <th class="col-auto">Value</th>
            <th class="col-1">Action</th>
          </tr>
          </thead>
          <tbody>
          <?php if (is_countable($settings)): ?>
            <?php foreach ($settings as $setting): ?>
              <tr>
                <td class="col-1"><?= $setting->id ?></td>
                <td class="col-auto"><?= $setting->name ?></td>
                <td class="col-auto"><?= $setting->value ?></td>
                <td class="col-1">
                  <div class="btn-group" role="group" aria-label="ActionButtons">
                    <a href="/dashboard/settings/update/<?= $setting->id ?>" class="btn hover text-light"><i
                        class="bi bi-pencil-square"></i></a>
                    <a href="/dashboard/settings/delete/<?= $setting->id ?>"
                       onclick="confirm_action('Do you want to proceed with the deletion of this setting?', event)"
                       class="btn hover"><i
                        class="bi bi-trash text-danger"></i></a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
