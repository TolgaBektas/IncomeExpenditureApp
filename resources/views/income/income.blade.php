@extends('layouts.admin')
@section('title')
    Incomes
@endsection

@section('content')
<div class="card">
	<div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h1 class="card-title">Incomes - This page shows only current month's incomes. For more details, see <a href="#">Analyze.</a></h1>
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
					<th>Money Has Taken</th>
					<th>created at</th>
					<th>updated at</th>
                    <th colspan="1"></th>
				</tr>
			</thead>
			<tbody>
                @foreach ($incomes as $income)
                <tr>
                    <td>{{ $income->id }}</td>
                    <td>{{ $income->description }}</td>
                    <td>{{ $categories->find($income->category_id)->name }}</td>
                    <td>{{ $income->price }}</td>
                    <td>
                    @if ($income->invoice)
                        <a href="{{ asset( 'storage/'.$income->invoice) }}" class="btn btn-info" target="_blank">Invoice</a>
                        @else
                        No Invoice
                        @endif      
                    </td>

                    <td>
                        @if ($income->status)
                        <button type="submit" class="btn btn-success changeStatus" data-id="{{ $income->id }}">Yes</button>
                        @else
                        <button type="submit" class="btn btn-danger changeStatus" data-id="{{ $income->id }}">No</button>
                        @endif                       
                    </td>
                    <td>{{ \Carbon\Carbon::parse($income->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($income->updated_at)->format('d-m-Y H:i') }}</td>
                   <td>
                    <a href="{{ route('income.updateShow',$income->id ) }}" class="btn btn-info update" data-id="{{ $income->id }}"><i class="fas fa-pen"></i></a>
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        /* Change status with ajax */
        $('.changeStatus').click(function(){
            let dataID=$(this).data('id');
            let self=$(this);
            $.ajax({
                url:'{{ route("income.changeStatus") }}',
                method:'POST',
                data:{id:dataID},
                async:false,
                success:function(response){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    if (response.status==1) {
                        self[0].classList.remove('btn-danger');
                        self[0].classList.add('btn-success');
                        self[0].innerText='Yes';
                        Toast.fire({
                            icon: 'success',
                            title: dataID+' id income changed to Yen successfully'
                        });
                    }else{
                        self[0].classList.remove('btn-success');
                        self[0].classList.add('btn-danger');
                        self[0].innerText='No';
                        Toast.fire({
                            icon: 'success',
                            title: dataID+' id income changed to No successfully'
                        });
                    }
                },
                error:function(){}
            });
        });
        /* Change status with ajax */

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

        /* Update show data with ajax */
        $('.update').click(function(){
            let dataID=$(this).data('id');
            /* let route='{{ route('category.updateShow',['id'=>'categoryEdit']) }}';
            route=route.replace('categoryEdit',dataID); */
            let incomeName=$('#nameUpdate');
            let incomeStatus=$('#statusUpdate');
            let incomeID=$('#idUpdate');
            let id=$('#id');
            $.ajax({
                url:'{{ route('income.updateShow') }}',
                method:'GET',
                data:{id:dataID},
                async:false,
                success:function(response){
                    let income=response.income;
                    
                    incomeName.val(income.name);
                    incomeID.val(income.id);
                    id.val(income.id);
                    if (income.status) {                       
                        incomeStatus.prop('checked',true);
                    }else{                       
                        incomeStatus.prop('checked',false);
                    }
                }
            });
        });
        /* Update show data with ajax */

        /* Update data with ajax */
        $('.updateSave').click(function(){
            if ($('#nameUpdate').val().trim()=="") {
                $('#nameUpdate').focus();
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Income can not be empty!',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
                })
            }else{
                $('#update-form').submit();
            }
        });
        /* Update data with ajax */

    });
</script>
@endsection