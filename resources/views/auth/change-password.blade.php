@extends('layout.backend.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-account.html"><i
                                    class="icon-base ti tabler-users icon-sm me-1_5"></i> Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i
                                    class="icon-base ti tabler-lock icon-sm me-1_5"></i> Security</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-billing.html"><i
                                    class="icon-base ti tabler-bookmark icon-sm me-1_5"></i> Billing & Plans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                    class="icon-base ti tabler-bell icon-sm me-1_5"></i> Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-connections.html"><i
                                    class="icon-base ti tabler-link icon-sm me-1_5"></i> Connections</a>
                        </li>
                    </ul>
                </div>
                <!-- Change Password -->
                <div class="card mb-6">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body pt-1">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form id="formAccountSettings" method="POST" action="{{ route('change.password') }}">
                            @csrf
                            <div class="row mb-sm-6 mb-2">
                                <div class="col-md-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="current_password">Current Password</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" name="current_password"
                                            id="current_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-sm-6 gy-2 mb-sm-0 mb-2">
                                <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="new_password">New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" id="new_password" name="new_password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                    </div>
                                </div>

                                <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" name="new_password_confirmation"
                                            id="new_password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-body">Password Requirements:</h6>
                            <ul class="ps-4 mb-0">
                                <li class="mb-4">Minimum 8 characters long - the more, the better</li>
                                <li class="mb-4">At least one lowercase character</li>
                                <li>At least one number, symbol, or whitespace character</li>
                            </ul>
                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary me-3">Save changes</button>
                                <button type="reset" class="btn btn-label-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Change Password -->

                <!-- Recent Devices -->
                <div class="card mb-6">
                    <h5 class="card-header">Recent Devices</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-truncate">Browser</th>
                                    <th class="text-truncate">Device</th>
                                    <th class="text-truncate">Location</th>
                                    <th class="text-truncate">Recent Activities</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium">
                                        <i
                                            class="icon-base ti tabler-brand-windows icon-md align-top text-info me-2"></i>Chrome
                                        on Windows
                                    </td>
                                    <td class="text-truncate">HP Spectre 360</td>
                                    <td class="text-truncate">Switzerland</td>
                                    <td class="text-truncate">10, July 2021 20:07</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium">
                                        <i
                                            class="icon-base ti tabler-device-mobile icon-md align-top text-danger me-2"></i>Chrome
                                        on iPhone
                                    </td>
                                    <td class="text-truncate">iPhone 12x</td>
                                    <td class="text-truncate">Australia</td>
                                    <td class="text-truncate">13, July 2021 10:10</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium">
                                        <i
                                            class="icon-base ti tabler-brand-android icon-md align-top text-success me-2"></i>Chrome
                                        on Android
                                    </td>
                                    <td class="text-truncate">Oneplus 9 Pro</td>
                                    <td class="text-truncate">Dubai</td>
                                    <td class="text-truncate">14, July 2021 15:15</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium">
                                        <i class="icon-base ti tabler-brand-apple icon-md align-top me-2"></i>Chrome on
                                        MacOS
                                    </td>
                                    <td class="text-truncate">Apple iMac</td>
                                    <td class="text-truncate">India</td>
                                    <td class="text-truncate">16, July 2021 16:17</td>
                                </tr>
                                <tr>
                                    <td class="text-truncate text-heading fw-medium">
                                        <i
                                            class="icon-base ti tabler-brand-windows icon-md align-top text-warning me-2"></i>Chrome
                                        on Windows
                                    </td>
                                    <td class="text-truncate">HP Spectre 360</td>
                                    <td class="text-truncate">Switzerland</td>
                                    <td class="text-truncate">20, July 2021 21:01</td>
                                </tr>
                                <tr class="border-transparent">
                                    <td class="text-truncate text-heading fw-medium">
                                        <i
                                            class="icon-base ti tabler-brand-android icon-md align-top text-success me-2"></i>Chrome
                                        on Android
                                    </td>
                                    <td class="text-truncate">Oneplus 9 Pro</td>
                                    <td class="text-truncate">Dubai</td>
                                    <td class="text-truncate">21, July 2021 12:22</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Recent Devices -->
            </div>
        </div>
    </div>
@endsection

