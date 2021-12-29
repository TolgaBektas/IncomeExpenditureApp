@extends('layouts.admin')
@section('title')
    Categories
@endsection

@section('content')
<div class="card">
	<div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h1 class="card-title">Categories</h1>
                <div class="card-tools float-right">							
                    <a href="{{ route('category.category-add') }}" class="btn bg-success btn-sm">Add New</a>
                </div>
            </div>			
        </div>
    </div>
	<div class="card-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>					
					<th>id</th>
					<th>name</th>
					<th>status</th>
					<th>created at</th>
					<th>updated at</th>
                    <th colspan="1"></th>
				</tr>
			</thead>
			<tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        @if ($category->status)
                        <button type="submit" class="btn btn-success changeStatus" data-id="{{ $category->id }}">Active</button>
                        @else
                        <button type="submit" class="btn btn-danger changeStatus" data-id="{{ $category->id }}">Pasive</button>
                        @endif                       
                    </td>
                    <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d-m-Y H:i') }}</td>
                    <td>{{ $category->updated_at }}</td>
                   <td>
                    <button class="btn btn-info update" data-bs-toggle="modal" data-bs-target="#modal" data-id="{{ $category->id }}"><i class="fas fa-pen"></i></button>
                    <button type="button" class="btn btn-danger delete" data-id="{{ $category->id }}"><i class="far fa-trash-alt"></i></button>
                   </td>
                </tr>
                @endforeach
            </tbody>
		</table>
	</div>			
</div>

  
  <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                      <h3 class="card-title">Update category!</h3>
                    </div>
                   
                    <div class="col-md-8 m-auto">
                        <form action="{{ route('category.update') }}" method="POST" autocomplete="off" id="update-form">
                          @csrf
                          @method('PUT')
                          <div class="card-body">
                            <div class="form-group">
                                <label for="id">id</label>
                                <input type="text" disabled class="form-control" id="idUpdate">
                            </div>

                            <div class="form-group">
                              <label for="name">Category</label>
                              <input type="text" class="form-control" id="nameUpdate" name="name" placeholder="Enter a category...">
                            </div>
                           
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" name="status" id="statusUpdate">
                              <label class="form-check-label" for="status">Status</label>
                            </div>
                          </div>
                         
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="id" name="id">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary updateSave">Save changes</button>
        </form>
        </div>
      </div>
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
                url:'{{ route("category.changeStatus") }}',
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
                        self[0].innerText='Active';
                        Toast.fire({
                            icon: 'success',
                            title: dataID+' id category changed to active successfully'
                        });
                    }else{
                        self[0].classList.remove('btn-success');
                        self[0].classList.add('btn-danger');
                        self[0].innerText='Pasive';
                        Toast.fire({
                            icon: 'success',
                            title: dataID+' id category changed to pasive successfully'
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
                text: "You won't be able to revert this! All things this category will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:'{{ route("category.delete") }}',
                        method:'POST',
                        data:{id:dataID},
                        async:false,
                        success:function(){
                            self[0].closest('tr').remove();
                            Swal.fire(
                                'Deleted!',
                                'Category has been deleted.',
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
            let categoryName=$('#nameUpdate');
            let categoryStatus=$('#statusUpdate');
            let categoryID=$('#idUpdate');
            let id=$('#id');
            $.ajax({
                url:'{{ route('category.updateShow') }}',
                method:'GET',
                data:{id:dataID},
                async:false,
                success:function(response){
                    let category=response.category;
                    
                    categoryName.val(category.name);
                    categoryID.val(category.id);
                    id.val(category.id);
                    if (category.status) {                       
                        categoryStatus.prop('checked',true);
                    }else{                       
                        categoryStatus.prop('checked',false);
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
                title: 'Category can not be empty!',
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