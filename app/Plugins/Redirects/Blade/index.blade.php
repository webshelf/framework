@extends('dashboard::frame')

@section('javascript')

    <script>
        $(document).ready(function(){
            $('#table-datatables').DataTable({
                'iDisplayLength': 25
            });
        });
    </script>

@endsection

@section('information')
    <p>Redirects help you and your users from visiting pages which are no longer in use or functional, a core component to a website, is the ability to control
        where your users go.<br>
        Please be aware that redirecting your site links can cause a small delay to page loading (<700ms)</p>
@endsection

@section('content')

    <div class="table-panel border light">


        <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column">

            <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Creation Date</th>
                <th>Status</th>
                <th>Action</th>
                <th>Creator</th>
            </tr>
            </thead>

            <tbody>
            @foreach($redirects as $redirect)
                <tr>
                    <td><a href="{{ url($redirect->from()) }}" style="color:#677582">{{ url($redirect->from()) }}</a></td>
                    <td><a href="{{ url($redirect->to()) }}" style="color:green">{{ url($redirect->to()) }}</a></td>
                    <td><a href="#" data-toggle="tooltip" data-placement="bottom" title="Last Modified {{ $redirect->updated_at()->diffForHumans() }}">{{ $redirect->updated_at()->format('F dS Y') }}</a></td>
                    <td>{!! bool2Status($redirect->isEnabled()) !!}</td>
                    <td>
                        <a href="#" data-remodal-target="{{$redirect->id()}}" style="color:red" type="button">Delete</a>
                        <div class="remodal" data-remodal-id="{{$redirect->id()}}">
                            <button data-remodal-action="close" class="remodal-close"></button>
                            <h1>Removing Redirect</h1>
                            <p>
                                You are about to remove the redirect for {{ $redirect->from() }}
                            </p>
                            <br>
                            <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
                            <button data-remodal-action="confirm" v-on:click="ajaxDelete('{{ url('/admin/redirect/delete/'.$redirect->id()) }}', '{{ route('redirects') }}')" class="remodal-confirm">Confirm</button>
                        </div>
                    </td>
                    <td>
                        <i class="fa profile-image small" aria-hidden="true">
                            <img src="{{$redirect->lastEditor->gravatarImageUrl() }}" width="24" height="24" alt="profile image">
                        </i>
                        <span class="margin-left-medium">{{ $redirect->lastEditor->fullName() }} [{{ $redirect->lastEditor->role->title() }}]</span>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>

@endsection