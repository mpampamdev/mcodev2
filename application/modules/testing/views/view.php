<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card-header bg-primary text-white">
      <?=ucwords($title_module)?>
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
        <tr>
          <td>Title</td>
          <td><?=$title?></td>
        </tr>
        <tr>
          <td>Desc</td>
          <td><?=$desc?></td>
        </tr>
        <tr>
          <td>Id user</td>
          <td><?=$id_user?></td>
        </tr>
        <tr>
          <td>Id image</td>
          <td><?=$id_image?></td>
        </tr>
        <tr>
          <td>Status</td>
          <td><?=$status?></td>
        </tr>
        <tr>
          <td>Created at</td>
          <td><?=$created_at != "" ? date('d-m-Y H:i',strtotime($created_at)):""?></td>
        </tr>
        <tr>
          <td>Update at</td>
          <td><?=$update_at != "" ? date('d-m-Y H:i',strtotime($update_at)):""?></td>
        </tr>
        </table>

        <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger mt-3"><?=cclang("back")?></a>
      </div>
    </div>
  </div>
</div>
