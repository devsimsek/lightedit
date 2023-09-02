<?php extract($data) ?>

<div class="row">
  <div class="col-12 card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h4><?= $title ?></h4>
        <button onclick="window.history.back()" class="btn btn-sm btn-outline-secondary">Go Back</button>
      </div>
      <form method="post" action="/dashboard/account/create">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
    </div>
  </div>
</div>
