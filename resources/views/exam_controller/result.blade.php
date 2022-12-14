@extends('layouts.backend.app')

@section('title', 'Result')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Result</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ strtoupper('Result of '. $semester->name ) }}
                                    @if(isset($check_approval) && $check_approval->status == 1)
                                        <a target="_blank" href="{{ route('exam_controller.marks.download', [$students[0]->dept->slug ,$session->id, $year->id, $semester->id]) }}" class="btn btn-sm btn-info text-white ml-5 float-right">Download PDF</a>
                                        <span class="btn btn-sm btn-success float-right">Approved</span>
                                    @else
                                        <span class="btn btn-sm btn-danger float-right">Not Approved</span>
                                    @endif
                                    <span class="ml-5">SESSION : {{ $session->name }}</span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Hall Name</th>
                                        <th>Class Roll</th>
                                        <th>Exam Roll</th>
                                        <th>Student Name</th>
                                        <th>GPA</th>
                                        <th width="10%">Details Results</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $key => $student)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $student->hall }}</td>
                                                <td>{{ $student->class_roll }}</td>
                                                <td>{{ $student->exam_roll }}</td>
                                                <td>{{ $student->name  }}</td>
                                                <td>
                                                    {{ gpa_calculate($student->session, $semester->id , $student->reg_no, $student->exam_roll) }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('exam_controller.marks.marks_sheet', [$student->dept->slug, $session->id, $year_semester_id, $student->exam_roll]) }}" class="btn btn-sm btn-info">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div> <!-- Content Wrapper end -->
@endsection




@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>

    <!-- Sweet Alert Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>


    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>


    <script type="text/javascript">
        function deleteItem(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>



@endpush
