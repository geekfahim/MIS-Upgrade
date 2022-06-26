<table width="100%">
    <tbody>
    <tr>
        <td style="height: 20px">জীবিকা উন্নয়ন কেন্দ্রের নাম</td>
        <td colspan="3">{{ $data['project_name'] }}</td>
        @if(!isset($data['isImageNeed']))
            <td style="width: 120px; height: 120px" rowspan="5">
                @if($family->head->resource)
                    <img
                        src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path("storage/".\App\Models\Base\Mustahiq\Mustahiq::RESOURCE_PATH.'/'.$family->head->resource->name)))}}"
                        width="95%" height="95%"/>
                @else
                    <img
                        src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path(getDefaultAvatar())))}}"
                        width="95%" height="95%"/>
                @endif
            </td>
        @endif
    </tr>
    <tr>
        <td style="height: 20px">জিআরও এর নাম</td>
        <td colspan="3">{{ $data['gro'] ? $data['gro']->name : '' }}</td>
    </tr>
    <tr>
        <td style="height: 20px">জিআরও পরিবার পরিচিতি নাম্বার</td>
        <td colspan="3">{{ $data['gro'] ? $data['gro']->reference_id : '' }}</td>
    </tr>
    <tr>
        <td style="height: 20px">জিআরও পরিবার প্রতিনিধির নাম</td>
        <td colspan="3">{{ $family->head->name }}</td>
    </tr>
    <tr>
        <td>প্রতিনিধির ফোন নাম্বার</td>
        <td>{{ $family->head->mobile ?? 'N/A' }}</td>
        <td>প্রতিনিধির এনআইডি নাম্বার</td>
        <td>{{ $family->head->nid ?? 'N/A' }}</td>
    </tr>
    </tbody>
</table>
<table width="100%">
    <caption>
        <h3>পরিবার বর্গের বিবরণ</h3>
    </caption>
    <thead>
    <tr>
        <th width="50px">Sl No.</th>
        <th>পরিবার সদস্যের নাম</th>
        <th>বয়স</th>
        <th>পরিবার প্রধানের সাথে সম্পর্ক</th>
        <th>সর্বচ্চো শিক্ষাগত যোগ্যতা</th>
        <th>উপার্জন সামর্থ্য</th>
        <th>পেশা</th>
        <th>প্রতিবন্ধী</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($family['members'] as $member)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $member->mustahiq->name }}</td>
            <td>{{ $member->mustahiq->age }}</td>
            <td>{{ Str::replace('_', ' ', $member->relation_with_family_head) }}</td>
            <td>{{ $member->mustahiq->details->highest_education_level->value }}</td>
            <td>{{ $member->mustahiq->details->is_earn_ability ? 'Yes' : 'No' }}</td>
            <td>{{ $member->mustahiq->details->occupation ? $member->mustahiq->details->occupation->name : '' }}</td>
            <td>{{ $member->mustahiq->disability ? $member->mustahiq->disability->name : 'No' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
