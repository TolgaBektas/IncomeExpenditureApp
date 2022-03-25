@extends('layouts.admin')
@section('title')
    Incomes
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h1 class="card-title">For other months, search in the form below.</a></h1>
            </div>			
        </div>
    </div>
    <div class="card-body">
        <form class="row" method="POST" id="search-form">
           @csrf           
            <div class="col-md-2">
                <label for="date_start" class="form-label">Date Start</label>
                <input type="date" class="form-control" id="date_start" name="date_start">
                @error('date_start')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                
            </div>
            <div class="col-md-2">
                <label for="date_finish" class="form-label">Date Finish</label>
                <input type="date" class="form-control" id="date_finish" name="date_finish">
                @error('date_finish')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="col-md-1">
              <button type="button" class="btn btn-lg btn-info mt-4" id="search">Search</button>
            </div>
            
          </form>
    </div>
</div>
<div class="card">
	<div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h1 class="card-title">Incomes - This page shows only current month's incomes. For other months, search in the form above.</a></h1>
                <div class="card-tools float-right">							
                    <a href="{{ route('income.add') }}" class="btn bg-success btn-sm">Add New</a>
                </div>
            </div>			
        </div>
    </div>
	<div class="card-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>					
					<th>id</th>
					<th>description</th>
					<th>category</th>
					<th>price</th>
					<th>invoice</th>
					<th>invoice date</th>
                    <th colspan="1"></th>
				</tr>
			</thead>
			<tbody>
                @foreach ($incomes as $income)
                <tr>
                    <td>{{ $income->id }}</td>
                    <td width="55%">{{ $income->description }}</td>
                    <td>{{ $income->category->name }}</td>
                    <td>{{ $income->price }}</td>
                    <td>
                    @if ($income->invoice)
                        <a href="{{ asset( 'storage/'.$income->invoice) }}" class="btn btn-success" target="_blank">Invoice</a>
                        @else
                        No Invoice
                        @endif      
                    </td>

                    <td>{{ $income->invoice_date }}</td>
                    
                   <td>
                    <a href="{{ route('income.updateShow',$income->id ) }}" class="btn btn-secondary update" data-id="{{ $income->id }}"><i class="fas fa-pen"></i></a>
                    <button type="button" class="btn btn-danger delete" data-id="{{ $income->id }}"><i class="far fa-trash-alt"></i></button>
                   </td>
                </tr>
                @endforeach
            </tbody>
		</table>
	</div>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function(){
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

        /* Delete with ajax */
        $('#example1').on('click','.delete',function(){
            let self=$(this);
            let dataID=$(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:'{{ route("income.delete") }}',
                        method:'POST',
                        data:{id:dataID},
                        async:false,
                        success:function(){
                            self[0].closest('tr').remove();
                            Swal.fire(
                                'Deleted!',
                                'Income has been deleted.',
                                'success'
                            )
                        }
                    });
                }
            })
        });
        /* Delete with ajax */

        $('#search').click(function(){
        if ($('#date_start').val().trim()=="") {
            $('#date_start').focus();
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Date start can not be empty!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            })
            
        }else if($('#date_finish').val().trim()==""){
          $('#date_finish').focus();
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Date finish can not be empty!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            })
        }else{
            $('#search-form').submit();
            $('#search').prop('disabled',true);
        }
    });
    });
</script>
@endsection