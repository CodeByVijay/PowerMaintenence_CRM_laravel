@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Lead')

@push('style')
    <style>
        .stButton {
            background-color: #9403fc;
            color: #fff;
            font-weight: 500;
        }

        .stButton:hover {
            background-color: #28a745;
            color: #fff;
            font-weight: 700;
        }

        .modal .modal-header .btn-close {
            margin-top: 0.75rem !important;
        }
    </style>
@endpush
@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Leads /</span> Edit Lead
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Personal Details</h5>

                <div class="card-body">

                    @include('notification')
                    <form id="leadSubmitForm" action="{{ route('createLead') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $leads->id }}">
                        <div class="row">

                            <div class="mb-3 col-md-4">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <select id="title" name="title" class="select2 form-select">
                                    <option value="" selected>Select Title</option>
                                    <option value="Mr" {{ $leads->title === 'Mr' ? 'selected' : '' }}>Mr</option>
                                    <option value="Ms" {{ $leads->title === 'Ms' ? 'selected' : '' }}>Ms</option>
                                    <option value="Mrs" {{ $leads->title === 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                    <option value="Dr" {{ $leads->title === 'Dr' ? 'selected' : '' }}>Dr</option>
                                    <option value="Fr" {{ $leads->title === 'Fr' ? 'selected' : '' }}>Fr</option>
                                </select>

                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="firstName" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="firstName" name="firstName"
                                    placeholder="First Name" autofocus value="{{ $leads->firstName }}" />
                                @error('firstName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="lastName" id="lastName"
                                    placeholder="Last Name" value="{{ $leads->lastName }}" />
                                @error('lastName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="ContactNumber">Contact Number <span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    {{-- <span class="input-group-text">US (+1)</span> --}}
                                    <input type="text" id="ContactNumber" name="ContactNumber" class="form-control"
                                        placeholder="Contact Number" value="{{ $leads->homePhone }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                </div>
                                @error('ContactNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    placeholder="john.doe@example.com" value="{{ $leads->email }}" />
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="dateofbirth" class="form-label">Date Of Birth</label>
                                <input class="form-control" type="text" id="dateofbirth" name="dateofbirth"
                                    placeholder="MM-DD-YYYY"
                                    @if (!empty($leads->dateOfBirth)) value="{{ date('m-d-Y', strtotime($leads->dateOfBirth)) }}" @endif />
                            </div>



                            {{-- Fuel Details --}}
                            <h5 class="mt-3">Fuel Details</h5>

                            <div class="mb-3 col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="energy" class="form-label">Energy <span
                                                class="text-danger">*</span></label>
                                        <br>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input energyRadio" type="radio" name="energy"
                                                id="energy1" value="Yes"
                                                {{ $leads->energy === null ? 'checked' : ($leads->energy == 'Yes' ? 'checked' : '') }} />
                                            <label class="form-check-label" for="energy1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input energyRadio" type="radio" name="energy"
                                                id="energy2" value="No"
                                                {{ $leads->energy == 'No' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="energy2">No</label>
                                        </div>
                                        @error('energy')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3 col-md-10" id="energyRetailers">
                                            <label for="eleRetailer" class="form-label">Current Electricity
                                                Retailer <span class="text-danger">*</span></label>
                                            <select id="eleRetailer" name="eleRetailer" class="select2 form-select">
                                                <option value="" selected>Select Retailer</option>
                                                @foreach ($Retailers as $retailer)
                                                    <option value="{{ $retailer->id }}"
                                                        {{ $leads->currentElectricityRetailer == $retailer->id ? 'selected' : '' }}>
                                                        {{ $retailer->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('eleRetailer')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="mb-3 col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="gas" class="form-label">Gas <span
                                                class="text-danger">*</span></label>
                                        <br>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input gasRadio" type="radio" name="gas"
                                                id="gas1" value="Yes"
                                                {{ $leads->gas === null ? 'checked' : ($leads->gas == 'Yes' ? 'checked' : '') }} />
                                            <label class="form-check-label" for="gas1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input gasRadio" type="radio" name="gas"
                                                id="gas2" value="No"
                                                {{ $leads->gas == 'No' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="gas2">No</label>
                                        </div>
                                        @error('gas')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3 col-md-10" id="gasRetailers">
                                            <label for="gasRetailer" class="form-label">Current Gas Retailer <span
                                                    class="text-danger">*</span></label>
                                            <select id="gasRetailer" name="gasRetailer" class="select2 form-select">
                                                <option value="" selected>Select Retailer</option>
                                                @foreach ($Retailers as $retailer)
                                                    <option value="{{ $retailer->id }}"
                                                        {{ $leads->currentGasRetailer == $retailer->id ? 'selected' : '' }}>
                                                        {{ $retailer->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('gasRetailer')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3 col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="gas" class="form-label">Internet <span
                                                class="text-danger">*</span></label>
                                        <br>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="internet"
                                                id="internet1" value="Yes"
                                                {{ $leads->broadband == 'Yes' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="internet1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="internet"
                                                id="internet2" value="No"
                                                {{ $leads->broadband === null ? 'checked' : ($leads->broadband == 'No' ? 'checked' : '') }} />
                                            <label class="form-check-label" for="internet2">No</label>
                                        </div>
                                        @error('internet')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-8">
                                        {{-- <div class="mb-3 col-md-10" id="gasRetailers" style="display: none">
                                    <label for="gasRetailer" class="form-label">Current Gas Retailer</label>
                                    <select id="gasRetailer" name="gasRetailer" class="select2 form-select">
                                      <option value="" selected >Select Retailer</option>
                                      <option value="1">Gas</option>
                                    </select>
                                  </div> --}}
                                    </div>
                                </div>
                            </div>


                            {{-- Identification Details --}}
                            <h5 class="mt-3">Identification Details</h5>
                            <div class="mb-3 col-md-4">
                                <label for="id_type" class="form-label">ID Type</label>
                                <select id="id_type" name="id_type" class="select2 form-select">
                                    <option value="" selected>Select ID Type</option>
                                    <option value="Drivers Licence"
                                        @if (old('id_type') === null) {{ $leads->id_type == 'Drivers Licence' ? 'selected' : '' }} @else {{ old('id_type') == 'Drivers Licence' ? 'selected' : '' }} @endif>
                                        Drivers Licence
                                    </option>
                                    <option value="Medicare Card"
                                        @if (old('id_type') === null) {{ $leads->id_type == 'Medicare Card' ? 'selected' : '' }} @else {{ old('id_type') == 'Medicare Card' ? 'selected' : '' }} @endif>
                                        Medicare Card</option>
                                    <option value="Passport"
                                        @if (old('id_type') === null) {{ $leads->id_type == 'Passport' ? 'selected' : '' }} @else {{ old('id_type') == 'Passport' ? 'selected' : '' }} @endif>
                                        Passport
                                    </option>
                                </select>
                                @error('id_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="id_number" class="form-label">ID Number</label>
                                <input type="text" class="form-control" id="id_number" name="id_number"
                                    placeholder="ID Number"
                                    value="{{ old('id_number') === null ? $leads->id_number : old('id_number') }}" />
                                @error('id_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="id_expiry_date" class="form-label">ID Expiry Date</label>
                                <input type="text" class="form-control" id="id_expiry_date" name="id_expiry_date"
                                    placeholder="MM-DD-YYYY"
                                    @if (!empty($leads->id_expiry_date)) value="{{ date('m-d-Y', strtotime($leads->id_expiry_date)) }}" @endif />
                                @error('id_expiry_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4" id="idState" style="display: none;">
                                <label for="id_state" class="form-label">ID State</label>
                                <br>
                                @php
                                    $stateArr = config('variables.states');
                                @endphp
                                <select id="id_state" name="id_state" class="select2 form-select" style="width: 100%">
                                    <option value="" selected>Select ID State</option>
                                    @foreach ($stateArr as $state)
                                        <option value="{{ $state }}"
                                            {{ $leads->id_issue_state == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4" id="idCountry" style="display: none;">
                                <label for="issue_country" class="form-label">Country of Issue</label>
                                <input type="text" class="form-control" id="issue_country" name="issue_country"
                                    placeholder="Country of Issue" value="{{ $leads->id_issue_country }}" />
                                @error('issue_country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Concession Details --}}
                            <h5 class="mt-3">Concession Details</h5>
                            <div class="mb-3 col-md-3">
                                <label for="concession" class="form-label">Do you have concession card? <span
                                        class="text-danger">*</span></label>
                                <br>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input concession" type="radio" name="concession"
                                        id="concession1" value="Yes"
                                        {{ $leads->hasConcession == 'Yes' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="concession1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input concession" type="radio" name="concession"
                                        id="concession2" value="No"
                                        {{ $leads->hasConcession == 'No' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="concession2">No</label>
                                </div>
                                <br>
                                @error('concession')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div id="concessionDetails" class="col-md-12" style="display: none;">
                                <div class="row">
                                    <div class="mb-3 col-md-3">
                                        <label for="con_card_type" class="form-label">Card Type</label>
                                        <br>
                                        @php
                                            $cardTypes = config('variables.card_type');
                                        @endphp
                                        <select id="con_card_type" name="con_card_type" class="select2 form-select"
                                            style="width: 100%">
                                            <option value="" selected>Select Card Type</option>
                                            @foreach ($cardTypes as $cardType)
                                                <option value="{{ $cardType }}"
                                                    {{ $leads->cardType == $cardType ? 'selected' : '' }}>
                                                    {{ $cardType }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('con_card_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="con_card_number" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="con_card_number"
                                            name="con_card_number" placeholder="Card Number"
                                            value="{{ $leads->cardNumber }}" />
                                        @error('con_card_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label for="con_card_start_date" class="form-label">Card Start Date</label>
                                        <input type="text" class="form-control" id="con_card_start_date"
                                            name="con_card_start_date" placeholder="MM-DD-YYYY"
                                            @if (!empty($leads->card_start_date)) value="{{ date('m-d-Y', strtotime($leads->card_start_date)) }}" @endif />
                                        @error('con_card_start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label for="con_card_end_date" class="form-label">Card End Date</label>
                                        <input type="text" class="form-control" id="con_card_end_date"
                                            name="con_card_end_date" placeholder="MM-DD-YYYY"
                                            @if (!empty($leads->card_end_date)) value="{{ date('m-d-Y', strtotime($leads->card_end_date)) }}" @endif />
                                        @error('con_card_end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Account Details --}}
                            <h5 class="mt-3">Account Details</h5>
                            <div class="mb-3 col-md-4">
                                <label for="sales_type" class="form-label">Sales Type <span
                                        class="text-danger">*</span></label>
                                <br>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input salesType" type="radio" name="sales_type"
                                        id="sales_type1" value="Better Deal"
                                        {{ $leads->salesType === null ? 'checked' : ($leads->salesType == 'Better Deal' ? 'checked' : '') }} />
                                    <label class="form-check-label" for="sales_type1">Better Deal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input salesType" type="radio" name="sales_type"
                                        id="sales_type2" value="Move-In"
                                        {{ $leads->salesType == 'Move-In' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="sales_type2">Move-In</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input salesType" type="radio" name="sales_type"
                                        id="sales_type3" value="Retention"
                                        {{ $leads->salesType == 'Retention' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="sales_type3">Retention</label>
                                </div>
                                @error('sales_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4" id="moveInDate" style="display: none;">
                                <label for="move_in_date" class="form-label">Move-In Date <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="move_in_date" name="move_in_date"
                                    placeholder="Move-In Date"
                                    @if (!empty($leads->connectionDate)) value="{{ date('m-d-Y', strtotime($leads->connectionDate)) }}" @endif />
                                @error('move_in_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="account_type" class="form-label">Account Type <span
                                        class="text-danger">*</span></label>
                                <br>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="account_type"
                                        id="account_type1" value="Residential"
                                        {{ $leads->accountType == 'Residential' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="account_type1">Residential</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="account_type"
                                        id="account_type2" value="Business"
                                        {{ $leads->accountType == 'Business' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="account_type2">Business</label>
                                </div>
                                <br>
                                @error('account_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="lead_source" class="form-label">Lead Source <span
                                        class="text-danger">*</span></label>
                                <select id="lead_source" name="lead_source" class="select2 form-select">
                                    <option value="" selected>Select Lead Source</option>
                                    @foreach ($LeadSources as $LeadSource)
                                        <option value="{{ $LeadSource->name }}"
                                            {{ $leads->leadSource == $LeadSource->name ? 'selected' : '' }}>
                                            {{ $LeadSource->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('lead_source')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="promo_code" class="form-label">Promo Code</label>
                                <input type="text" class="form-control" id="promo_code" name="promo_code"
                                    placeholder="Promo Code" value="{{ $leads->promocode }}" />
                                @error('promo_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Address Details --}}
                            <h5 class="mt-3">Address Details</h5>
                            <div class="mb-3 col-md-4">
                                <label for="unit_number" class="form-label">Unit Number</label>
                                <input type="text" class="form-control" id="unit_number" name="unit_number"
                                    placeholder="Unit Number" value="{{ $leads->phyUnitnumber }}" />
                                @error('unit_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="unit_type" class="form-label">Unit Type</label>
                                <select id="unit_type" name="unit_type" class="select2 form-select form-control">
                                    <option value="" selected>Select Unit Type</option>
                                    @foreach ($UnitTypes as $UnitType)
                                        <option value="{{ $UnitType->longName }}"
                                            {{ $leads->phyUnitType == $UnitType->longName ? 'selected' : '' }}>
                                            {{ $UnitType->longName }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('unit_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="lot_number" class="form-label">Lot Number</label>
                                <input type="text" class="form-control" id="lot_number" name="lot_number"
                                    placeholder="Lot Number" value="{{ $leads->phyLotnumber }}" />
                                @error('lot_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_number" class="form-label">Street Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="street_number" name="street_number"
                                    placeholder="Street Number" value="{{ $leads->phyStreetnumber }}" />
                                @error('street_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_number_suffix" class="form-label">Street Number Suffix</label>
                                <input type="text" class="form-control" id="street_number_suffix"
                                    name="street_number_suffix" placeholder="Street Number Suffix"
                                    value="{{ $leads->phyStreetNumberSuffix }}" />
                                @error('street_number_suffix')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_name" class="form-label">Street Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="street_name" name="street_name"
                                    placeholder="Street Name" value="{{ $leads->phyStreetname }}" />
                                @error('street_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_name_suffix" class="form-label">Street Name Suffix</label>
                                <input type="text" class="form-control" id="street_name_suffix"
                                    name="street_name_suffix" placeholder="Street Name Suffix"
                                    value="{{ $leads->phyStreetSuffix }}" />
                                @error('street_name_suffix')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_type_suffix" class="form-label">Street Type</label>
                                <select id="street_type_suffix" name="street_type_suffix" class="select2 form-select">
                                    <option value="" selected>Select Street Type</option>
                                    @foreach ($StreetTypes as $StreetType)
                                        <option value="{{ $StreetType->longName }}"
                                            {{ $leads->phyStreetType == $StreetType->longName ? 'selected' : '' }}>
                                            {{ $StreetType->longName }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('street_type_suffix')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="suburb" class="form-label">Suburb <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="suburb" name="suburb"
                                    placeholder="Suburb" value="{{ $leads->phySuburb }}" />
                                @error('suburb')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <select id="state" name="state" class="select2 form-select">
                                    <option value="" selected>Select State</option>
                                    @foreach ($stateArr as $state)
                                        <option value="{{ $state }}"
                                            {{ $leads->phyState == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="postcode" class="form-label">Postcode <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="postcode" name="postcode"
                                    placeholder="Postcode" value="{{ $leads->phyPostcode }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                @error('postcode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Notes --}}
                            <h5 class="mt-3">Notes</h5>
                            <div class="mb-3 col-md-6">
                                <label for="new_notes" class="form-label">New Notes</label>
                                <textarea class="form-control" id="new_notes" name="new_notes" placeholder="New Notes">{{ old('new_notes') }}</textarea>
                                @error('new_notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 my-3">
                                <div id="notesTableBtn" style="cursor: pointer !important; user-select: none;">
                                    <h5>All Notes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)"
                                            class="btn btn-warning btn-sm notesIcon"
                                            style="font-weight: 900 !important;"><i class='bx bx-plus'></i></a></span>
                                    </h5>
                                </div>

                                <div class="table-responsive" id="notesTable" style="display: none">
                                    <table class="table table-hover table-flush-spacing leadNotes text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Notes</th>
                                                <th class="text-center">Created By</th>
                                                <th class="text-center">Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($notes as $key => $note)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $note->notes }}</td>
                                                    <td>{{ $note->first_name . ' ' . $note->last_name }}</td>
                                                    <td>{{ date('d-M-Y h:i A', strtotime($note->created_at)) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">No notes found.</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="mt-2">
                            <button type="button" id="saveLeads" class="btn btn-warning me-2">Update Changes</button>
                        </div>
                    </form>

                    <div class="statusButtons my-5">

                        <button type="button" class="btn mb-3 mx-2 stButton">No Answer</button>
                        <button type="button" class="btn mb-3 mx-2 stButton">Not Interested</button>
                        <button type="button" class="btn mb-3 mx-2 stButton">Already On Better Deal</button>
                        <button type="button" class="btn mb-3 mx-2 stButton">Callback</button>
                        <button type="button" class="btn mb-3 mx-2 stButton">Incorrect Details</button>
                        <button type="button" class="btn mb-3 mx-2 stButton">Wrong Number</button>

                    </div>
                </div>
                <!-- /Account -->

            </div>

        </div>
    </div>

    {{-- Model Component --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLable"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 40px;box-shadow: none;"></button>
                </div>
                <div class="modal-body" id="modalBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveNotes" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Model Component End --}}
@endsection


@push('script')
    <script>
        // $('.leadNotes').DataTable();

        // Notes table hide/show
        $(document).ready(function() {
            $('#notesTableBtn').on('click', function() {
                $('#notesTable').toggle(500);
                setTimeout(function() {
                    if ($('#notesTable').is(':visible')) {
                        $('.notesIcon').html(`<i class='bx bx-minus'></i>`);
                    } else {
                        $('.notesIcon').html(`<i class='bx bx-plus'></i>`);
                    }
                }, 550)
            });
        });
        // Notes table hide/show end

        // Status Modal Code
        $(document).ready(function() {
            $('.stButton').on('click', function() {
                let title = $(this).html()
                let lead_id = "{{ $leads->id }}";
                console.log(lead_id)
                let modal = $('#statusModal')
                let form
                if (title === "Callback") {
                    form = `<form method="POST" id="statusForm" action="{{ route('lead-status-update') }}">
                          @csrf
                          <input type="hidden" name="status" value="${title}">
                          <input type="hidden" name="lead_id" value="${lead_id}">
                          <div class="mb-3">
                            <label for="datetimepick" class="col-form-label">Choose Callback datetime <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="dateTime" class="form-control dateTime" id="datetimepick">
                            <span id="datetimeErr"></span>
                        </div>
                          <div class="mb-3">
                              <label for="notes-text" class="col-form-label">Add Note <span class="text-danger">*</span></label>
                              <textarea class="form-control notes" name="new_notes" id="notes-text"></textarea>
                              <span id="notesErr"></span>
                          </div>
                      </form>`
                } else {
                    form = `<form method="POST" id="statusForm" action="{{ route('lead-status-update') }}">
                          @csrf
                          <input type="hidden" name="status" value="${title}">
                          <input type="hidden" name="lead_id" value="${lead_id}">
                          <div class="mb-3">
                              <label for="notes-text" class="col-form-label">Add Note <span class="text-danger">*</span></label>
                              <textarea class="form-control notes" name="new_notes" id="notes-text"></textarea>
                              <span id="notesErr"></span>
                          </div>
                      </form>`
                }

                $('#statusModalLable').html(title)
                $('#modalBody').html(form)
                modal.modal('show')
            });

            $('#saveNotes').on('click', function(e) {
                e.preventDefault();

                $('#datetimeErr').html('');
                $('#notesErr').html('');

                if ($('form .dateTime').val() === "") {
                    $('#datetimeErr').html(`* Date Time field is required.`).css('color','red');
                    return false;
                }
                if ($('form .notes').val() === "") {
                    $('#notesErr').html(`* Note field is required.`).css('color','red');
                    return false;
                }
                let btn = $(this)
                btn.attr("disabled", "disabled")
                btn.html(`Please wait <i class="fa fa-spinner fa-pulse fa-fw"></i>`)
                let form = $('#statusForm')

                setTimeout(() => {
                    form.submit();
                }, 900);

            })
        });
        // Status Modal Code ENd


        $(function() {
            $("#dateofbirth").datepicker({
                dateFormat: 'mm-dd-yy', // Set the desired date format (mm-dd-YYYY)
                changeMonth: true,
                changeYear: true,
                yearRange: '1900:+0',
                maxDate: 0
            });

            $("#id_expiry_date").datepicker({
                dateFormat: 'mm-dd-yy', // Set the desired date format (mm-dd-yyyy)
                changeMonth: true,
                changeYear: true,
                yearRange: '1900:+0',
                minDate: 0
            });

            $("#con_card_start_date").datepicker({
                dateFormat: 'mm-dd-yy', // Set the desired date format (mm-dd-yyyy)
                changeMonth: true,
                changeYear: true,
                yearRange: '1900:+0',
                maxDate: 0
            });

            $("#con_card_end_date").datepicker({
                dateFormat: 'mm-dd-yy', // Set the desired date format (mm-dd-yyyy)
                changeMonth: true,
                changeYear: true,
                yearRange: '1900:+0', // Optional: Set the range of years available for selection
                minDate: 0
            });

            $("#move_in_date").datepicker({
                dateFormat: 'mm-dd-yy', // Set the desired date format (mm-dd-yyyy)
                changeMonth: true,
                changeYear: true,
                yearRange: '1900:+0', // Optional: Set the range of years available for selection
                minDate: 0
            });
        });

        $(document).ready(function() {
            if ($('.energyRadio:checked').val() === "Yes") {
                $('#energyRetailers').show()
            } else {
                $('#energyRetailers').hide()
            }
            $('.energyRadio').on('change', function() {
                let val = $(this).val()
                if (val === "Yes") {
                    $('#energyRetailers').show()
                } else {
                    $('#energyRetailers').hide()
                    $('#eleRetailer').val(null).trigger('change')
                }
            });

            if ($('.gasRadio:checked').val() === "Yes") {
                $('#gasRetailers').show()
            } else {
                $('#gasRetailers').hide()
            }
            $('.gasRadio').on('change', function() {
                let val = $(this).val()
                if (val === "Yes") {
                    $('#gasRetailers').show()
                } else {
                    $('#gasRetailers').hide()
                    $('#gasRetailer').val(null).trigger('change')
                }
            });

            if ($('#id_type option:selected').val() === "Passport") {
                $('#idState').hide()
                $('#idCountry').show()
            } else {
                $('#idState').show()
                $('#idCountry').hide()
            }

            $('#id_type').on('change', function() {
                let val = $(this).val()
                if (val !== "Passport") {
                    $('#idState').show()
                    $('#idCountry').hide()
                    $('#issue_country').val(null)
                } else {
                    $('#idState').hide()
                    $('#idCountry').show()
                    $('#id_state').val(null).trigger('change')
                }
            });

            if ($('.concession:checked').val() === "Yes") {
                $('#concessionDetails').show()
            } else {
                $('#concessionDetails').hide()
            }

            $('.concession').on('change', function() {
                let val = $(this).val();
                if (val === "Yes") {
                    $('#concessionDetails').show()
                } else {
                    $('#concessionDetails').hide()
                    $('#con_card_type').val(null).trigger('change')
                    $('#con_card_number').val(null)
                    $('#con_card_start_date').val(null)
                    $('#con_card_end_date').val(null)
                }
            });
            if ($('.salesType:checked').val() === "Move-In") {
                $('#moveInDate').show()
            } else {
                $('#moveInDate').hide()
            }

            $('.salesType').on("change", function() {
                let val = $(this).val()
                if (val !== "Move-In") {
                    $('#moveInDate').hide()
                    $('#move_in_date').val(null)
                } else {
                    $('#moveInDate').show()
                }
            })

        });

        $('#saveLeads').on('click', function() {
            let btn = $(this)
            btn.attr("disabled", "disabled")
            btn.html(`Please wait <i class="fa fa-spinner fa-pulse fa-fw"></i>`)
            let form = $('#leadSubmitForm')

            setTimeout(() => {
                form.submit();
            }, 900);
        })
    </script>
@endpush
