@extends('backend.layout.app')
@section('body_content')
    {{-- <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Session</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">21,459</h4>
                                <small class="text-success">(+29%)</small>
                            </div>
                            <p class="mb-0">Total Users</p>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-user bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Paid Users</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">4,567</h4>
                                <small class="text-success">(+18%)</small>
                            </div>
                            <p class="mb-0">Last week analytics </p>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-user-check bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Active Users</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">19,860</h4>
                                <small class="text-danger">(-14%)</small>
                            </div>
                            <p class="mb-0">Last week analytics</p>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-group bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Pending Users</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">237</h4>
                                <small class="text-success">(+42%)</small>
                            </div>
                            <p class="mb-0">Last week analytics</p>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-user-voice bx-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
        {{-- <div class="card-header border-bottom">
            <h5 class="card-title">Search Filter</h5>
            <div class="row py-3 gap-3 gap-md-0">
                <div class="col-md-4 user_role">
                    <select id="UserRole" class="form-select text-capitalize">
                        <option value=""> Select Role </option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->code }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 user_status">
                    <select id="FilterTransaction" class="form-select text-capitalize">
                        <option value=""> Select Status </option>
                        <option value="Pending" class="text-capitalize">Pending</option>
                        <option value="Active" class="text-capitalize">Active</option>
                        <option value="Inactive" class="text-capitalize">Inactive</option>
                    </select>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12 p-2">
            <div
                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                <div id="" class="m-1">
                    <form id="filter-data-search-form" action="" method="get">
                        <label><input type="text" class="form-control" name="search_key" value="{{ request()->get('search_key') }}" placeholder="Search.." aria-controls=""></label>
                    </form>
                </div>
                @if(request()->has('search_key') && request()->get('search_key'))
                    <button class="btn btn-danger m-1" tabindex="0" onclick="window.location.href = '{{ url('backend/user/list') }}'" aria-controls="" type="button">
                        <i class="bx bx-x-circle"></i>
                    </button>
                @endif
                @if(\App\Models\User::hasAccess('backend/user/add'))
                    <div class="dt-buttons btn-group flex-wrap m-1">
                        {{-- <button class="btn buttons-collection dropdown-toggle btn-label-secondary mx-3" tabindex="0" aria-controls="" type="button" aria-haspopup="dialog" aria-expanded="false"><span><i class="bx bx-export me-1"></i>Export</span></button> --}}
                        <button class="btn btn-secondary add-new btn-primary" tabindex="0" aria-controls="" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><span><i
                                    class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New
                                    User</span></span></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top dataTable no-footer dtr-column" id=""
                aria-describedby="">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->isNotEmpty())
                        @foreach ($users as $user)
                            <tr class="even">
                                <td>
                                    <div class="d-flex justify-content-start align-items-center user-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-danger">{{ $user->name[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column"><a href="app-user-view-account.html"
                                                class="text-body text-truncate"><span class="fw-medium">{{ $user->name }}</span></a><small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-truncate d-flex align-items-center">{{ $user->mobile }}</span></td>
                                <td><span class="fw-medium">{{ $user->email }}</span></td>
                                <td>{{ $user->Role ? $user->Role->name : "NA" }}</td>
                                <td>
                                    @if($user->status == 0)
                                        <span class="badge bg-label-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-label-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></button>
                                        @if($user->role != 1)
                                            <a href="{{ url('backend/user/delete/'.$user->id) }}" target="_self" class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i></a>
                                        @endif
                                        <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="app-user-view-account.html" class="dropdown-item">View</a>
                                            <a href="javascript:;" class="dropdown-item">Suspend</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td class="text-danger" colspan="99">No Record Found</td></tr>
                    @endif

                    {{-- <tr class="odd">
                        <td class="  control" tabindex="0" style="display: none;"></td>
                        <td class="sorting_1">
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar avatar-sm me-3"><img src="../../assets/img/avatars/6.png"
                                            alt="Avatar" class="rounded-circle"></div>
                                </div>
                                <div class="d-flex flex-column"><a href="app-user-view-account.html"
                                        class="text-body text-truncate"><span class="fw-medium">Wesley
                                            Burland</span></a><small class="text-muted">wburlandj@uiuc.edu</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-truncate d-flex align-items-center"><span
                                    class="badge badge-center rounded-pill bg-label-info w-px-30 h-px-30 me-2"><i
                                        class="bx bx-edit bx-xs"></i></span>Editor</span></td>
                        <td><span class="fw-medium">Team</span></td>
                        <td>Auto Debit</td>
                        <td><span class="badge bg-label-secondary">Inactive</span></td>
                        <td>
                            <div class="d-inline-block text-nowrap"><button class="btn btn-sm btn-icon"><i
                                        class="bx bx-edit"></i></button><button
                                    class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i></button><button
                                    class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                        class="bx bx-dots-vertical-rounded me-2"></i></button>
                                <div class="dropdown-menu dropdown-menu-end m-0"><a href="app-user-view-account.html"
                                        class="dropdown-item">View</a><a href="javascript:;"
                                        class="dropdown-item">Suspend</a></div>
                            </div>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12 p-2">
        {{ $users->appends(Request::all())->links() }}
    </div>
    <!-- User add form -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel" aria-modal="true" role="dialog">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form action="{{ url('backend/user/add') }}" class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewUserForm" novalidate="validate" method="post">
                @csrf
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-fullname">Full Name</label>
                    <input type="text" class="form-control" id="add-user-fullname" placeholder="Enter Name" name="userFullname" aria-label="Enter Name">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-email">Email</label>
                    <input type="text" id="add-user-email" class="form-control"
                        placeholder="Enter Email" aria-label="Enter Email" name="userEmail">
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="add-user-contact">Mobile</label>
                        <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="Enter Mobile" aria-label="Enter Mobile" name="userMobile">
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="user-role">User Role</label>
                        <select id="user-role" name="userRole" class="form-select">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 fv-plugins-icon-container">
                    <label class="form-label" for="add-user-address">Addree</label>
                    <textarea type="text" id="add-user-address" class="form-control"
                        placeholder="Enter Address" aria-label="Enter Address" name="userAddress" rows=3></textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label class="form-label" for="user-plan">Select Status</label>
                        <select id="user-plan" name="userStatus" class="form-select">
                            <option value="">Select Status</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                <input type="hidden">
            </form>
        </div>
    </div>
@endSection
@section('script_content')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script>
        function filter_data() {
            if (event.key === "Enter") {
                document.getElementById('filter-data-search-form').submit();
            }
        }
    </script>
@endSection
