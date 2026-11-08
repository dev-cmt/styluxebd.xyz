@extends('backEnd.admin.layouts.master')
@section('title')
    Accounts
@endsection

@section('content')
    <div class="page-body mt-3">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Accounts</h2>
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="fw-bold">Total:</span>
                            <span class="badge bg-primary text-white">{{ $data->total() }}</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row row-deck row-cards mt-2">
                <!-- Page Header Close -->
                <div class="col-12 m-0">
                    <div class="card  shadow-sm  rounded" style="border-top:none">
                        <div class="card-header d-flex  align-items-center gap-2">
                            @can('accounts.create')
                                <a href="javascript:void(0);" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-bs-toggle="modal" data-bs-target="#add_modal">
                                    <i class="ti ti-plus"></i>
                                    Add Account
                                </a>
                            @endcan
                            {{-- Clean Production Bulk Delete Button --}}
                            @can('accounts.delete')
                                <button type="button" id="bulk_delete_btn"
                                    class="btn btn-gradient-danger btn-sm d-flex align-items-center gap-1">
                                    <i class="ti ti-trash"></i> Bulk Delete
                                    <span id="selected_count" class="badge bg-white text-danger ms-1 d-none">0</span>
                                </button>
                            @endcan
                        </div>
                        <div class="table-responsive">
                            @include('backEnd.admin.includes.top-paginate', ['items' => $data])
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="w-1">
                                            SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices" id="master">
                                        </th>
                                        <th>Acc. Type</th>
                                        <th>Acc. Info</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Default</th>
                                        <th style="width: 8%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        @php $i = 1; @endphp
                                        @foreach ($data as $item)
                                            <tr @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                                <td class="sl-cell">
                                                    {{ $i++ }}.
                                                    <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                                        data-id="{{ $item->id }}">
                                                </td>
                                                <td>
                                                    @if ($item->account_type == 1)
                                                        Bank
                                                    @elseif($item->account_type == 2)
                                                        Bkash
                                                    @elseif($item->account_type == 3)
                                                        Nagad
                                                    @elseif($item->account_type == 4)
                                                        Rocket
                                                    @elseif($item->account_type == 5)
                                                        Cash
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->account_type == 1)
                                                        <b>Bank Name:</b> {{ $item->bank_name }} <br>
                                                        <b>Branch:</b> {{ $item->branch_name }} <br>
                                                        <b>Routing No.:</b> {{ $item->routing_no }} <br>
                                                        <b>Acc. Name:</b> {{ $item->bank_account_name }} <br>
                                                        <b>Acc. No.:</b> {{ $item->bank_account_no }}
                                                    @elseif($item->account_type == 2)
                                                        <b>Bkash No.:</b> {{ $item->bkash_no }}
                                                    @elseif($item->account_type == 3)
                                                        <b>Nagad No.:</b> {{ $item->nagad_no }}
                                                    @elseif($item->account_type == 4)
                                                        <b>Rocket No.:</b> {{ $item->rocket_no }}
                                                    @elseif($item->account_type == 5)
                                                        <b>Cash</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $web_settings->currency_sign }}{{ number_format($item->balance, 2) }}
                                                </td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('admin.account.status', [$item->id, 0]) }}"><span
                                                                class="badge bg-success">Active</span></a>
                                                    @else
                                                        <a href="{{ route('admin.account.status', [$item->id, 1]) }}"><span
                                                                class="badge bg-danger">Inactive</span></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->is_default == 1)
                                                        <span class="badge bg-success">Default</span>
                                                    @else
                                                        <a onclick="return confirm('Are You Sure?')"
                                                            href="{{ route('admin.account.default.status', [$item->id, 1]) }}"><span
                                                                class="badge bg-danger">Set Default</span></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        @can('accounts.edit')
                                                            <a href="javascript:void(0);"
                                                                class="btn-gradient-info padding-2-6 border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 edit_button"
                                                                data-accounts="{{ $item }}"><i
                                                                    class="ti ti-edit"></i>Edit</a>
                                                        @endcan
                                                        @can('accounts.delete')
                                                            <form action="{{ route('admin.account.delete', $item->id) }}"
                                                                method="POST" id="delete_form">
                                                                @method('DELETE')
                                                                @csrf
                                                            </form>
                                                            <button
                                                                class="btn-gradient-danger padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 btn_delete"><i
                                                                    class="ti ti-trash"></i>Delete</button>
                                                        @endcan
                                                        {{-- <button class="btn btn-sm btn-outline-info add_balance_button" data-id="{{ $item->id }}" data-account_type="{{ $item->account_type }}" data-bank_info="{{ json_encode(['name' => $item->bank_account_name, 'account'=> $item->bank_account_no, 'branch' => $item->branch_name]) }}" data-account_no="{{ $item->account_type == 2 ? $item->bkash_no : ($item->account_type == 3 ? $item->nagad_no : $item->rocket_no) }}">Add balance</button> --}}
                                                        @can('accounts.balance.add')
                                                            <button
                                                                class="btn-gradient-success padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 add_balance_button"
                                                                data-id="{{ $item->id }}">
                                                                <i class="ti ti-plus"></i> Add Balance
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center"> <span class="text-danger"><b>No data
                                                        found.</b></span></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @include('backEnd.admin.includes.bottom-paginate', ['items' => $data])
                        </div>
                    </div>

                    {{-- <div>
                            {{ $data->links('backEnd.admin.includes.paginate') }}
                        </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="add_ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header">
                    <button type="button" class="btn-close btn-sm" style="width: 40px;height:40px" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <h4 class="modal-title ">Add Account
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.account.store') }}" method="POST">
                        @csrf
                        <div class="col-md-12 mb-3">
                            <select name="account_type" id="account_type" class="form-control" required>
                                <option value="1">Bank</option>
                                <option value="2">Bkash</option>
                                <option value="3">Nagad</option>
                                <option value="4">Rocket</option>
                                <option value="5">Cash</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="bank_info">
                                <div class="row mb-3">
                                    <label for="bank_name" class="col-sm-3 col-form-label">Bank Name</label>
                                    <div class="col-sm-9">
                                        <select name="bank_name" id="bank_name" class="form-select">
                                            <option value="{{ null }}"> Select Bank</option>
                                            <option value="AB BANK LIMITED">
                                                AB BANK LIMITED
                                            </option>
                                            <option value="AGRANI BANK LIMITED">
                                                AGRANI BANK LIMITED
                                            </option>
                                            <option value="AL-ARAFAH ISLAMI BANK LTD">
                                                AL-ARAFAH ISLAMI BANK LTD
                                            </option>
                                            <option value="BANGLADESH KRISHI BANK">
                                                BANGLADESH KRISHI BANK
                                            </option>
                                            <option value="BANK ALFALAH LIMITED">
                                                BANK ALFALAH LIMITED
                                            </option>
                                            <option value="BANK ASIA LTD">
                                                BANK ASIA LTD
                                            </option>
                                            <option value="BASIC BANK LIMITED">
                                                BASIC BANK LIMITED
                                            </option>
                                            <option value="Brac Bank Ltd">
                                                Brac Bank Ltd
                                            </option>
                                            <option value="City Bank Ltd">
                                                City Bank Ltd
                                            </option>
                                            <option value="DBBL Agent Banking">
                                                DBBL Agent Banking
                                            </option>
                                            <option value="DHAKA BANK LIMITED">
                                                DHAKA BANK LIMITED
                                            </option>
                                            <option value="Dutch-Bangla Bank Ltd">
                                                Dutch-Bangla Bank Ltd
                                            </option>
                                            <option value="EASTERN BANK LTD">
                                                EASTERN BANK LTD
                                            </option>
                                            <option value="EXIM Bank">
                                                EXIM Bank
                                            </option>
                                            <option value="First Security Islami Bank Limited">
                                                First Security Islami Bank Limited
                                            </option>
                                            <option value="Global Islami Bank ltd">
                                                Global Islami Bank ltd
                                            </option>
                                            <option value="IFIC BANK LTD">
                                                IFIC BANK LTD
                                            </option>
                                            <option value="ISLAMI BANK BANGLADESH LTD">
                                                ISLAMI BANK BANGLADESH LTD
                                            </option>
                                            <option value="JAMUNA BANK LIMITED">
                                                JAMUNA BANK LIMITED
                                            </option>
                                            <option value="Janata Bank Limited">
                                                Janata Bank Limited
                                            </option>
                                            <option value="MERCANTILE BANK LIMITED">
                                                MERCANTILE BANK LIMITED
                                            </option>
                                            <option value="MIDLAND BANK LIMITED">
                                                MIDLAND BANK LIMITED
                                            </option>
                                            <option value="Modhumoti Bank Limited">
                                                Modhumoti Bank Limited
                                            </option>
                                            <option value="MUTUAL TRUST BANK LIMITED">
                                                MUTUAL TRUST BANK LIMITED
                                            </option>
                                            <option value="NATIONAL BANK LIMITED">
                                                NATIONAL BANK LIMITED
                                            </option>
                                            <option value="NCC Bank">
                                                NCC Bank
                                            </option>
                                            <option value="NRB BANK LIMITED">
                                                NRB BANK LIMITED
                                            </option>
                                            <option value="NRB COMMERCIAL BANK LIMITED">
                                                NRB COMMERCIAL BANK LIMITED
                                            </option>
                                            <option value="Nrb Global Bank Limited">
                                                Nrb Global Bank Limited
                                            </option>
                                            <option value="ONE BANK LIMITED">
                                                ONE BANK LIMITED
                                            </option>
                                            <option value="PADMA BANK LIMITED">
                                                PADMA BANK LIMITED
                                            </option>
                                            <option value="PRIME BANK LIMITED">
                                                PRIME BANK LIMITED
                                            </option>
                                            <option value="Pubali Bank Limited">
                                                Pubali Bank Limited
                                            </option>
                                            <option value="RUPALI BANK LTD">
                                                RUPALI BANK LTD
                                            </option>
                                            <option value="SHAHJALAL ISLAMI BANK LIMITED">
                                                SHAHJALAL ISLAMI BANK LIMITED
                                            </option>
                                            <option value="SOCIAL ISLAMI BANK LIMITED">
                                                SOCIAL ISLAMI BANK LIMITED
                                            </option>
                                            <option value="Sonali Bank Limited">
                                                Sonali Bank Limited
                                            </option>
                                            <option value="SOUTH BANGLA AGRICULTURE AND COMMERCE BANK LIMITED">
                                                SOUTH BANGLA AGRICULTURE AND COMMERCE BANK LIMITED
                                            </option>
                                            <option value="SOUTHEAST BANK LIMITED">
                                                SOUTHEAST BANK LIMITED
                                            </option>
                                            <option value="STANDARD BANK LIMITED">
                                                STANDARD BANK LIMITED
                                            </option>
                                            <option value="STANDARD CHARTERED BANK">
                                                STANDARD CHARTERED BANK
                                            </option>
                                            <option value="THE PREMIER BANK LIMITED">
                                                THE PREMIER BANK LIMITED
                                            </option>
                                            <option value="TRUST BANK LTD">
                                                TRUST BANK LTD
                                            </option>
                                            <option value="UNION BANK LIMITED">
                                                UNION BANK LIMITED
                                            </option>
                                            <option value="UNITED COMMERCIAL BANK LTD">
                                                UNITED COMMERCIAL BANK LTD
                                            </option>
                                            <option value="UTTARA BANK LIMITED">
                                                UTTARA BANK LIMITED
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="branch_name" class="col-sm-3 col-form-label">Branch</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="branch_name" class="form-control" id="branch_name"
                                            value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="routing_no" class="col-sm-3 col-form-label">Routing Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="routing_no" class="form-control" id="routing_no"
                                            value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bank_account_name" class="col-sm-3 col-form-label">A/C Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bank_account_name" class="form-control"
                                            id="bank_account_name" value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bank_account_no" class="col-sm-3 col-form-label">A/C No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bank_account_no" class="form-control"
                                            id="bank_account_no" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row bkash_info d-none mb-3">
                                <label for="bkash" class="col-sm-3 col-form-label">Account no.</label>
                                <div class="col-sm-9">
                                    <input type="number" name="bkash_no" class="form-control"
                                        placeholder="Bkash Account Number" id="bkash_no">
                                </div>
                            </div>
                            <div class="row nagad_info d-none mb-3">
                                <label for="nagad" class="col-sm-3 col-form-label">Account no.</label>
                                <div class="col-sm-9">
                                    <input type="number" name="nagad_no" class="form-control" id="nagad_no"
                                        placeholder="Nagad Account Number">
                                </div>
                            </div>
                            <div class="row rocket_info d-none mb-3">
                                <label for="rocket" class="col-sm-3 col-form-label">Account no.</label>
                                <div class="col-sm-9">
                                    <input type="number" name="rocket_no" class="form-control" id="rocket_no"
                                        placeholder="Rocket Account Number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="balance" class="col-sm-3 col-form-label">Balance</label>
                                <div class="col-sm-9">
                                    <input type="number" name="balance" class="form-control" id="balance"
                                        value="0">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success float-end">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="edit_ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header">
                    <button type="button" class="btn-close btn-sm" style="width: 40px;height:40px"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title ">Edit Account</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.account.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="col-md-12 mb-3">
                            <select name="account_type" id="account_type" class="form-control" required>
                                <option value="1">Bank</option>
                                <option value="2">Bkash</option>
                                <option value="3">Nagad</option>
                                <option value="4">Rocket</option>
                                <option value="5">Cash</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="bank_info">
                                <div class="row mb-3">
                                    <label for="bank_name" class="col-sm-3 col-form-label">Bank Name</label>
                                    <div class="col-sm-9">
                                        <select name="bank_name" id="bank_name" class="form-select">
                                            <option value="{{ null }}"> Select Bank</option>
                                            <option value="AB BANK LIMITED">
                                                AB BANK LIMITED
                                            </option>
                                            <option value="AGRANI BANK LIMITED">
                                                AGRANI BANK LIMITED
                                            </option>
                                            <option value="AL-ARAFAH ISLAMI BANK LTD">
                                                AL-ARAFAH ISLAMI BANK LTD
                                            </option>
                                            <option value="BANGLADESH KRISHI BANK">
                                                BANGLADESH KRISHI BANK
                                            </option>
                                            <option value="BANK ALFALAH LIMITED">
                                                BANK ALFALAH LIMITED
                                            </option>
                                            <option value="BANK ASIA LTD">
                                                BANK ASIA LTD
                                            </option>
                                            <option value="BASIC BANK LIMITED">
                                                BASIC BANK LIMITED
                                            </option>
                                            <option value="Brac Bank Ltd">
                                                Brac Bank Ltd
                                            </option>
                                            <option value="City Bank Ltd">
                                                City Bank Ltd
                                            </option>
                                            <option value="DBBL Agent Banking">
                                                DBBL Agent Banking
                                            </option>
                                            <option value="DHAKA BANK LIMITED">
                                                DHAKA BANK LIMITED
                                            </option>
                                            <option value="Dutch-Bangla Bank Ltd">
                                                Dutch-Bangla Bank Ltd
                                            </option>
                                            <option value="EASTERN BANK LTD">
                                                EASTERN BANK LTD
                                            </option>
                                            <option value="EXIM Bank">
                                                EXIM Bank
                                            </option>
                                            <option value="First Security Islami Bank Limited">
                                                First Security Islami Bank Limited
                                            </option>
                                            <option value="Global Islami Bank ltd">
                                                Global Islami Bank ltd
                                            </option>
                                            <option value="IFIC BANK LTD">
                                                IFIC BANK LTD
                                            </option>
                                            <option value="ISLAMI BANK BANGLADESH LTD">
                                                ISLAMI BANK BANGLADESH LTD
                                            </option>
                                            <option value="JAMUNA BANK LIMITED">
                                                JAMUNA BANK LIMITED
                                            </option>
                                            <option value="Janata Bank Limited">
                                                Janata Bank Limited
                                            </option>
                                            <option value="MERCANTILE BANK LIMITED">
                                                MERCANTILE BANK LIMITED
                                            </option>
                                            <option value="MIDLAND BANK LIMITED">
                                                MIDLAND BANK LIMITED
                                            </option>
                                            <option value="Modhumoti Bank Limited">
                                                Modhumoti Bank Limited
                                            </option>
                                            <option value="MUTUAL TRUST BANK LIMITED">
                                                MUTUAL TRUST BANK LIMITED
                                            </option>
                                            <option value="NATIONAL BANK LIMITED">
                                                NATIONAL BANK LIMITED
                                            </option>
                                            <option value="NCC Bank">
                                                NCC Bank
                                            </option>
                                            <option value="NRB BANK LIMITED">
                                                NRB BANK LIMITED
                                            </option>
                                            <option value="NRB COMMERCIAL BANK LIMITED">
                                                NRB COMMERCIAL BANK LIMITED
                                            </option>
                                            <option value="Nrb Global Bank Limited">
                                                Nrb Global Bank Limited
                                            </option>
                                            <option value="ONE BANK LIMITED">
                                                ONE BANK LIMITED
                                            </option>
                                            <option value="PADMA BANK LIMITED">
                                                PADMA BANK LIMITED
                                            </option>
                                            <option value="PRIME BANK LIMITED">
                                                PRIME BANK LIMITED
                                            </option>
                                            <option value="Pubali Bank Limited">
                                                Pubali Bank Limited
                                            </option>
                                            <option value="RUPALI BANK LTD">
                                                RUPALI BANK LTD
                                            </option>
                                            <option value="SHAHJALAL ISLAMI BANK LIMITED">
                                                SHAHJALAL ISLAMI BANK LIMITED
                                            </option>
                                            <option value="SOCIAL ISLAMI BANK LIMITED">
                                                SOCIAL ISLAMI BANK LIMITED
                                            </option>
                                            <option value="Sonali Bank Limited">
                                                Sonali Bank Limited
                                            </option>
                                            <option value="SOUTH BANGLA AGRICULTURE AND COMMERCE BANK LIMITED">
                                                SOUTH BANGLA AGRICULTURE AND COMMERCE BANK LIMITED
                                            </option>
                                            <option value="SOUTHEAST BANK LIMITED">
                                                SOUTHEAST BANK LIMITED
                                            </option>
                                            <option value="STANDARD BANK LIMITED">
                                                STANDARD BANK LIMITED
                                            </option>
                                            <option value="STANDARD CHARTERED BANK">
                                                STANDARD CHARTERED BANK
                                            </option>
                                            <option value="THE PREMIER BANK LIMITED">
                                                THE PREMIER BANK LIMITED
                                            </option>
                                            <option value="TRUST BANK LTD">
                                                TRUST BANK LTD
                                            </option>
                                            <option value="UNION BANK LIMITED">
                                                UNION BANK LIMITED
                                            </option>
                                            <option value="UNITED COMMERCIAL BANK LTD">
                                                UNITED COMMERCIAL BANK LTD
                                            </option>
                                            <option value="UTTARA BANK LIMITED">
                                                UTTARA BANK LIMITED
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="branch_name" class="col-sm-3 col-form-label">Branch</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="branch_name" class="form-control bank_input"
                                            id="branch_name" value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="routing_no" class="col-sm-3 col-form-label">Routing Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="routing_no" class="form-control bank_input"
                                            id="routing_no" value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bank_account_name" class="col-sm-3 col-form-label">A/C Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bank_account_name" class="form-control bank_input"
                                            id="bank_account_name" value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bank_account_no" class="col-sm-3 col-form-label">A/C No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bank_account_no" class="form-control bank_input"
                                            id="bank_account_no" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row bkash_info d-none mb-3">
                                <label for="bkash" class="col-sm-12 col-form-label">Account no.</label>
                                <div class="col-sm-12">
                                    <input type="number" name="bkash_no" class="form-control"
                                        placeholder="Bkash Account Number" id="bkash_no">
                                </div>
                            </div>
                            <div class="row nagad_info d-none mb-3">
                                <label for="nagad" class="col-sm-12 col-form-label">Account no.</label>
                                <div class="col-sm-12">
                                    <input type="number" name="nagad_no" class="form-control" id="nagad_no"
                                        placeholder="Nagad Account Number">
                                </div>
                            </div>
                            <div class="row rocket_info d-none mb-3">
                                <label for="rocket" class="col-sm-12 col-form-label">Account no.</label>
                                <div class="col-sm-12">
                                    <input type="number" name="rocket_no" class="form-control" id="rocket_no"
                                        placeholder="Rocket Account Number">
                                </div>
                            </div>
                            {{-- cash --}}
                            {{-- <div class="row cash_info d-none mb-3">
                                <label for="cash" class="col-sm-12 col-form-label">Account no.</label>
                                <div class="col-sm-12">
                                    <input type="number" name="cash_no" class="form-control" id="cash_no"
                                        placeholder="Cash Account Number">
                                </div>
                            </div> --}}

                        </div>
                        <button type="submit" class="btn btn-success float-end">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add payment Modal -->
    <div class="modal fade" id="payment_modal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="modal-title" id="paymentModalLabel">Add Balance</h5>
                    <button type="button" class="btn-close btn-sm" style="width: 40px;height:40px"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.account.add.balance') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="account_id" id="account_id">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="balance" class="form-label">Balance</label>
                                <input type="number" name="balance" id="balance" class="form-control"
                                    placeholder="0" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-sm">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $('.btn_delete').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to be delete this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete_form').submit();
                    }
                });
            });
        });

        $(document).on('change', '#account_type', function() {
            let type = $(this).val();
            if (type == 1) {
                $('.bank_info').removeClass('d-none');
                $('.bkash_info').addClass('d-none');
                $('.nagad_info').addClass('d-none');
                $('.rocket_info').addClass('d-none');
                $('#bkash_no').val('');
                $('#nagad_no').val('');
                $('#rocket_no').val('');
            }

            if (type == 2) {
                $('.bkash_info').removeClass('d-none');
                $('.nagad_info').addClass('d-none');
                $('.rocket_info').addClass('d-none');
                $('.bank_info').addClass('d-none');
                $('.bank_input').val('');
                $('#nagad_no').val('');
                $('#rocket_no').val('');
            }

            if (type == 3) {
                $('.nagad_info').removeClass('d-none');
                $('.rocket_info').addClass('d-none');
                $('.bank_info').addClass('d-none');
                $('.bkash_info').addClass('d-none');
                $('.bank_input').val('');
                $('#bkash_no').val('');
                $('#rocket_no').val('');
            }

            if (type == 4) {
                $('.rocket_info').removeClass('d-none');
                $('.bank_info').addClass('d-none');
                $('.bkash_info').addClass('d-none');
                $('.nagad_info').addClass('d-none');
                $('.bank_input').val('');
                $('#bkash_no').val('');
                $('#nagad_no').val('');
            }

            if (type == 5) {
                $('.cash_info').removeClass('d-none');
                $('.bank_info').addClass('d-none');
                $('.bkash_info').addClass('d-none');
                $('.nagad_info').addClass('d-none');
                $('.rocket_info').addClass('d-none');
                $('.bank_input').val('');
                $('#bkash_no').val('');
                $('#nagad_no').val('');
                $('#rocket_no').val('');
            }
        });
        $(document).on('click', '.edit_button', function() {
            $('#edit_modal').modal('show');
            let data = $(this).data('accounts');

            if (data.account_type == 1) {
                $('.bank_info').removeClass('d-none');
                $('.bkash_info').addClass('d-none');
                $('.nagad_info').addClass('d-none');
                $('.rocket_info').addClass('d-none');
            } else if (data.account_type == 2) {
                $('.bkash_info').removeClass('d-none');
                $('.nagad_info').addClass('d-none');
                $('.rocket_info').addClass('d-none');
                $('.bank_info').addClass('d-none');
            } else if (data.account_type == 3) {
                $('.nagad_info').removeClass('d-none');
                $('.rocket_info').addClass('d-none');
                $('.bank_info').addClass('d-none');
                $('.bkash_info').addClass('d-none');
            } else if (data.account_type == 4) {
                $('.rocket_info').removeClass('d-none');
                $('.bank_info').addClass('d-none');
                $('.bkash_info').addClass('d-none');
                $('.nagad_info').addClass('d-none');
            } else if (data.account_type == 5) {
                // $('.cash_info').removeClass('d-none');
                $('.bank_info').addClass('d-none');
                $('.bkash_info').addClass('d-none');
                $('.nagad_info').addClass('d-none');
                $('.rocket_info').addClass('d-none');
            }

            $.each(data, function(index, value) {
                $('input[name =' + index + ']').val(value);
                $('select[name = ' + index + ']').val(value);
            });
        });
        $(document).on('click', '.add_balance_button', function() {
            $('#payment_modal').modal('show');
            let id = $(this).data('id');
            $('#account_id').val(id);
        });
    </script>
    <script>
        $(document).ready(function() {

            // ১. Master Checkbox Toggle
            $(document).on('change', '#master', function() {
                let isChecked = $(this).is(':checked');
                $('.sub_chk').prop('checked', isChecked).trigger('change');
            });

            // ২. Row Selection & Badge Update Logic
            $(document).on('change', '.sub_chk', function() {
                let $row = $(this).closest('tr');

                // Check/Uncheck UI highlight
                if ($(this).is(':checked')) {
                    $row.addClass('table-primary');
                } else {
                    $row.removeClass('table-primary');
                    $('#master').prop('checked', false);
                }

                // Count Update
                let totalChecked = $('.sub_chk:checked').length;
                if (totalChecked > 0) {
                    $('#selected_count').removeClass('d-none').text(totalChecked);
                } else {
                    $('#selected_count').addClass('d-none').text(0);
                }
            });

            // ৩. Bulk Delete Action with SweetAlert2 & AJAX
            $(document).on('click', '#bulk_delete_btn', function(e) {
                e.preventDefault();

                let selectedIds = [];
                $('.sub_chk:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                // যদি কোনো চেকবাক্স সিলেক্ট না থাকে
                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Items Selected',
                        text: 'Please select at least one item to delete.',
                        confirmButtonColor: '#0054a6'
                    });
                    return;
                }

                // Confirmation Alert
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${selectedIds.length} item(s)! This cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete All',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Loader Alert
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we delete selected items.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // AJAX Request
                        $.ajax({
                            url: "{{ route('admin.account.bulk.delete') }}",
                            type: "POST",
                            data: {
                                ids: selectedIds,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        // Reload or DOM remove (Reload safer for pagination count)
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: res.message ||
                                            'Something went wrong!',
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error',
                                    text: xhr.responseJSON?.message ||
                                        'Failed to process request. Please try again.',
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
