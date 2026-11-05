@extends('backEnd.admin.layouts.master')

@section('title')
    Courier API Settings
@endsection

@section('content')
    <div class="page-header d-print-none mt-2">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title text-primary fw-bold">
                        <i class="ti ti-truck-delivery me-2"></i> Courier API Integrations
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body mt-2">
        <div class="container-xl">
            <div class="row row-cards">


                <!-- ========================================== -->
                <!-- 2. STEADFAST API CARD                      -->
                <!-- ========================================== -->
                <div class="col-md-6 col-12">
                    <div class="card card-md shadow-sm border-0 rounded-3 mb-4">
                        <div
                            class="card-header bg-blue-lt border-bottom-0  d-flex align-items-center justify-content-between py-2 px-3">
                            <div class="d-flex align-items-center gap-2">
                                <!-- Courier Image Container: 150x75 -->
                                <div class="bg-white p-2 border rounded shadow-xs d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 40px;">
                                    <img src="{{ asset('steadfast.svg') }}" alt="Steadfast"
                                        class="object-fit-contain w-100 h-100">
                                </div>
                                <h3 class="card-title mb-0 fw-bold text-dark">Steadfast Courier</h3>
                            </div>
                            <span
                                class="badge {{ !empty($steadfast->status) ? 'bg-success' : 'bg-danger' }} px-2 py-1 rounded-pill fs-6">
                                {{ !empty($steadfast->status) ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.steadfast.api.update') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label required">API Key</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon"><i class="ti ti-key"></i></span>
                                        <input type="text" class="form-control"
                                            value="{{ $steadfast->config['api_key'] ?? null }}" name="api_key"
                                            placeholder="Enter Steadfast API Key">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Secret Key</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon"><i class="ti ti-lock-access"></i></span>
                                        <input type="text" class="form-control"
                                            value="{{ $steadfast->config['secret_key'] ?? null }}" name="secret_key"
                                            placeholder="Enter Secret Key">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon"><i class="ti ti-user"></i></span>
                                            <input type="text" class="form-control"
                                                value="{{ $steadfast->username ?? null }}" name="username"
                                                placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon"><i class="ti ti-lock"></i></span>
                                            <input type="password" class="form-control"
                                                value="{{ $steadfast->password ?? null }}" name="password"
                                                placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between pt-3 mt-4 border-top">
                                    <label class="form-check form-switch m-0 cursor-pointer">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            @if (!empty($steadfast->status)) checked @endif>
                                        <span class="form-check-label fw-semibold">Enable Steadfast API</span>
                                    </label>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                                        <i class="ti ti-device-floppy fs-4"></i> Save Steadfast
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>






                <!-- ========================================== -->
                <!-- 4. REDX API CARD                           -->
                <!-- ========================================== -->
                <div class="col-md-6 col-12">
                    <div class="card card-md shadow-sm border-0 rounded-3 mb-4">
                        <div
                            class="card-header bg-blue-lt border-bottom-0 bg-body-tertiary d-flex align-items-center justify-content-between py-2 px-3">
                            <div class="d-flex align-items-center gap-2">
                                <!-- Courier Image Container: 150x75 -->
                                <div class="bg-white p-2 border rounded shadow-xs d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 40px;">
                                    <img src="{{ asset('redx.svg') }}" alt="RedX"
                                        class="object-fit-contain w-100 h-100">
                                </div>
                                <h3 class="card-title mb-0 fw-bold text-dark">Redx Logistics</h3>
                            </div>
                            <span
                                class="badge {{ !empty($redx->status) ? 'bg-success' : 'bg-danger' }} px-2 py-1 rounded-pill fs-6">
                                {{ !empty($redx->status) ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.redx.api.update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon"><i class="ti ti-user"></i></span>
                                            <input type="text" class="form-control"
                                                value="{{ $redx->username ?? null }}" name="username"
                                                placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon"><i class="ti ti-lock"></i></span>
                                            <input type="password" class="form-control"
                                                value="{{ $redx->password ?? null }}" name="password"
                                                placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">API Token</label>
                                    <textarea class="form-control" name="api_token" rows="3" placeholder="Paste Redx API Bearer Token">{{ $redx->config['api_token'] ?? null }}</textarea>
                                </div>

                                <div class="d-flex align-items-center justify-content-between pt-3 mt-4 border-top">
                                    <label class="form-check form-switch m-0 cursor-pointer">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            @if (!empty($redx->status)) checked @endif>
                                        <span class="form-check-label fw-semibold">Enable Redx API</span>
                                    </label>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                                        <i class="ti ti-device-floppy fs-4"></i> Save Redx
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 3. CARRYBEE API CARD                       -->
                <!-- ========================================== -->
                <div class="col-md-6 col-12">
                    <div class="card card-md shadow-sm border-0 rounded-3 mb-4">
                        <div
                            class="card-header bg-blue-lt border-bottom-0 bg-body-tertiary d-flex align-items-center justify-content-between py-2 px-3">
                            <div class="d-flex align-items-center gap-2">
                                <!-- Courier Image Container: 150x75 -->
                                <div class="bg-white p-2 border rounded shadow-xs d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 40px;">
                                    <img src="{{ asset('carrybee.png') }}" alt="Carrybee"
                                        class="object-fit-contain w-100 h-100">
                                </div>
                                <h3 class="card-title mb-0 fw-bold text-dark">Carrybee Express</h3>
                            </div>
                            <span
                                class="badge {{ !empty($carrybee->status) ? 'bg-success' : 'bg-danger' }} px-2 py-1 rounded-pill fs-6">
                                {{ !empty($carrybee->status) ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.carrybee.api.update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Store ID</label>
                                        <input type="text" class="form-control"
                                            value="{{ $carrybee->config['store_id'] ?? null }}" name="store_id"
                                            placeholder="Store ID">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Client ID</label>
                                        <input type="text" class="form-control"
                                            value="{{ $carrybee->config['client_id'] ?? null }}" name="client_id"
                                            placeholder="Client ID">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Client Secret</label>
                                    <input type="text" class="form-control"
                                        value="{{ $carrybee->config['client_secret'] ?? null }}" name="client_secret"
                                        placeholder="Client Secret">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Client Context</label>
                                    <input type="text" class="form-control"
                                        value="{{ $carrybee->config['client_context'] ?? null }}" name="client_context"
                                        placeholder="Client Context">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control"
                                            value="{{ $carrybee->username ?? null }}" name="username"
                                            placeholder="Username">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control"
                                            value="{{ $carrybee->password ?? null }}" name="password"
                                            placeholder="••••••••">
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between pt-3 mt-2 border-top">
                                    <label class="form-check form-switch m-0 cursor-pointer">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            @if (!empty($carrybee->status)) checked @endif>
                                        <span class="form-check-label fw-semibold">Enable Carrybee API</span>
                                    </label>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                                        <i class="ti ti-device-floppy fs-4"></i> Save Carrybee
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- 1. PATHAO API CARD                         -->
                <!-- ========================================== -->
                <div class="col-md-6 col-12">
                    <div class="card card-md shadow-sm border-0 rounded-3 mb-4">
                        <div
                            class="card-header bg-blue-lt border-bottom-0 bg-body-tertiary d-flex align-items-center justify-content-between py-2 px-3">
                            <div class="d-flex align-items-center gap-2">
                                <!-- Courier Image Container: 150x75 -->
                                <div class="bg-white p-2 border rounded shadow-xs d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 40px;">
                                    <img src="{{ asset('pathao.svg') }}" alt="Pathao"
                                        class="object-fit-contain w-100 h-100">
                                </div>
                                <h3 class="card-title mb-0 fw-bold text-dark">Pathao Courier</h3>
                            </div>
                            <span
                                class="badge {{ !empty($pathao->status) ? 'bg-success' : 'bg-danger' }} px-2 py-1 rounded-pill fs-6">
                                {{ !empty($pathao->status) ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.pathao.api.update') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label required">Client ID</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon"><i class="ti ti-key"></i></span>
                                        <input type="text" class="form-control"
                                            value="{{ $pathao->config['client_id'] ?? null }}" name="client_id"
                                            placeholder="Enter Pathao Client ID">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Store ID</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon"><i class="ti ti-building-store"></i></span>
                                        <input type="text" class="form-control"
                                            value="{{ $pathao->config['store_id'] ?? null }}" name="store_id"
                                            placeholder="Enter Store ID">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon"><i class="ti ti-user"></i></span>
                                            <input type="text" class="form-control"
                                                value="{{ $pathao->username ?? null }}" name="username"
                                                placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon"><i class="ti ti-lock"></i></span>
                                            <input type="password" class="form-control"
                                                value="{{ $pathao->password ?? null }}" name="password"
                                                placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Client Secret</label>
                                    <textarea class="form-control" name="client_secret" rows="2" placeholder="Enter Client Secret">{{ $pathao->config['client_secret'] ?? null }}</textarea>
                                </div>

                                <div class="d-flex align-items-center justify-content-between pt-2">
                                    <label class="form-check form-switch m-0 cursor-pointer">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            @if (!empty($pathao->status)) checked @endif>
                                        <span class="form-check-label fw-semibold">Enable Pathao API</span>
                                    </label>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                                        <i class="ti ti-device-floppy fs-4"></i> Save Pathao
                                    </button>
                                </div>
                            </form>

                            <hr class="my-4 border-dashed">

                            <!-- Token Generator Section -->
                            <div class="bg-light p-3 rounded-3 border">
                                <h5 class="fw-bold mb-3 text-secondary d-flex align-items-center gap-1">
                                    <i class="ti ti-shield-lock"></i> Pathao OAuth Tokens
                                </h5>
                                <form action="{{ route('admin.api.pathao.generate') }}" method="post">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label fs-6 text-muted mb-1">Access Token</label>
                                        <textarea rows="2" class="form-control form-control-sm bg-white font-monospace" readonly>{{ $pathao->config['access_token'] ?? null }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fs-6 text-muted mb-1">Refresh Token</label>
                                        <textarea rows="2" class="form-control form-control-sm bg-white font-monospace" readonly>{{ $pathao->config['refresh_token'] ?? null }}</textarea>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-outline-info  w-100 d-inline-flex align-items-center justify-content-center gap-1">
                                        <i class="ti ti-refresh"></i> Generate New Access Token
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
