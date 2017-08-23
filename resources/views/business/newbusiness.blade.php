@extends('layouts.app')

@section('content')
    @push('header-scripts')
    <link href="/ark/jasny-bootstrap/dist/css/jasny-bootstrap.css" rel="stylesheet">
    <link href="/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @endpush

    {{--Start container--}}
    <div class="container">
        <div class="row">
            <form id="add-business-form" action="{{url("/business/add")}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-md-5 ">
                    <div class="row">
                        <div class="col-md-5">
                            <h4>Business details</h4>
                        </div>
                    </div>
                    <!-- Display Validation Errors -->
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="book-name" class="col-sm-3 control-label align-left">Business name</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{old('business_name')}}" name="business_name" id="business-name" class="form-control">

                        </div>
                    </div>
                    {{--<i class="fa fa-plus"></i> Select file--}}

                            <!-- Street address -->
                    <div class="form-group">
                        <label for="address-street" class="col-sm-3 control-label align-left">Street name</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{old('business_street_address')}}" class="form-control" id="address-street" name="business_street_address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address-zipcode" class="col-sm-3 control-label align-left">zipcode</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="address-zipcode" value="{{old('business_zip_code')}}" name="business_zip_code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business-town" class="col-sm-3 control-label align-left">Town</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-town" value="{{old('business_town')}}" name="business_town">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="business-state" class="col-sm-3 control-label align-left">state</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-state" value="{{old('business_state')}}" name="business_state">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business-country" class="col-sm-3 control-label align-left">country</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-country" value="{{old('business_country')}}" name="business_country">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business-description" class="col-sm-3 control-label align-left">description</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-description" value="{{old('business_description')}}" name="business_description">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label id="available-hours-time" class="align-left control-label">Available hours</label>
                        </div>


                        <div class="col-sm-4">
                            <label for="business-open-from" class="col-sm-3 control-label align-left">open_from</label>
                            <input type="text" class="form-control " id="business-open-from" value="{{old('business_open_from')}}" name="business_open_from">
                        </div>

                        <div class="col-sm-4">
                            <label for="business-open-upto" class="col-sm-3 col-sm-offset-4 control-label">open_upto</label>
                            <input type="text" id="business-open-upto" value="{{old('business_open_from')}}" name="business_open_upto" class="form-control col-sm-offset-3">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business-phone-number" class="col-sm-3 control-label align-left">phone_number</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-phone-number" value="{{old('business_phone_number')}}" name="business_phone_number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business-mobile-number" class="col-sm-3 control-label align-left">mobile_number</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-mobile-number" value="{{old('business_mobile_number')}}" name="business_mobile_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="business-phone-number" class="col-sm-3 control-label align-left">business_email</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-phone-number" value="{{old('business_email')}}" name="business_email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="business-website" class="col-sm-3 control-label align-left">website</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="business-website" value="{{old('business_website')}}" name="business_website">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3 fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img data-src="holder.js/100%x100%" alt="">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="business_profile_pic">
                                </span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>

                    <div>
                        {{-- <!-- Select pdf file Thumb -->
                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-9">
                             <input type="file" class="btn btn-default" name="business[town]" accept="image/*">
                             <i class="fa fa-plus"></i> Select thumb
                         </div>
                     </div>


                     <!--Dflip settings-->
                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>3D or 2D</span>
                             <select name="render3D">
                                 <option value="true">3D</option>
                                 <option value="false">2D</option>
                             </select>
                         </div>
                     </div>

                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>Background color</span>
                             <input class="btn btn-default" name="bg_color" type="text" value="#777">
                         </div>

                     </div>
                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>Background image</span>
                             <input name="bg_image" type="file" accept="image/*">
                         </div>

                     </div>

                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>Flip duration</span>
                             <input type="number" name="flip_duration" value="800">
                         </div>
                     </div>

                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>Container height</span>
                             <input value="1000" type="number" name="container_height">
                         </div>
                     </div>

                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>Page render size</span>
                             <select name="page_render_size">
                                 <option selected="" value="1024">1024</option>
                                 <option value="1400">1400</option>
                                 <option value="1600">1600</option>
                                 <option value="1800">1800</option>
                                 <option value="2048">2048</option>
                             </select>
                         </div>
                     </div>

                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>Page mode</span>
                             <select type="number" name="page_mode">
                                 <option value="1">Single page</option>
                                 <option value="2">Double page</option>
                             </select>
                         </div>
                     </div>

                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <span>Direction (RTL/LTR)</span>
                             <select type="direction" name="direction">
                                 <option value="1">Right to Left</option>
                                 <option value="2">Left to Right</option>
                             </select>
                         </div>
                     </div>
                     <!--Dlip settings-->

                     <!-- Edit Book Button -->
                     <div class="form-group">
                         <div class="col-sm-offset-3 col-sm-6">
                             <button type="submit" class="btn btn-default">
                                 <i class="fa fa-plus"></i> Edit Book
                             </button>
                         </div>
                     </div>--}}
                    </div>

                </div>

                <div class="col-md-7 map-container">
                    <div class="row">
                        <div class="col-md-5">
                            <h4>Point on map</h4>
                        </div>

                    </div>
                    <div class="row">
                        <div id="map-box" class="col-md-12">
                            <div id="map">

                            </div>
                            <div>
                                <fieldset>
                                    {{--<label for="business-address">Business address</label>--}}
                                    {{--<input type="text" name="business_address_name" id="business-address"--}}
                                    {{--placeholder="Maitripath, Butwal">--}}
                                    <input hidden type="text" name="map_radius" id="map-radius" />
                                    <input hidden type="text" name="business_latitude" id="business-lat" />
                                    <input hidden type="text" name="business_longitude" id="business-lon" />
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="add-business-button-container">
                        <div class="col-md-4 col-md-offset-3">
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <input id="add-business-button" type="submit" value="Add my business" class="btn btn-default">
                                    {{--<i class="fa fa-plus"></i> Add my business--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="row">
            {{--Include my places template here--}}
            @include('user.section.myplaces' , ['myBusinesses'=> $myBusinesses ])
        </div>
    </div>
    @push('footerscripts')
    <script src="/ark/jasny-bootstrap/js/fileinput.js"></script>

    @if ($errors->any())
        <script language="javascript">
            var formValidationErrors = {!! json_encode($errors->all())  !!};

        </script>
    @endif
    <script language="javascript">
        /*
         window.setTimeout(function() {
         $(".alert").css({
         position: 'absolute',
         top: '20px',
         right: '20px',
         zIndex: '5000'
         }).fadeTo(500, 0).slideUp(500, function(){
         $(this).remove();
         });
         }, 3000);
         */
        $(document).ready(function () {
            $('#business-open-from').bootstrapMaterialDatePicker({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });
            $('#business-open-upto').bootstrapMaterialDatePicker({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });
        });

        $('#add-business-form').submit(function () {
            validateForm();

            if (true) {
                $('#add-business-form').show();
                return true;
            }

            // ... continue work
        });

        function validateForm() {

        }
    </script>

    @include('user.section.mapscripts')
    @endpush
@endsection