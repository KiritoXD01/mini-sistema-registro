@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.teachers'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-chalkboard-teacher"></i> @lang('messages.teachers')
        </h1>
        @can('teacher-create')
        <div class="btn-group">
            <a href="{{ route('teacher.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.teacher')
            </a>
            <button type="button" class="d-none d-sm-inline-block btn btn-warning shadow-sm" id="btnModalImport">
                <i class="fa fa-file-excel"></i> @lang('messages.import') @lang('messages.teachers')
            </button>
            <a href="{{ route('teacher.export') }}" class="d-none d-sm-inline-block btn btn-success shadow-sm" id="btnModalExport">
                <i class="fa fa-file-excel"></i> @lang('messages.export') @lang('messages.teachers')
            </a>
        </div>
        @endcan
    </div>
    <!-- End Page Heading -->

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover" id="datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>@lang('messages.fistName')</th>
                            <th>@lang('messages.lastName')</th>
                            <th>Email</th>
                            <th>@lang('messages.code')</th>
                            <th>@lang('messages.status')</th>
                            <td>@lang('messages.actions')</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($teachers as $teacher)
                        <tr class="text-center">
                            <td>{{ $teacher->firstname }}</td>
                            <td>{{ $teacher->lastname }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->code }}</td>
                            <td>
                                @if($teacher->status)
                                    <span class="badge badge-primary">@lang('messages.enabled')</span>
                                @else
                                    <span class="badge badge-danger">@lang('messages.disabled')</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('teacher.destroy', $teacher->id) }}" method="post" id="formDelete{{ $teacher->id }}">
                                    @method("DELETE")
                                    @csrf
                                    <div class="btn-group" role="group">
                                        @can('teacher-show')
                                            <a href="{{ route('teacher.show', $teacher->id) }}" class="btn btn-primary">
                                                <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                            </a>
                                        @endcan
                                        @can('teacher-edit')
                                            <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-info">
                                                <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                            </a>
                                        @endcan
                                        @can('teacher-delete')
                                            @if($teacher->status)
                                                <input type="hidden" name="status" value="0">
                                                <button type="button" class="btn btn-danger" onclick="deleteItem('{{ $teacher }}')">
                                                    <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                                </button>
                                            @else
                                                <input type="hidden" name="status" value="1">
                                                <button type="button" class="btn btn-primary" onclick="deleteItem('{{ $teacher }}')">
                                                    <i class="fa fa-check-square fa-fw"></i> @lang('messages.enable')
                                                </button>
                                            @endif
                                        @endcan
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Table -->

    <!-- The Modal -->
    <form action="{{ route('teacher.import') }}" autocomplete="off" method="post" id="FormImport">
        @csrf
        <div class="modal fade" id="ModalImport">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('messages.import') @lang('messages.teachers')</h4>
                        <button type="button" class="close" onclick="closeModal()">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.fistName')</th>
                                        <th>@lang('messages.lastName')</th>
                                        <th>Email</th>
                                        <th>@lang('messages.password')</th>
                                        <th>@lang('messages.delete')</th>
                                    </tr>
                                </thead>
                                <tbody id="listItemsToAdd">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <button type="button" class="btn btn-primary btn-block" id="BtnAddTeacher">
                                                <i class="fa fa-plus fa-fw"></i> @lang('messages.add') @lang('messages.teacher')
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td style="width: 50%;">
                                    <button type="button" class="btn btn-warning btn-block" onclick="closeModal()">
                                        <i class="fa fa-undo fa-fw"></i> @lang('messages.close')
                                    </button>
                                </td>
                                <td style="width: 50%;">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fa fa-save fa-fw"></i> @lang('messages.create') @lang('messages.teachers')
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- End Modal -->
@endsection

@section('javascript')
    <script>
        function deleteItem(item) {
            item = JSON.parse(item);

            Swal
                .fire({
                    title: (item.status) ? "@lang('messages.confirmTeacherDeactivation')" : "@lang('messages.confirmTeacherActivation')",
                    icon: 'question',
                    showCancelButton: true,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: "@lang('messages.yes')",
                    cancelButtonText: "No",
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "@lang('messages.pleaseWait')",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading();
                                document.getElementById(`formDelete${item.id}`).submit();
                            }
                        });
                    }
                });
        }

        function checkEmail(element)
        {
            if (element.checkValidity())
            {
                $.get("{{ route('teacher.checkEmail') }}", {
                    email: element.value
                },
                function(result)
                {
                    if (result.email) {
                        element.classList.add("is-invalid");
                    }
                    else {
                        element.classList.remove("is-invalid");
                    }
                });
            }            
        }

        function addItem()
        {
            const id = Date.now();

            let html =
                `
                <tr id="teacher-${id}">
                    <td>
                        <div class="form-group">
                            <input type="text" name="firstname[]" value="" maxlength="255" class="form-control" placeholder="@lang('messages.fistName')..." required />
                        </div>                        
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="lastname[]" value="" maxlength="255" class="form-control" placeholder="@lang('messages.lastName')..." required />
                        </div>                        
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="email" name="email[]" value="" maxlength="255" class="form-control" placeholder="Email..." required onfocusout="checkEmail(this);" />
                            <div class="invalid-feedback">@lang("messages.emailExists")</div>
                        </div>                        
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="password" name="password[]" maxlength="255" minlength="8" value="" class="form-control" placeholder="@lang('messages.password')..." required />
                        </div>                        
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-block" onclick="removeItem(${id})">
                            <i class="fa fa-trash fa-fw"></i>
                        </button>
                    </td>
                </tr>
                `;
            $("#listItemsToAdd").append(html);
        }

        function removeItem(id)
        {
            const items = $("#listItemsToAdd tr").length;

            if (items > 1)
            {
                $(`#teacher-${id}`).remove();
            }
            else
            {
                $(`#teacher-${id} input`).val("");
                $(`#teacher-${id} input`).removeClass("is-invalid");
            }
        }

        function closeModal()
        {
            $("#listItemsToAdd").html("");
            $("#ModalImport").modal("hide");
        }

        $(document).ready(function(){
            $("#datatable").dataTable();

            $("#btnModalImport").click(function(){
                addItem();
                $("#ModalImport").modal({
                    backdrop: 'static'
                });
            });

            $("#FormImport").submit(function(){
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $("#BtnAddTeacher").click(function(){
                addItem();
            });
        });
    </script>
@endsection
