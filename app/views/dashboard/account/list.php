<?php extract($data); ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="col-12 d-flex justify-content-between mb-4">
          <h4>Accounts</h4>
          <a href="/dashboard/account/create" class="btn btn-sm btn-outline-secondary">Create New Account</a>
        </div>
        <table class="table table-responsive w-100">
          <thead>
          <tr>
            <th class="col-1">#</th>
            <th class="col-auto">Email</th>
            <th class="col-auto">Name</th>
            <th class="col-1">Action</th>
          </tr>
          </thead>
          <tbody>
          <?php if (is_countable($users)): ?>
            <?php foreach ($users as $user): ?>
              <tr>
                <td class="col-1"><?= $user->id ?></td>
                <td class="col-auto"><?= $user->email ?></td>
                <td class="col-auto"><?= $user->name ?></td>
                <td class="col-1">
                  <div class="btn-group" role="group" aria-label="ActionButtons">
                    <a href="/dashboard/account/update/<?= $user->id ?>" class="btn hover text-light"><i
                        class="bi bi-pencil-square"></i></a>
                    <a href="/dashboard/account/delete/<?= $user->id ?>"
                       onclick="confirm_action('Do you want to proceed with the deletion of this account?', event)"
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
