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
        <h2 class="center">Family's Full Report</h2>
        <table class="table-borderless">
            <caption>
                <h3 class="underline">পরিবারের তথ্য</h3>
            </caption>
            <tbody>
                <tr>
                    <th>প্রজেক্ট</th>
                    <td>:</td>
                    <td>Test Project 1</td>
                    <th>জিআরও</th>
                    <td>:</td>
                    <td>GRO-1</td>
                    <th>স্পনর</th>
                    <td>:</td>
                    <td>Test Sponsor</td>
                    <th>পরিবারের প্রধান</th>
                    <td>:</td>
                    <td>Male</td>
                    <th>বসতবাড়ির জমির ধরন</th>
                    <td>:</td>
                    <td>Self Owned</td>
                </tr>
                <tr>
                    <th>বসতবাড়ির ধরন</th>
                    <td>:</td>
                    <td>Mud House</td>
                    <th>বসতবাড়ির স্থান</th>
                    <td>:</td>
                    <td>City</td>
                    <th>খাবার পানি</th>
                    <td>:</td>
                    <td>Tubewell</td>
                    <th>অন্যান্য কাজে ব্যাবরিত পানি</th>
                    <td>:</td>
                    <td>Pond Water</td>
                    <th>সৌচাগারের ধরন</th>
                    <td>:</td>
                    <td>Bathroom</td>
                </tr>
                <tr>
                    <th>সৌচাগারের মালিক</th>
                    <td>:</td>
                    <td>Self Owned</td>
                    <th>রান্নার জ্বালানি</th>
                    <td>:</td>
                    <td>Wood Straw</td>
                    <th>বৈদ্যুতিক সংযোগ</th>
                    <td>:</td>
                    <td>Has Connectivity</td>
                    <th>মোট কক্ষ</th>
                    <td>:</td>
                    <td>2</td>
                    <th>পরিবারের রেফারেন্স নাম্বার</th>
                    <td>:</td>
                    <td>fsdfsd1118187</td>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%" class="table-borderless">
            <caption>
                <h3 class="underline">পরিবার বর্গের বিবরণ</h3>
            </caption>
            <thead>
                <tr>
                    <th>নাম</th>
                    <td class="w-1">:</td>
                    <td>Md Mahfuzur Rahman</td>
                    <th>লিঙ্গ</th>
                    <td class="w-1">:</td>
                    <td>Male</td>
                    <th>ই-মেইল</th>
                    <td class="w-1">:</td>
                    <td>someone1453782785272@gmail.com</td>
                    <th>মোবাইল</th>
                    <td class="w-1">:</td>
                    <td>+880175121346</td>
                    <th>বিকল্প নাম্বার</th>
                    <td class="w-1">:</td>
                    <td>+880175171346</td>
                </tr>
                <tr>
                    <th>জরুরী নাম্বার</th>
                    <td class="w-1">:</td>
                    <td>+880175121348</td>
                    <th>জাতীয় পরিচয়পত্র</th>
                    <td class="w-1">:</td>
                    <td>451822320481488</td>
                    <th>পাসপোর্ট</th>
                    <td class="w-1">:</td>
                    <td>1188dsf245418155</td>
                    <th>জন্মতারিখ</th>
                    <td class="w-1">:</td>
                    <td>12-12-1950</td>
                    <th>জন্ম সনদ</th>
                    <td class="w-1">:</td>
                    <td>1598496</td>
                </tr>
                <tr>
                    <th>বয়স</th>
                    <td class="w-1">:</td>
                    <td>120</td>
                    <th>ধর্ম</th>
                    <td class="w-1">:</td>
                    <td>Islam</td>
                    <th>রেফারেন্স নাম্বার</th>
                    <td class="w-1">:</td>
                    <td>124524545245524445</td>
                    <th>রক্তের গ্রুপ</th>
                    <td class="w-1">:</td>
                    <td>AB+</td>
                    {{-- <th>রক্তদাতা</th>
                    <td class="w-1">:</td>
                    <td>Yes</td> --}}
                </tr>
                <tr>
                    <th>রোগের নাম</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>প্রাত্যহিক ওষুধ সেবন</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>প্রতিবন্ধী ধরণ</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>পরিবার প্রধানের সাথে সম্পর্ক</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>সর্বোচ্চ্য শিক্ষাগত যোগ্যতা</th>
                    <td class="w-1">:</td>
                    <td>Doctor of Philosophy</td>
                </tr>
                <tr>
                    <th>উপার্জন সামর্থ্য</th>
                    <td class="w-1">:</td>
                    <td>yes</td>
                    <th>পেশা</th>
                    <td class="w-1">:</td>
                    <td>Software Engineer Database Admin</td>
                    <th>প্রতিবন্ধী</th>
                    <td class="w-1">:</td>
                    <td>No</td>
                    <th>স্থায়ী ঠিকানা</th>
                    <td class="w-1">:</td>
                    <td>F-222/1,Joarpukur Road,North Chayabithy, Joydebpur, Gazipur, Dhaka, Bangladesh</td>
                    <th>স্থায়ী বিভাগ</th>
                    <td class="w-1">:</td>
                    <td>Dhaka(Jahangir Nagar)</td>
                </tr>
                <tr>
                    <th>স্থায়ী জেলা</th>
                    <td class="w-1">:</td>
                    <td>Gazipur</td>
                    <th>স্থায়ী থানা</th>
                    <td class="w-1">:</td>
                    <td>Joydebpur</td>
                    <th>স্থায়ী ইউনিয়ন</th>
                    <td class="w-1">:</td>
                    <td>Uttar Chayabithy</td>
                    <th>স্থায়ী পোস্ট কোড</th>
                    <td class="w-1">:</td>
                    <td>1700</td>
                    <th>বর্তমান ঠিকানা</th>
                    <td class="w-1">:</td>
                    <td>F-222/1,Joarpukur Road,North Chayabithy, Joydebpur, Gazipur, Dhaka, Bangladesh</td>
                </tr>
                <tr>
                    <th>বর্তমান বিভাগ</th>
                    <td class="w-1">:</td>
                    <td>Dhaka</td>
                    <th>বর্তমান জেলা</td>
                    <td class="w-1">:</td>
                    <td>Joydebpur</td>
                    <th>বর্তমান থানা</th>
                    <td class="w-1">:</td>
                    <td>Joydebpur</td>
                    <th>বর্তমান ইউনিয়ন</th>
                    <td class="w-1">:</td>
                    <td>Uttar Chayabithy</td>
                    <th>বর্তমান পোস্ট কোড</th>
                    <td class="w-1">:</td>
                    <td>1700</td>
                </tr>
                <tr>
                    <th>বাবার নাম</th>
                    <td class="w-1">:</td>
                    <td>Mizanur Rahman Khan</td>
                    <th>বাবার ফোন</th>
                    <td class="w-1">:</td>
                    <td>016752562628</td>
                    <th>বাবার অবস্থা</th>
                    <td class="w-1">:</td>
                    <td>Dead</td>
                    <th>মা নাম</th>
                    <td class="w-1">:</td>
                    <td>Mrs Mizanur Rahman Khanam</td>
                    <th>মা ফোন</th>
                    <td class="w-1">:</td>
                    <td>0165259594946</td>
                </tr>
                <tr>
                    <th>মা অবস্থা</th>
                    <td class="w-1">:</td>
                    <td>Dead</td>
                    <th>বৈবাহিক অবস্থা</th>
                    <td class="w-1">:</td>
                    <td>Married</td>
                    <th>স্বামী/স্ত্রী নাম</th>
                    <td class="w-1">:</td>
                    <td>Mrs Munia Islam Khan</td>
                    <th>স্বামী/স্ত্রী ফোন</th>
                    <td class="w-1">:</td>
                    <td>0171115569659</td>
                    <th>কারিগরী প্রশিক্ষণ আছে</th>
                    <td class="w-1">:</td>
                    <td></td>
                </tr>
                <tr>
                    <th>কারিগরী প্রশিক্ষণ প্রয়োজন</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>দক্ষতা প্রশিক্ষণ আছে</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>দক্ষতা প্রশিক্ষণ প্রয়োজন</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>পেশা</th>
                    <td class="w-1">:</td>
                    <td></td>
                    <th>পেশার পদবী</th>
                    <td class="w-1">:</td>
                    <td>Managing Director</td>
                </tr>
                <tr>
                    <th>অনাথ</th>
                    <td class="w-1">:</td>
                    <td>Father's Died</td>
                    <th>প্রেগ্নেন্সি অবস্থা</th>
                    <td class="w-1">:</td>
                    <td>N/A</td>
                    <td>Business</td>
                    <th>মাসিক আয়</th>
                    <td class="w-1">:</td>
                    <td>120000</td>
                </tr>
                <tr>
                    <th>মন্তব্য</th>
                    <td>:</td>
                    <td colspan="10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure possimus temporibus neque
                        saepe qui quas aperiam doloribus reprehenderit dignissimos officia, cupiditate suscipit iusto sed
                        quia repellendus unde, itaque natus numquam tempora alias explicabo ducimus eum illo blanditiis?
                        Nostrum minus quaerat fuga necessitatibus itaque placeat! Corrupti ipsum nemo quam aliquid
                        consequuntur tenetur maiores, rerum sit corporis quo, blanditiis ipsa eum qui iure laudantium?
                        Dolorem unde reprehenderit architecto, adipisci laudantium iusto quidem!</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

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
                <tr>
                    <td>1</td>
                    <td>Agro Land</td>
                    <td>চাকা</td>
                    <td>2</td>
                    <td>
                        <span class="bdt">12,000</span>
                    </td>
                </tr>
                <tr>
                    <th colspan="4">মোট সম্পদের পরিমান </th>
                    <td style="font-weight: bold">12,000</td>
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
                <tr>
                    <td>1</td>
                    <td>10 Oct 2019</td>
                    <td>Grameen Bank</td>
                    <td>5,10,00</td>
                    <td>2%</td>
                    <td>5000</td>
                    <td>Dowry</td>
                    <th>
                        1,20,000
                    </th>
                </tr>
                <tr>
                    <th colspan="3">মোট ঋণের পরিমান </th>
                    <td style="font-weight: bold">5,10,00</td>
                    <th colspan="3">মোট বর্তমান ঋণের স্থিতি</th>
                    <td style="font-weight: bold"> 1,20,000</td>
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
                <tr>
                    <td>1</td>
                    <td>Farming</td>
                    <td>
                        1,40,000
                    </td>
                </tr>
                <tr>
                    <th colspan="2">মোট আয়ের পরিমান </th>
                    <td style="font-weight: bold"></td>
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
                    <th>ব্যায়ের পরিমান </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Family Expense</td>
                    <td>
                        5000
                    </td>
                </tr>
                <tr>
                    <th colspan="2">মোট ব্যায়ের পরিমান </th>
                    <td style="font-weight: bold"></td>
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
                <tr>
                    <td>1</td>
                    <td>Self Savings</td>
                    <td>20,000</td>
                </tr>
                <tr>
                    <th colspan="2">মোট সঞ্চয়ের পরিমান </th>
                    <td style="font-weight: bold"></td>
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
                <tr>
                    <td>1</td>
                    <td>Red Crescent</td>
                    <td>Health</td>
                </tr>
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
                <tr>
                    <td>1</td>
                    <td>Mrs Raj</td>
                    <td>Neigbour</td>
                    <td>Beating</td>
                    <td>Dhaka</td>
                    <td>Mr Lorem</td>
                </tr>
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
                        <th width="50px">Sl No.</th>
                        <th>প্রতিবেশীর সহায়তার ধরণ</th>
                        <th>ধনীদের সহায়তার ধরণ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Food</td>
                        <td>Help in Disaster</td>
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
                <tr>
                    <td>1</td>
                    <td>Food</td>
                </tr>
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
                <tr>
                    <td>1</td>
                    <td>Cyclone</td>
                    <td>Major</td>
                    <td>Not Recovered</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
