@extends('layouts.appnew')

@section('style')
<link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('/css/dataTables.responsive.css') }}">
<link rel="stylesheet" href="{{ asset('/css/sweetalert.css') }}">

@endsection

@section('content')
<div class="content">
    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title"> Items </h5>
        </div>
        <div class="box-body">
        <table id="example" class="table table-bordered table-striped dt-responsive"
                               cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Seller</th>
                                <th>Price</th>
                                <th>Detail</th>
                                <th>Image</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
            

        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/dataTables.responsive.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            var otable = $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{!! url('/datatable') !!}",
                columns: [
                    {data: "name"},
                    {data: "seller"},
                    {data: "price"},
                    {data: "details"},
                    {data: "image"},
                    {data: "action", orderable: false, searchable: false},
                ]
            });



            $(document).on('click', '#delete', function () {
                var id = $(this).attr('val');
                var token = $(this).data('token');
                swal({
                        title: "Etes-vous sûrs? ",
                        text: "Vous ne pourrez plus récupérer ça",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Confirmer",
                        closeOnConfirm: false
                    },
                    function () {
                        $.ajax({
                            type: "get",
                            url: "{{url('/itemsview/delete')}}/" + id,
                            data: {_token: token},
                            beforeSend: function () {
                                //$('#wait').html("Wait for checking");
                            },
                            success: function (data) {
                                otable.draw();
                                swal("Supprimé!", "L'article a été supprimé", "success");
                            },
                            error: function (data) {
                                otable.draw();
                                swal("Oops!", "Une erreur s'est produite", "error");
                            }
                        });

                    });
            });
            
            $("body").on("change", ".chk_status", function () {
                
                $.ajax({
                    type: "post",
                    url: "{{ url('admin/banner') }}/" + $(this).val() +"/change",
                    data: {"_token": "{{ csrf_token() }}"},
                    beforeSend: function () {
                        
                    },
                    complete: function (data) {
                        
                        toastr.success("Article modifié avec succès");

                    },
                    error: function (result) {
                    },
                    success: function (result) {
                        //Success Code.
                    }
                });
            });
        });
    </script>
@stop