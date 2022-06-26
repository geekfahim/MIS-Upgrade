@extends('dashboard.jeebika.download.layouts.report-master')

@section('title', 'Family Validation')
@push('header')
    <style>
        td {
            word-wrap: break-word !important;
            overflow-wrap: break-word;
        }

        table {
            width: 100%;
        }

    </style>
@endpush
<!-- Body -->
@section('content')
    <div style="display:block; clear:both; page-break-after:always;">
        <h2 class="center text-capitalize">{{$data->name}} Full Report</h2>
        <table class="table-borderless">
            <caption>
                <h3 class="underline">পরিবারের তথ্য</h3>
            </caption>
            <tbody>
            <tr>
                <th>প্রজেক্ট</th>
                <td>:</td>
                <td>{{$data->jeebika?$data->jeebika->j_project->name:''}}</td>
                <th>জিআরও</th>
                <td>:</td>
                <td>{{$data->jeebika?$data->jeebika->j_gro->name:''}}</td>
                <th>স্পনর</th>
                <td>:</td>
                <td>{{$data->head->sponsor_id?$data->head->sponsor->name:''}}</td>
                <th>পরিবারের প্রধান</th>
                <td>:</td>
                <td>{{$data->family_headed_by?$data->family_headed_by->value:''}}</td>
                <th>বসতবাড়ির জমির ধরন</th>
                <td>:</td>
                <td>{{$data->house_land_type?$data->house_land_type->value:''}}</td>
            </tr>
            <tr>
                <th>বসতবাড়ির ধরন</th>
                <td>:</td>
                <td>{{$data->house_type?$data->house_type->value:''}}</td>
                <th>বসতবাড়ির স্থান</th>
                <td>:</td>
                <td>{{$data->house_location?$data->house_location->value:''}}</td>
                <th>খাবার পানি</th>
                <td>:</td>
                <td>{{$data->drinking_water?$data->drinking_water->value:''}}</td>
                <th>অন্যান্য কাজে ব্যাবরিত পানি</th>
                <td>:</td>
                <td>{{$data->other_water?$data->other_water->value:''}}</td>
                <th>সৌচাগারের ধরন</th>
                <td>:</td>
                <td>{{$data->toilet_type?$data->toilet_type->value:''}}</td>
            </tr>
            <tr>
                <th>সৌচাগারের মালিক</th>
                <td>:</td>
                <td>{{$data->toilet_owner?$data->toilet_owner->value:''}}</td>
                <th>রান্নার জ্বালানি</th>
                <td>:</td>
                <td>{{$data->cooking_fuel?$data->cooking_fuel->value:''}}</td>
                <th>বৈদ্যুতিক সংযোগ</th>
                <td>:</td>
                <td>{{$data->electricity_connectivity?$data->electricity_connectivity->value:''}}</td>
                <th>মোট কক্ষ</th>
                <td>:</td>
                <td>{{$data->total_room}}</td>
                <th>পরিবারের রেফারেন্স নাম্বার</th>
                <td>:</td>
                <td>{{$data->family_reference_number}}</td>
            </tr>
            </tbody>
        </table>
        {{--family member--}}
        <div>
            <caption>
                <h3 class="underline center">পরিবার বর্গের বিবরণ</h3>
            </caption>
            @foreach($data->members as $item)
                <table style="width: 100%" class="table-borderless">
                    <thead>
                    <tr>
                        <th>নাম</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->name}}</td>
                        <th>লিঙ্গ</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->gender->value}}</td>
                        <th>ই-মেইল</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->email}}</td>
                        <th>মোবাইল</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->mobile}}</td>
                        <th>বিকল্প নাম্বার</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->alternate_mobile}}</td>
                    </tr>
                    <tr>
                        <th>জরুরী নাম্বার</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->emergency_mobile}}</td>
                        <th>জাতীয় পরিচয়পত্র</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->nid}}</td>
                        <th>পাসপোর্ট</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->passport}}</td>
                        <th>জন্মতারিখ</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->birth_date}}</td>
                        <th>জন্ম সনদ</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->birth_certificate}}</td>
                    </tr>
                    <tr>
                        <th>বয়স</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->age}}</td>
                        <th>ধর্ম</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->religion?$item->mustahiq->religion->value:''}}</td>
                        <th>রেফারেন্স নাম্বার</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->reference_number}}</td>
                        <th>রক্তের গ্রুপ</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->blood_group?$item->mustahiq->blood_group->value:''}}</td>
                        <th>রোগের নাম</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->disease?$item->mustahiq->disease->name:''}}</td>
                    </tr>
                    <tr>
                        <th>প্রাত্যহিক ওষুধ সেবন</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->is_disease_regular_medicine==1 ? 'Yes' :'No'}}</td>
                        <th>প্রতিবন্ধী ধরণ</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->disability?$item->mustahiq->disability->name:''}}</td>
                        <th>পরিবার প্রধানের সাথে সম্পর্ক</th>
                        <td class="w-1">:</td>
                        <td>{{$item->relation_with_family_head}}</td>
                        <th>সর্বোচ্চ্য শিক্ষাগত যোগ্যতা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->highest_education_level?$item->mustahiq->details->highest_education_level->value:''}}</td>
                        <th>উপার্জন সামর্থ্য</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->is_earn_ability?'Yes':'No'}}</td>
                    </tr>
                    <tr>
                        <th>পেশা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->occupation?$item->mustahiq->details->occupation->name:''}}</td>
                        <th>প্রেগ্নেন্সি অবস্থা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->pregnancy_status?$item->mustahiq->details->pregnancy_status->value:''}}</td>
                        <th>মাসিক আয়</th>
                        <td class="w-1">:</td>
                        <td class="tk">{{$item->mustahiq->details->monthly_income }}</td>
                        <th>বৈবাহিক অবস্থা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->marital_status?$item->mustahiq->details->marital_status->value:''}}</td>
                        <th>স্বামী/স্ত্রী নাম</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->spouse_name}} {{$item->mustahiq->details->spouse_name?"(".$item->mustahiq->details->spouse_living_status->value.")":''}}</td>
                    </tr>
                    <tr>
                        <th>স্বামী/স্ত্রী ফোন</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->spouse_mobile}}</td>
                        <th>কারিগরী প্রশিক্ষণ প্রয়োজন</th>
                        <td class="w-1">:</td>
                        <td>
                            @foreach($item->mustahiq->vocationals as $training)
                                {{$training->vocational->name}},
                            @endforeach

                        </td>
                        <th>দক্ষতা প্রশিক্ষণ প্রয়োজন</th>
                        <td class="w-1">:</td>
                        <td>
                            @foreach($item->mustahiq->skills as $training)
                                {{$training->skill->name}},
                            @endforeach
                        </td>
                        <th>অনাথ</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->orphan_type?$item->mustahiq->details->orphan_type->value:''}}</td>
                        <th>স্থায়ী ঠিকানা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->permanent_address}}</td>
                    </tr>
                    <tr>
                        <th>স্থায়ী জেলা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->permanent_district?$item->mustahiq->permanent_district->name:''}}</td>
                        <th>স্থায়ী উপজেলা/থানা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->permanent_upazila?$item->mustahiq->permanent_upazila->name:''}}</td>
                        <th>স্থায়ী ইউনিয়ন</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->permanent_union?$item->mustahiq->permanent_union->name:''}}</td>
                        <th>স্থায়ী পোস্ট কোড</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->permanent_post_code}}</td>
                        <th>বর্তমান ঠিকানা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->present_address}}</td>
                    </tr>
                    <tr>
                        <th>বর্তমান জেলা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->present_district?$item->mustahiq->details->present_district->name:''}}</td>
                        <th>বর্তমান উপজেলা/থানা</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->present_upazila?$item->mustahiq->details->present_upazila->name:''}}</td>
                        <th>বর্তমান ইউনিয়ন</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->present_union?$item->mustahiq->details->present_union->name:''}}</td>
                        <th>বর্তমান পোস্ট কোড</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details?$item->mustahiq->details->present_post_code:''}}</td>
                        <th>বাবার
                            নাম
                        </th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->father_name}} {{$item->mustahiq->details->father_name?"(".$item->mustahiq->details->father_living_status->value.")":''}}</td>
                    </tr>
                    <tr>
                        <th>বাবার ফোন</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->father_mobile}}</td>
                        <th>মা
                            নাম
                        </th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->mother_name}}{{$item->mustahiq->details->mother_name?"(".$item->mustahiq->details->mother_living_status->value.")":''}}</td>
                        <th>মা ফোন</th>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->details->mother_mobile}}</td>
                        <th>মন্তব্য</th>
                        <td>:</td>
                        <td colspan="10">{{$item->mustahiq->remarks}}</td>
                    </tr>
                    </thead>
                </table>
            @endforeach
        </div>
        {{--end family member--}}
        {{-- Assets --}}
        <table style="width: 100%">
            <caption>
                <h3>পারিবারিক সম্পদের বিবরণ</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>সম্পদের ধরণ</th>
                <th>স্থান</th>
                <th>পরিমান(সংখ্যা)</th>
                <th>মোট মূল্য</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->assets as $asset)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$asset->asset->name}}</td>
                    <td>{{$asset->asset_location}}</td>
                    <td>{{$asset->asset_quantity}}</td>
                    <td>
                        <span class="tk">{{$asset->asset_value}}</span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="4">মোট সম্পদের মূল্য</th>
                <td style="font-weight: bold" class="tk">{{$data->assets->sum('asset_value')}}</td>
            </tr>
            </tbody>
        </table>
        {{-- Loans --}}
        <table style="width: 100%">
            <caption>
                <h3>পারিবারিক ঋণের বিবরণ</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>ঋণ গ্রহণের তারিখ</th>
                <th>ঋণের উৎস</th>
                <th>ঋণের উৎসের নাম</th>
                <th>ঋণের পরিমান</th>
                <th>সুদের হার/অতিরিক্ত টাকা</th>
                <th>পরিশোধের সময়সীমা</th>
                <th>ঋণ ব্যাবহারের খাত</th>
                <th>বর্তমান ঋণের স্থিতি</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->loans as $loan)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$loan->loan_taking_date}}</td>
                    <td>{{$loan->loan_source}}</td>
                    <td>{{$loan->loan_source_name}}</td>
                    <td>{{$loan->loan_amount}}</td>
                    <td>{{$loan->loan_rate_or_extra_amount}}</td>
                    <td>{{$loan->loan_duration}}</td>
                    <td>{{$loan->loan_purpose}}</td>
                    <td><span class="tk">{{$loan->loan_outstanding_amount}}</span></td>
                </tr>
            @endforeach
            <tr>
                <th colspan="4">মোট ঋণের পরিমান</th>
                <td style="font-weight: bold" class="tk">{{$data->loans->sum('loan_amount')}}</td>
                <th colspan="3">মোট বর্তমান ঋণের স্থিতি</th>
                <td style="font-weight: bold" class="tk">{{$data->loans->sum('loan_outstanding_amount')}}</td>
            </tr>
            </tbody>
        </table>
        {{-- Incomes --}}
        <table style="width: 100%">
            <caption>
                <h3>পরিবারের বার্ষিক আয়</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>আয়ের উৎস</th>
                <th>আয়ের পরিমান</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->incomes as $income)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$income->income->name}}</td>
                    <td><span class="tk">{{$income->income_amount}}</span></td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2">মোট আয়ের পরিমান</th>
                <td style="font-weight: bold" class="tk">{{$data->incomes->sum('income_amount')}}</td>
            </tr>
            </tbody>
        </table>
        {{-- Expense --}}
        <table style="width: 100%">
            <caption>
                <h3>পরিবারের বার্ষিক ব্যায়</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>ব্যায়ের খাত</th>
                <th>ব্যায়ের পরিমান</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->expenses as $expense)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$expense->expense_type}}</td>
                    <td>
                        <span class="tk">
                        {{$expense->expense_amount}}
                        </span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2">মোট ব্যায়ের পরিমান</th>
                <td style="font-weight: bold" class="tk">{{$data->expenses->sum('expense_amount')}}</td>
            </tr>
            </tbody>
        </table>
        {{-- Savings --}}
        <table style="width: 100%">
            <caption>
                <h3>পরিবারের বার্ষিক সঞ্চয়ের বিবরণ</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>সঞ্চয়ের ধরণ</th>
                <th>সঞ্চয়ের পরিমান</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->savings as $savings)
                <tr>
                    <td>1</td>
                    <td>{{$savings->savings_type}}</td>
                    <td><span class="tk">{{$savings->savings_amount}}</span></td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2">মোট সঞ্চয়ের পরিমান</th>
                <td style="font-weight: bold" class="tk">{{$data->savings->sum('savings_amount')}}</td>
            </tr>
            </tbody>
        </table>
        {{-- NGO --}}
        <table style="width: 100%">
            <caption>
                <h3>আর্থ-সামাজিক অবস্থা</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>এনজিও/সংস্থার নাম</th>
                <th>সহায়তার ধরণ</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->otherNgos as $otherNgo)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$otherNgo->ngo_name}}</td>
                    <td>{{$otherNgo->ngo_help_type}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{-- Safety --}}
        <table style="width: 100%">
            <caption>
                <h3>পরিবারের নিরাপত্তা </h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>নির্যাতিতের নাম</th>
                <th>নির্যাতনকারীর সাথে সম্পৰ্ক</th>
                <th>নির্যাতনের ধরণ</th>
                <th>নির্যাতনের স্থান</th>
                <th>নির্যাতনকারীর নাম</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->safeties as $safety)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$safety->safety_victim_name}}</td>
                    <td>{{$safety->safety_relation_with_abuser}}</td>
                    <td>{{$safety->safety_type_of_abuse}}</td>
                    <td>{{$safety->safety_place_of_abuse}}</td>
                    <td>{{$safety->safety_abuser_name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{-- Help --}}
        <div class="double-table">
            <table width="100%" style="margin-right: 1rem">
                <caption>
                    <h3>সহায়তা</h3>
                </caption>
                <thead>
                <tr>
                    <th>প্রতিবেশীর সহায়তার ধরণ</th>
                    <th>ধনীদের সহায়তার ধরণ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        @foreach($data->neighbourHelps as $neighbourHelp)
                            {{$neighbourHelp->neighbour_help_type}}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($data->richHelps as $richHelps)
                            {{$richHelps->rich_help_type}}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        {{-- Conflict Resolves --}}
        <table width="100%" style="margin-right: 1rem">
            <caption>
                <h3>দ্বন্দ্ব মীমাংসা</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>দ্বন্দ্ব মীমাংসাকারক</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->conflictResolves as $conflictResolve)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$conflictResolve->conflict_resolve_type}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{-- Disasters --}}
        <table style="width: 100%">
            <caption>
                <h3>দূর্যোগ ও প্রতিকার</h3>
            </caption>
            <thead>
            <tr>
                <th width="50px">Sl No.</th>
                <th>দূর্যোগের ধরণ</th>
                <th>দূর্যোগের মাত্রা</th>
                <th>দূর্যোগের প্রতিকার</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->disasters as $disaster)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$disaster->disaster->name}}</td>
                    <td>{{$disaster->disaster_level}}</td>
                    <td>{{$disaster->recover->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
