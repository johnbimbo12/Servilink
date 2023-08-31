@foreach ($message as $msg)
{{-- <a  href="{{ route('message.details', $msg->id) }}"> --}}
    <tr class="{{ $msg->isread == 1 ? '' : 'unread' }}" onclick="window.location='{{ route('message.details', $msg->id) }}';">
        <td>
            <div class="checkbox m-t-0 m-b-0 ">
                <input type="checkbox" class="sub_chk" data-id="{{ $msg->id }}">
                <label></label>
            </div>
        </td>
        <td>{{ $msg->sender }}</td>
        <td class="hidden-xs">{{ $msg->title }}</td>
        <td class="max-texts"> <a href="{{ route('message.details', $msg->id) }}"> {!! Str::words($msg->request, 4, ' ...') !!}</a></td>
        </td>
        {{-- @if ($msg->attachment)
            <td class="hidden-xs"><i class="fa fa-paperclip"></i></td>
        @endif --}}
        <td class="text-right">{{ $msg->created_at->diffForHumans() }} </td>
        <td class="text-right"> <a href="{{ route('message.details', $msg->id) }}"
            title="View" ><i class="fa fa-eye text-success" style="font-size: 24px"></i></a> </td>
    </tr>
{{-- </a> --}}
@endforeach
