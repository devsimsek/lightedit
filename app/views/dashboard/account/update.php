<?php extract($data); ?>

<div class="row">
  <div class="col-12 card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h4><?= $title ?></h4>
        <button onclick="window.history.back()" class="btn btn-sm btn-outline-secondary">Go Back</button>
      </div>
      <form method="post" action="/dashboard/account/update">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" value="<?= $user->name ?>">
          <div id="nameHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                 value="<?= $user->email ?>">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp">
          <div id="passwordHelp" class="form-text">Leave empty if you don't want to change.</div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>
