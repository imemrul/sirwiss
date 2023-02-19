@extends('products.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Product Table</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('product.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-striped" id="product-table">
        <thead class="thead-dark">
        <tr>
            <th>ID#</th>
            <th>Name</th>
            <th>Detail</th>
            <th>Original Price</th>
            <th>Discount Price</th>
            <th>Product Type</th>
            <th>Added By</th>
            <th width="280px">Action</th>
        </tr>
        </thead>

    </table>
    <script type="text/javascript">
        $(document).ready( function () {
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $('#product-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('product') }}",
        columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'detail', name: 'detail' , orderable: false},
        { data: 'original_price', name: 'original_price' , orderable: false},
        { data: 'discount_price', name: 'discount_price' , orderable: false},
        { data: 'type', name: 'type' },
        { data: 'userName', name: 'userName', "sType": "html" },
        {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
        });
        $('body').on('click', '.delete', function () {
        if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
        // ajax
        $.ajax({
        type:"POST",
        url: "{{ url('delete-company') }}",
        data: { id: id},
        dataType: 'json',
        success: function(res){
        var oTable = $('#product-table').dataTable();
        oTable.fnDraw(false);
        }
        });
        }
        });
        });
        </script>      
@endsection