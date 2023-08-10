@extends('layouts/contentNavbarLayout')

@section('title', 'Create Lead')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Leads /</span> Create Lead
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Personal Details</h5>

                <div class="card-body">
                  @include('notification')
                    <form id="leadSubmitForm" action="{{ route('createLead') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="mb-3 col-md-4">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <select id="title" name="title" class="select2 form-select">
                                    <option value="" selected>Select Title</option>
                                    <option value="Mr" {{ old('title') === 'Mr' ? 'selected' : '' }}>Mr</option>
                                    <option value="Ms" {{ old('title') === 'Ms' ? 'selected' : '' }}>Ms</option>
                                    <option value="Mrs" {{ old('title') === 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                    <option value="Dr" {{ old('title') === 'Dr' ? 'selected' : '' }}>Dr</option>
                                    <option value="Fr" {{ old('title') === 'Fr' ? 'selected' : '' }}>Fr</option>
                                </select>

                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="firstName" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="firstName" name="firstName"
                                    placeholder="First Name" autofocus value="{{ old('firstName') }}" />
                                @error('firstName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="lastName" id="lastName"
                                    placeholder="Last Name" value="{{ old('lastName') }}" />
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
                                        placeholder="Contact Number" value="{{ old('ContactNumber') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                </div>
                                @error('ContactNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    placeholder="john.doe@example.com" value="{{ old('email') }}" />
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="dateofbirth" class="form-label">Date Of Birth</label>
                                <input class="form-control" type="text" id="dateofbirth" name="dateofbirth"
                                    placeholder="MM-DD-YYYY" value="{{ old('dateofbirth') }}" />
                                    @error('dateofbirth')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                                {{ old('energy') === null ? 'checked' : (old('energy') == 'Yes' ? 'checked' : '') }} />
                                            <label class="form-check-label" for="energy1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input energyRadio" type="radio" name="energy"
                                                id="energy2" value="No"
                                                {{ old('energy') == 'No' ? 'checked' : '' }} />
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
                                                        {{ old('eleRetailer') == $retailer->id ? 'selected' : '' }}>
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
                                                {{ old('gas') === null ? 'checked' : (old('gas') == 'Yes' ? 'checked' : '') }} />
                                            <label class="form-check-label" for="gas1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input gasRadio" type="radio" name="gas"
                                                id="gas2" value="No"
                                                {{ old('gas') == 'No' ? 'checked' : '' }} />
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
                                                        {{ old('gasRetailer') == $retailer->id ? 'selected' : '' }}>
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
                                                {{ old('internet') == 'Yes' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="internet1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="internet"
                                                id="internet2" value="No"
                                                {{ old('internet') === null ? 'checked' : (old('internet') == 'No' ? 'checked' : '') }} />
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
                                        {{ old('id_type') == 'Drivers Licence' ? 'selected' : '' }}>Drivers Licence
                                    </option>
                                    <option value="Medicare Card"
                                        {{ old('id_type') == 'Medicare Card' ? 'selected' : '' }}>Medicare Card</option>
                                    <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport
                                    </option>
                                </select>
                                @error('id_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="id_number" class="form-label">ID Number</label>
                                <input type="text" class="form-control" id="id_number" name="id_number"
                                    placeholder="ID Number" value="{{ old('id_number') }}" />
                                @error('id_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="id_expiry_date" class="form-label">ID Expiry Date</label>
                                <input type="text" class="form-control" id="id_expiry_date" name="id_expiry_date"
                                    placeholder="MM-DD-YYYY" value="{{ old('id_expiry_date') }}" />
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
                                            {{ old('id_state') == $state ? 'selected' : '' }}>
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
                                    placeholder="Country of Issue" value="{{ old('issue_country') }}" />
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
                                        {{ old('concession') == 'Yes' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="concession1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input concession" type="radio" name="concession"
                                        id="concession2" value="No"
                                        {{ old('concession') === null ? 'checked' : (old('concession') == 'No' ? 'checked' : '') }} />
                                    <label class="form-check-label" for="concession2">No</label>
                                </div>
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
                                                    {{ old('con_card_type') == $cardType ? 'selected' : '' }}>
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
                                            value="{{ old('con_card_number') }}" />
                                        @error('con_card_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label for="con_card_start_date" class="form-label">Card Start Date</label>
                                        <input type="text" class="form-control" id="con_card_start_date"
                                            name="con_card_start_date" placeholder="MM-DD-YYYY"
                                            value="{{ old('con_card_start_date') }}" />
                                        @error('con_card_start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label for="con_card_end_date" class="form-label">Card End Date</label>
                                        <input type="text" class="form-control" id="con_card_end_date"
                                            name="con_card_end_date" placeholder="MM-DD-YYYY"
                                            value="{{ old('con_card_end_date') }}" />
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
                                        {{ old('sales_type') === null ? 'checked' : (old('sales_type') == 'Better Deal' ? 'checked' : '') }} />
                                    <label class="form-check-label" for="sales_type1">Better Deal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input salesType" type="radio" name="sales_type"
                                        id="sales_type2" value="Move-In"
                                        {{ old('sales_type') == 'Move-In' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="sales_type2">Move-In</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input salesType" type="radio" name="sales_type"
                                        id="sales_type3" value="Retention"
                                        {{ old('sales_type') == 'Retention' ? 'checked' : '' }} />
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
                                    placeholder="Move-In Date" value="{{ old('move_in_date') }}" />
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
                                        {{ old('account_type') === null ? 'checked' : (old('account_type') == 'Residential' ? 'checked' : '') }} />
                                    <label class="form-check-label" for="account_type1">Residential</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="account_type"
                                        id="account_type2" value="Business"
                                        {{ old('account_type') == 'Business' ? 'checked' : '' }} />
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
                                            {{ old('lead_source') == $LeadSource->name ? 'selected' : '' }}>
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
                                    placeholder="Promo Code" value="{{ old('promo_code') }}" />
                                @error('promo_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Address Details --}}
                            <h5 class="mt-3">Address Details</h5>
                            <div class="mb-3 col-md-4">
                                <label for="unit_number" class="form-label">Unit Number</label>
                                <input type="text" class="form-control" id="unit_number" name="unit_number"
                                    placeholder="Unit Number" value="{{ old('unit_number') }}" />
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
                                            {{ old('unit_type') == $UnitType->longName ? 'selected' : '' }}>
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
                                    placeholder="Lot Number" value="{{ old('lot_number') }}" />
                                @error('lot_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_number" class="form-label">Street Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="street_number" name="street_number"
                                    placeholder="Street Number" value="{{ old('street_number') }}" />
                                @error('street_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_number_suffix" class="form-label">Street Number Suffix</label>
                                <input type="text" class="form-control" id="street_number_suffix"
                                    name="street_number_suffix" placeholder="Street Number Suffix"
                                    value="{{ old('street_number_suffix') }}" />
                                @error('street_number_suffix')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_name" class="form-label">Street Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="street_name" name="street_name"
                                    placeholder="Street Name" value="{{ old('street_name') }}" />
                                @error('street_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="street_name_suffix" class="form-label">Street Name Suffix</label>
                                <input type="text" class="form-control" id="street_name_suffix"
                                    name="street_name_suffix" placeholder="Street Name Suffix"
                                    value="{{ old('street_name_suffix') }}" />
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
                                            {{ old('street_type_suffix') == $StreetType->longName ? 'selected' : '' }}>
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
                                    placeholder="Suburb" value="{{ old('suburb') }}" />
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
                                            {{ old('state') == $state ? 'selected' : '' }}>
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
                                    placeholder="Postcode" value="{{ old('postcode') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
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

                        </div>
                        <div class="mt-2">
                            <button type="button" id="saveLeads" class="btn btn-warning me-2">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>

        </div>
    </div>
@endsection


@push('script')
    <script>
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
            let selectedTitle = $('#title').val();
            $('#title').val(selectedTitle).trigger('change');

            setTimeout(() => {
                form.submit();
            }, 900);
        })
    </script>
@endpush
