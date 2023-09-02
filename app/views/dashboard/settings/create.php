<?php extract($data) ?>

<div class="row">
  <div class="col-12 card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h4><?= $title ?></h4>
        <button onclick="window.history.back()" class="btn btn-sm btn-outline-secondary">Go Back</button>
      </div>
      <form method="post" action="/dashboard/settings/create">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
        </div>
        <div class="mb-3">
          <label for="value" class="form-label">Value</label>
          <input type="text" class="form-control" id="value" name="value" aria-describedby="valueHelp">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
    </div>
  </div>
</div>
