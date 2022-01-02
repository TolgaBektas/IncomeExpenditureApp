@extends('layouts.admin')
@section('title')
    Update Expenditure
@endsection

@section('content')
<div class="col-md-12">
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Update your expenditure!</h3>
    </div>
    <div class="col-md-8 m-auto">
      <form method="POST" action="{{ route('expenditure.update') }}" id="update-form"  enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ $expenditure->description }}" placeholder="Enter a description...">
            </div>

            <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category_id" id="category_id">
                  @foreach ($categories as $item)
                  <option {{ $item->id==$expenditure->category_id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" min="0.00" step="0.01" class="form-control" id="price" name="price" value="{{ $expenditure->price }}" placeholder="Enter a price...">
            </div>
            @if ($expenditure->invoice)
            <div class="form-group">
                <label for="currentImage">Current Invoice</label>
                <a href="{{ asset( 'storage/'.$expenditure->invoice) }}" class="btn btn-info" target="_blank">Invoice</a>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="delete_invoice" id="delete_invoice">
              <label class="form-check-label" for="delete_invoice">Delete Current Invoice <small>* If you want to delete this invoice please select this option.</label>
          </div>        
            @endif
            <div class="form-group">
                <label for="invoice">Invoice <small>*It can be pdf, jpg or png.</small></label>
                <input type="file" class="form-control" id="invoice" name="invoice">
                @error('invoice')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-check">
                <input type="checkbox" {{ $expenditure->status ? 'checked' : '' }} class="form-check-input" name="status" id="status">
                <label class="form-check-label" for="status">Money Has Given <small>* If money has not given then this expenditure will not affect charts or analytics.</small></label>
            </div>

        </div>

        <input type="hidden" name="old_invoice" value="{{ $expenditure->invoice }}">
        <input type="hidden" name="id" value="{{ $expenditure->id }}">
        <div class="card-footer"><button type="button" id="update" class="btn btn-success">Update</button></div>
      </form>
    </div>
  </div>
</div>


@endsection
@section('js')
<script>
   $(document).ready(function(){
    
      $('#update').click(function(){
        if ($('#price').val().trim()=="") {
            $('#price').focus();
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Price can not be empty!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
            
        }else{
            $('#update-form').submit();
            $('#update').prop('disabled',true);
          }
        });
      });
    
</script>
@endsection