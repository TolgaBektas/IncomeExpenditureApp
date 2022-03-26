@extends('layouts.admin')
@section('title')
    Update Income
@endsection

@section('content')
<div class="col-md-12">
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Update your income!</h3>
    </div>
    <div class="col-md-8 m-auto">
      <form method="POST" action="{{ route('income.update') }}" id="update-form"  enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ $income->description }}" placeholder="Enter a description...">
                @error('description')
                <span class="text-danger">{{$message}}</span>
              @enderror  
            </div>

            <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category_id" id="category_id">
                  @foreach ($categories as $item)
                  <option {{ $item->id==$income->category_id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" min="0.00" step="0.01" class="form-control" id="price" name="price" value="{{ $income->price }}" placeholder="Enter a price...">
                @error('price')
                <span class="text-danger">{{$message}}</span>
              @enderror  
            </div>
            @if ($income->invoice)
            <div class="form-group">
                <label for="currentImage">Current Invoice</label>
                <a href="{{ asset( 'storage/'.$income->invoice) }}" class="btn btn-info" target="_blank">Invoice</a>
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
            <div class="form-group">
              <label for="invoice_date">Invoice Date</label>
              <input type="date"class="form-control" id="invoice_date" name="invoice_date" value="{{ $income->invoice_date }}">
              @error('invoice_date')
              <span class="text-danger">{{$message}}</span>
            @enderror
            </div>

        </div>

        <input type="hidden" name="old_invoice" value="{{ $income->invoice }}">
        <input type="hidden" name="id" value="{{ $income->id }}">
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
            $('#update-form').submit();
            $('#update').prop('disabled',true);
          }
        });
      });
    
</script>
@endsection