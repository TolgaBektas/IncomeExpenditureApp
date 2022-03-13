@extends('layouts.admin')
@section('title')
    Category Add
@endsection

@section('content')
<div class="col-md-12">
    <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Add new category!</h3>
        </div>
       
        <div class="col-md-8 m-auto">
            <form method="POST" autocomplete="off" id="add-form">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Category</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter a category...">
                </div>
               
                <div class="form-check">
                  <input type="checkbox" checked class="form-check-input" name="status" id="status">
                  <label class="form-check-label" for="status">Status</label>
                </div>

              </div>
              <div class="card-footer">
                <button type="button" id="add" class="btn btn-success">Save</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
   $(document).ready(function(){
 $('#add').click(function(){
        if ($('#name').val().trim()=="") {
            $('#name').focus();
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Category can not be empty!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            })
            
        }else{
            $('#add-form').submit();
            $('#add').prop('disabled',true);

        }
    });
});
   
   
</script>
@endsection