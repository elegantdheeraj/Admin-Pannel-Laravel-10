@extends('backend.layout.app')
@section('style_content')
    <style>
        .div-h-200 {
            height: 200px;
            overflow-y: scroll;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/checkTree/checktree.css') }}" />
@endSection
@section('body_content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Waao! </strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif((session('warning')))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Ooh! </strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif((session('error')))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Sorry! </strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="col-md-12 p-2">
            <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-sm-row flex-column mb-3 mb-md-0">
                <div id="" class="m-1">
                    <form id="filter-data-search-form" action="" method="get">
                        <label><input type="input" class="form-control" name="search_key" value="{{ request()->get('search_key') }}" placeholder="Search.." aria-controls="" onkeypress="filter_data()" ></label>
                    </form>
                </div>
                @if(request()->has('search_key') && request()->get('search_key'))
                    <button class="btn btn-danger m-1" tabindex="0" onclick="window.location.href = '{{ url('backend/user/roles') }}'" aria-controls="" type="button">
                        <i class="bx bx-x-circle"></i>
                    </button>
                @endif
                <div class="dt-buttons btn-group flex-wrap m-1">
                    {{-- <button class="btn buttons-collection dropdown-toggle btn-label-secondary mx-3" tabindex="0" aria-controls="" type="button" aria-haspopup="dialog" aria-expanded="false"><span><i class="bx bx-export me-1"></i>Export</span></button> --}}
                    <button class="btn add-new btn-primary" tabindex="0" aria-controls="" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRole"><span><i
                                class="bx bx-plus me-0 me-sm-1"></i><span class="">Add New
                                Role</span></span></button>
                </div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top dataTable no-footer dtr-column" id=""
                aria-describedby="">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Access & Permissions</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($roles->isNotEmpty())
                        @foreach ($roles as $role)
                            <tr>
                                <td><span class="text-truncate d-flex align-items-center">{{ $role->name }}</span></td>
                                <td class="text-break">
                                    {{ $role->access_and_pemissions ? $role->access_and_pemissions : 'NA' }}</span></td>
                                <td class="text-center">
                                    @if ($role->status == 0)
                                        <span class="badge bg-label-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-label-success">Active</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-sm btn-icon" id="edit-role-btn" onclick="editRole('{{ $role->id }}', '{{ $role->name }}', '{{ $role->code }}', '{{$role->access_and_pemissions}}', '{{$role->status}}')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditRole"><i class="bx bx-edit"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td class="text-danger" colspan="99">No Record Found</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12 p-2">
        {{ $roles->appends(Request::all())->links() }}
    </div>
    <!-- Role add form -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddRole" aria-labelledby="offcanvasAddRoleLabel"
        aria-modal="true" role="dialog">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddRoleLabel" class="offcanvas-title">Add Role</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form action="{{ url('backend/role/add') }}" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework needs-validation" id="addNewUserForm" novalidate method="post">
                @csrf
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="role-name">Role Name</label>
                    <input type="text" class="form-control" id="role-name" placeholder="Enter Role Name"
                        name="role_name" aria-label="Enter Role Name" value="{{ old('role_name') }}" required>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="role-code">Role Code</label>
                        <input type="text" id="role-code" class="form-control" placeholder="Enter Role Code"
                            aria-label="Enter Role Code" name="role_code" value="{{ old('role_code') }}" required>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-4 col-6">
                        <label class="form-label" for="user-plan">Select Status</label>
                        <select id="role-status" name="role_status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="role-access-permission">Access & Permissions</label>
                    <div class="form-control div-h-200">
                        <ul class="tree addRoleTree">
                            @foreach ($role_access_permissions as $level1)
                                @if(!isset($level1['child']))
                                    <li>
                                        <input type="checkbox" name="role_access_permissions[{{ $level1['slag'] }}]" value="true">
                                        <label class="{{ !$level1['is_visible'] ? 'text-warning' : '' }}">{{ $level1['name'] }} </label>
                                    </li>
                                @else
                                    <li>
                                        <input type="checkbox" name="role_access_permissions[{{ $level1['slag'] }}]" value="true">
                                        <label>{{ $level1['name'] }}</label>
                                        <ul>
                                            @foreach ($level1['child'] as $level2)
                                                @if(!isset($level2['child']))
                                                    <li>
                                                        <input type="checkbox" name="role_access_permissions[{{ $level2['slag'] }}]" value="true">
                                                        <label class="{{ !$level2['is_visible'] ? 'text-warning' : '' }}">{{ $level2['name'] }} </label>
                                                    </li>
                                                @else
                                                    <li>
                                                        <input type="checkbox" name="role_access_permissions[{{ $level2['slag'] }}]" value="true">
                                                        <label class="{{ !$level2['is_visible'] ? 'text-warning' : '' }}">{{ $level2['name'] }} </label>
                                                        <ul class="menu-sub">
                                                            @foreach ($level2['child'] as $level3)
                                                                <li>
                                                                    <input type="checkbox" name="role_access_permissions[{{ $level3['slag'] }}]" value="true">
                                                                    <label class="{{ !$level3['is_visible'] ? 'text-warning' : '' }}">{{ $level3['name'] }} </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    {{-- <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="+1 (609) 988-44-11" aria-label="9838122252" name="userMobile"> --}}
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </form>
        </div>
    </div>
    <!-- Role edit form -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditRole" aria-labelledby="offcanvasEditRoleLabel"
        aria-modal="true" role="dialog">
        <div class="offcanvas-header">
            <h5 id="offcanvasEditRoleLabel" class="offcanvas-title">Edit Role</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form action="{{ url('backend/role/edit') }}" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework needs-validation" id="addNewUserForm" novalidate method="post">
                @csrf
                <input type="hidden" id="edit-role_id" name="role_id" />
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="edit-role-name">Role Name</label>
                    <input type="text" class="form-control" id="edit-role-name" placeholder="Enter Role Name"
                        name="role_name" aria-label="Enter Role Name" value="{{ old('role_name') }}" required>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="edit-role-code">Role Code</label>
                        <input type="text" id="edit-role-code" class="form-control" placeholder="Enter Role Code"
                            aria-label="Enter Role Code" name="role_code" value="{{ old('role_code') }}" required>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="mb-4 col-6">
                        <label class="form-label" for="user-plan">Select Status</label>
                        <select id="edit-role-status" name="role_status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="role-access-permission">Access & Permissions</label>
                    <div class="form-control div-h-200">
                        <ul class="tree editRoleTree">
                            @foreach ($role_access_permissions as $level1)
                                @if(!isset($level1['child']))
                                    <li>
                                        <input type="checkbox" name="role_access_permissions[{{ $level1['slag'] }}]" data-slag="{{ $level1['slag'] }}" value="true">
                                        <label class="{{ !$level1['is_visible'] ? 'text-warning' : '' }}">{{ $level1['name'] }} </label>
                                    </li>
                                @else
                                    <li>
                                        <input type="checkbox" name="role_access_permissions[{{ $level1['slag'] }}]" data-slag="{{ $level1['slag'] }}" value="true">
                                        <label class="{{ !$level1['is_visible'] ? 'text-warning' : '' }}">{{ $level1['name'] }}</label>
                                        <ul>
                                            @foreach ($level1['child'] as $level2)
                                                @if(!isset($level2['child']))
                                                    <li>
                                                        <input type="checkbox" name="role_access_permissions[{{ $level2['slag'] }}]" data-slag="{{ $level2['slag'] }}" value="true">
                                                        <label class="{{ !$level2['is_visible'] ? 'text-warning' : '' }}">{{ $level2['name'] }} </label>
                                                    </li>
                                                @else
                                                    <li>
                                                        <input type="checkbox" name="role_access_permissions[{{ $level2['slag'] }}]" data-slag="{{ $level2['slag'] }}" value="true">
                                                        <label class="{{ !$level2['is_visible'] ? 'text-warning' : '' }}">{{ $level2['name'] }} </label>
                                                        <ul class="menu-sub">
                                                            @foreach ($level2['child'] as $level3)
                                                                <li>
                                                                    <input type="checkbox" name="role_access_permissions[{{ $level3['slag'] }}]" data-slag="{{ $level3['slag'] }}" value="true">
                                                                    <label class="{{ !$level3['is_visible'] ? 'text-warning' : '' }}">{{ $level3['name'] }} </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    {{-- <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="+1 (609) 988-44-11" aria-label="9838122252" name="userMobile"> --}}
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </form>
        </div>
    </div>
@endSection
@section('script_content')
    <script src="{{ asset('assets/vendor/libs/checkTree/jquery.checktree.js') }}"></script>
    <script>
        $(function(){
            $('ul.tree').checkTree({
                labelAction: "expand",
            });
        });
        function editRole(id, name, code, access_and_pemissions, status) {
            $("#edit-role_id").val(id);
            $("#edit-role-name").val(name);
            $("#edit-role-code").val(code);
            $("#edit-role-status").val(status);
            if(access_and_pemissions) {
                unset();
                access_and_pemissions = Object.keys($.parseJSON(access_and_pemissions));
                $('.editRoleTree input[type="checkbox"]').each(function(index, elem) {
                    if($.inArray($(elem).data('slag'), access_and_pemissions) !== -1) {
                        $(elem).prop('checked',true).siblings('.checkbox')
                                .addClass('checked').parents("ul:first").siblings(":checkbox:first").trigger('refresh');
                    }
                });
            }
        }
        function unset() {
            $('ul.tree').find('.checkbox')
            .removeClass('checked half_checked')
            .siblings(':checkbox').prop('checked', false);
        }
        function filter_data() {
            if (event.key === "Enter") {
                document.getElementById('filter-data-search-form').submit();
            }
        }
    </script>
@endSection
