@extends('layouts.app')
@section('content')
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Are you sure to delete?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div>
                    <form class="row g-3" method="POST" action="{{ route('customer_delete') }}">
                        <input type="hidden" id="customer_id" name="customer_id">
                        @csrf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="POST" action="{{ route('customer_edit') }}">
                        @csrf
                        <input class="form-control" type="hidden" id="cust_id" name="cust_id">
                        <label for="attribute1">Attribute1</label>
                        <input class="form-control" type="text" id="attribute1" name="attribute1">
                        <label for="attribute2">Attribute2</label>
                        <input class="form-control" type="text" id="attribute2" name="attribute2">
                        <label for="attribute3">Attribute3</label>
                        <input class="form-control" type="text" id="attribute3" name="attribute3">
                        <label for="attribute4">Attribute4</label>
                        <input class="form-control" type="text" id="attribute4" name="attribute4">
                        <label for="attribute5">Attribute5</label>
                        <input class="form-control" type="text" id="attribute5" name="attribute5">
                        <label for="attribute6">Attribute6</label>
                        <input class="form-control" type="text" id="attribute6" name="attribute6">
                        <label for="attribute6">Attribute7</label>
                        <input class="form-control" type="text" id="attribute7" name="attribute7">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Add New Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="POST" action="{{ route('customer_add') }}">
                        @csrf
                        <input type="hidden" id="blaster_id" name="blaster_id" value="{{ $blaster->id }}">
                        <label for="attribute1">Attribute1</label>
                        <input class="form-control" type="text" id="attribute1" name="attribute1">
                        <label for="attribute2">Attribute2</label>
                        <input class="form-control" type="text" id="attribute2" name="attribute2">
                        <label for="attribute3">Attribute3</label>
                        <input class="form-control" type="text" id="attribute3" name="attribute3">
                        <label for="attribute4">Attribute4</label>
                        <input class="form-control" type="text" id="attribute4" name="attribute4">
                        <label for="attribute5">Attribute5</label>
                        <input class="form-control" type="text" id="attribute5" name="attribute5">
                        <label for="attribute6">Attribute6</label>
                        <input class="form-control" type="text" id="attribute6" name="attribute6">
                        <label for="attribute7">Attribute7</label>
                        <input class="form-control" type="text" id="attribute7" name="attribute7">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Blaster Image</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img alt="" class="img-fluid image">
                </div>
            </div>
        </div>
    </div>

    <section class="mt-sm-5">
        <div class="container">
            <div class="row">
                <div class="card p-0 rounded-4">
                    <div class="card-header">
                        <h1 class="text-center mb-md-3 mt-md-3">Customer List</h1>
                    </div>
                    <div class="p-4">
                        <div class="input-group mb-3">
                            <input type="hidden" value="{{ $blaster->id }}" name="blaster_id">
                            <h5 style="padding-top:6px; padding-right:5px;">Blaster Name: </h5>
                            <h5 style="padding-top:6px; padding-right:5px;">{{ $blaster->name }}</h5>
                            <div class="input-group-append">
                                <a href="{{ route('blaster_edit', ['id' => $blaster->id]) }}"
                                    class="btn btn-outline-secondary" height="23px" type="submit"><i
                                        class="fa fa-edit"></i>Edit</a>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            @if (isset($blaster->image))
                                <input type="hidden" value="{{ $blaster->id }}" name="blaster_id">
                                <h5 style="padding-top:6px; padding-right:5px;">Image: </h5>
                                <h5 style="padding-top:6px; padding-right:5px;"><a class="viewImage" data-toggle="modal"
                                        data-id="{{ asset('images') }}/{{ $blaster->image }}"
                                        data-target="#imageModal">{{ $blaster->image }}</a></h5>
                            @else
                                  <input type="hidden" value="{{ $blaster->id }}" name="blaster_id">
                                <h5 style="padding-top:6px; padding-right:5px;">Image: </h5>
                                <h5 style="padding-top:6px; padding-right:5px;">None</h5>
                            @endif
                        </div>
                        @CSRF
                        <div class="input-group mb-3">
                            <h5 style="padding-top:6px; padding-right:5px;">Import: </h5>
                            <div class="custom-file">
                            </div>
                            <input type="hidden" value="{{ $blaster->customers->count() }}">
                            <div class="input-group-append">
                                <a class="btn btn-outline-secondary"
                                    href="{{ route('import_view', ['id' => $blaster->id, 'existed' => $blaster->customers->count()]) }}"><i
                                        class="fa fa-upload"></i></a>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <h5 style="padding-top:6px; padding-right:5px;">Add New Customer: </h5>
                            <div class="custom-file">
                            </div>
                            <input type="hidden" value="{{ $blaster->customers->count() }}">
                            <div class="input-group-append">
                                <a class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addModal"><i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <h5 style="padding-top:6px; padding-right:5px;">Download Template: </h5>
                            <div class="custom-file">
                            </div>
                            <div class="input-group-append">
                                <a href="{{route('template_download')}}" class="btn btn-outline-secondary"><i class="bi bi-download"></i></a>
                            </div>
                        </div>
                        <table id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    {{-- <th>Customer Id</th> --}}
                                    <th>Attribute1</th>
                                    <th>Attribute2</th>
                                    <th>Attribute3</th>
                                    <th>Attribute4</th>
                                    <th>Attribute5</th>
                                    <th>Attribute6</th>
                                    <th>Attribute7</th>
                                    <th colspan="2" style="text-align: center">Operate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($blaster->customers->isNotEmpty())
                                    @foreach ($blaster->customers as $key => $customer)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            {{-- <td>{{ $customer->id }}</td> --}}
                                            <td>{{ $customer->attribute1 }}</td>
                                            <td>{{ $customer->attribute2 }}</td>
                                            <td>{{ $customer->attribute3 }}</td>
                                            <td>{{ $customer->attribute4 }}</td>
                                            <td>{{ $customer->attribute5 }}</td>
                                            <td>{{ $customer->attribute6 }}</td>
                                            <td>{{ $customer->attribute7 }}</td>
                                            <td>
                                                <button value="{{ $customer }}"
                                                    class="btn btn-success btnEdit">Edit</button>
                                            </td>
                                            <td>
                                                <button value="{{ $customer->id }}"
                                                    class="btn btn-danger btnDelete">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">Add Customer List now!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script>
    //for using bootstrap js need to use '$(document).ready(function (){' and above src to call
    $(document).ready(function() {
        //id should be unique so instead of using id it is better to use class
        $('.btnDelete').click(function() {
            // var user_id = {{ $blaster->user_id }};
            // alert(user_id);
            var customer_id = $(this).val();
            $('#customer_id').val(customer_id);
            $('#deleteModal').modal('show');
        });
        //edit button
        $('.btnEdit').click(function() {
            var customer = $(this).val();
            var myCustomer = JSON.parse(customer);
            var customer_id = myCustomer.id;
            // alert(customer_id);
            $('#cust_id').val(customer_id);
            $('#attribute1').val(myCustomer.attribute1);
            $('#attribute2').val(myCustomer.attribute2);
            $('#attribute3').val(myCustomer.attribute3);
            $('#attribute4').val(myCustomer.attribute4);
            $('#attribute5').val(myCustomer.attribute5);
            $('#attribute6').val(myCustomer.attribute6);
            $('#attribute7').val(myCustomer.attribute7);
            $('#editModal').modal('show');
        });
        //view blaster image
        $('.viewImage').click(function() {

            var image = $(this).data('id');
            console.log(image);
            $('.image').attr('src', image);
            $('#imageModal').modal('show');
        });
    });
</script>
