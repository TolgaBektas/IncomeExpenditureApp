@extends('layouts.admin')
@section('title')
<a href="{{ route('expenditure.index') }}">Expenditures</a> / Expenditure Add
@endsection

@section('content')
<div class="col-md-12">
    <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Add new expenditure!</h3>
        </div>
       
        <div class="col-md-8 m-auto">
            <form method="POST" autocomplete="off" id="add-form" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" class="form-control" id="description" name="description" placeholder="Enter a description...">
                  @error('description')
                  <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control" name="category_id" id="category_id">
                    <option value="" disabled selected>--Select Category--</option>
                    @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                  @error('category_id')
                  <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="number" min="0.00" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="Enter a price...">
                  @error('price')
                  <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-group">
                  <label for="invoice">Invoice <small>*It can be pdf, jpg or png.</small></label>
                  <input type="file" class="form-control" id="invoice" name="invoice">
                  @error('invoice')
                  <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
                <div class="form-group">
                  <label for="invoice_date">Invoice Date</label>
                  <input type="date"class="form-control" id="invoice_date" name="invoice_date" value="{{ old('invoice_date') }}">
                  @error('invoice_date')
                  <span class="text-danger">{{$message}}</span>
                @enderror
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
       if ($('#description').val().trim()=="") {
           $('#description').focus();
           Swal.fire({
               position: 'center',
               icon: 'error',
               title: 'Description can not be empty!',
               showConfirmButton: false,
               timer: 2500,
               timerProgressBar: true
           })            
       }else if($('#category_id').children("option:selected").val()==""){
         $('#category_id').focus();
           Swal.fire({
               position: 'center',
               icon: 'error',
               title: 'Select a category!',
               showConfirmButton: false,
               timer: 2500,
               timerProgressBar: true
           })
       }else if($('#price').val().trim()==""){
         $('#price').focus();
           Swal.fire({
               position: 'center',
               icon: 'error',
               title: 'Price can not be empty!',
               showConfirmButton: false,
               timer: 2500,
               timerProgressBar: true
           })
       }else if($('#invoice_date').val().trim()==""){
         $('#invoice_date').focus();
           Swal.fire({
               position: 'center',
               icon: 'error',
               title: 'Invoice date can not be empty!',
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