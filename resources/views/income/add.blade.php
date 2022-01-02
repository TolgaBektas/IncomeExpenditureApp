@extends('layouts.admin')
@section('title')
    Income Add
@endsection

@section('content')
<div class="col-md-12">
    <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Add new income!</h3>
        </div>
       
        <div class="col-md-8 m-auto">
            <form method="POST" autocomplete="off" id="add-form" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" class="form-control" id="description" name="description" placeholder="Enter a description...">
                </div>
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category_id" id="category_id">
                    @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="number" min="0.00" step="0.01" class="form-control" id="price" name="price" placeholder="Enter a price...">
                </div>
                <div class="form-group">
                  <label for="invoice">Invoice <small>*It can be pdf, jpg or png.</small></label>
                  <input type="file" class="form-control" id="invoice" name="invoice">
                  @error('invoice')
                  <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="status" id="status">
                  <label class="form-check-label" for="status">Money Has Taken <small>* If money has not taken then this income will not affect charts or analytics.</small></label>
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
        if ($('#price').val().trim()=="") {
            $('#price').focus();
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Price can not be empty!',
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