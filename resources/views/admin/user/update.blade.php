@extends('admin.master')
@section('title', 'Sửa user')
@section('content')
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Update Form</h2>
            </div>
            <div class="panel-body">
                <form action="{{ route('update-user.admin') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="email">Username*:</label>
                        <input type="text" name="user_name" value="{{ $user->user_name }}" class="form-control"
                            id="user_name">
                        @error('user_name')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email*:</label>
                        <input type="text" name="email" value="{{ $user->email }}" class=" form-control" id="email"
                            placeholder="Nhập Email">
                        @error('email')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Image*:</label>
                        <img src="{{ asset($user->avatar) }}">
                        <input type="file" name="image" class="form-control" id="image" placeholder="Nhập Email">
                    </div>



                    <div class="form-group">
                        <label for="email">Fistname*:</label>
                        <input type="text" name="fist_name" value="{{ $user->fist_name }}" class=" form-control"
                            id="fist_name" placeholder="Nhập Fistname">
                        @error('fist_name')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Lastname*:</label>
                        <input type="text" name="last_name" value="{{ $user->last_name }}" class=" form-control"
                            id="last_name" placeholder="Nhập Lastname">
                        @error('last_name')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday*:</label>
                        <input type="date" class="form-control" value="{{ $user->birthday }}" name=" birthday"
                            id="birthday" placeholder="Nhập Birthday">
                        @error('birthday')
                            <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Address <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                id="address" name="address" placeholder="Address"
                                value="{{ old('address') ?? $user->address }}">
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="province">Province <span class="text-danger">*</span></label>
                                <select name="province" id="province" class="form-control select2" style="width: 100%;">
                                    <option value="" selected="selected">--Select Province--</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ (old('province') ?? $user->province_id) == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('province'))
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="district">District <span class="text-danger">*</span></label>
                                <input class="d-none" id="old-district"
                                    value="{{ old('district') ?? $user->district_id }}">
                                <select name="district" id="district" class="form-control select2" style="width: 100%;">
                                    <option value="" selected="selected">--Select District--</option>
                                </select>
                                @if ($errors->has('district'))
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('district') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="commune">Commune <span class="text-danger">*</span></label>
                                <input class="d-none" id="old-commune"
                                    value="{{ old('commune') ?? $user->commune_id }}">
                                <select name="commune" id="commune" class="form-control select2" style="width: 100%;">
                                    <option value="" selected="selected">--Select Commune--</option>
                                </select>
                                @if ($errors->has('commune'))
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('commune') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <div class="form-group">
                            <label for="password">Password*:</label>
                            <input type="password" name="password" value="{{ $user->password }}" class=" form-control"
                                id="password" placeholder="Nhập Password">
                            @error('password')
                                <p style="color:red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirmation_pwd">Confirmation Password*:</label>
                            <input type="password" name="password_confirm" class="form-control" id="confirmation_pwd"
                                placeholder="Nhập Confirmation Password">
                            @error('password_confirm')
                                <p style="color:red">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        // Get value of the province is selected.
        let province_val = $('select#province').find(':selected').val();

        // Get old value of the district.
        let district_val = $("#old-district").val();

        // Get old value of the commune.
        let commune_val = $("#old-commune").val();

        if (province_val !== "" && typeof province_val !== "undefined") {
            // Get districts list with old value of the district and value of the province.
            getDistrict(province_val, district_val);
        }

        // If value old district is selected => get communes list with the province, the district and old value of the commune.
        if (!isNaN(parseInt(district_val))) {
            getCommune(province_val, district_val, commune_val);
        }

    });

    // Get districts list when province is selected.
    $("#province").on('change', function() {

        let province = $("#province").val();

        // Get old value of the district.
        let district_val = $("#old-district").val();

        getDistrict(province, district_val);
    });

    // Get communes list when province is selected.
    $("#district").on('change', function() {

        let province = $("#province").val();
        let district = $("#district").val();

        getCommune(province, district);
    });

    // Get districts list with province id and old value of the district.
    function getDistrict(province, old_district) {
        let district = $("#district");
        let commune = $("#commune");

        // Remove all option of the districts list.
        removeInputDetailsAddress(district, 'District');

        // Remove all option of the communes list.
        removeInputDetailsAddress(commune, 'Commune');

        $.ajax({
            type: "GET",
            url: '/admin/address/district/' + province,
            success: function(data, textStatus, xhr) {
                if (xhr.status === 200) {
                    // Remove all option of the districts list.
                    removeInputDetailsAddress(district, 'District');
                    if (data.length) {
                        $.each(data, function(key, data) {
                            let selected = data.id == old_district ? "selected" : "";
                            district.append(
                                "<option " + selected + " value=" + data.id + ">" + data.name +
                                "</option>"
                            );
                        });
                    }
                }
            }
        });
    }

    // Remove all option with tag and set option default.
    function removeInputDetailsAddress(tag, name) {
        tag.html('');
        tag.append("<option selected=\"selected\">--Select " + name + "--</option>");
    }

    // Get all communes list with province id, district id and old value commune.
    function getCommune(province, district, old_commune) {
        let commune = $("#commune");

        $.ajax({
            type: "GET",
            data: {
                '_token': $('meta[name=csrf-token]').attr("content"),
                'province': province,
                'district': district,

            },
            url: '/admin/address/commune/' + district,
            success: function(data, textStatus, xhr) {
                if (xhr.status === 200) {
                    removeInputDetailsAddress(commune, 'Commune');
                    if (data.length) {
                        $.each(data, function(key, data) {
                            let selected = data.id == old_commune ? "selected" : "";
                            commune.append(
                                "<option " + selected + " value=" + data.id + ">" + data.name +
                                "</option>"
                            );
                        });
                    }
                }
            }
        });
    }
</script>
@endsection
