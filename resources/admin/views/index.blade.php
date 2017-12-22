@extends('dashboard::frame')

@section('content')
    <div class="overview">

        <div class="avatar">

            <img src="{{ url(settings()->getDefault('website_logo')) }}">

        </div>

        <div class="title">

            <h3>{{ settings()->getDefault('website_name') }}</h3>

        </div>

        <div class="buttons">


        </div>

    </div>

    <hr>

        <p class="text-center">{{ url('/') }}</p>

    <hr>

    <div class="webshelf-table">

        @foreach ($audits as $audit)

            <?php  /** @var \App\Model\Audit $audit */ ?>

                @if ($audit->auditable)

                <div class="row">

                <div class="details">
                    <div class="title">
                            @if (! $audit->user)
                                <a href="{{ $audit->auditable->auditUrl() }}">{{ $audit->auditable->auditTitle() }}</a> {{ $audit->beforeActionVerb() }} by the CMS.
                            @else
                                <span style="font-weight: 400; color:#0c82dc;">{{ $audit->user->fullName() }}</span> {{ $audit->afterActionVerb() }} {{ $audit->model() }} <a href="{{ $audit->auditable->auditUrl() }}">{{ $audit->auditable->auditTitle() }}</a>
                            @endif
                    </div>
                </div>

                <div class="stats">
                    <div class="timestamp">
                        updated {{ $audit->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            @endif

        @endforeach

        {{ $audits->links() }}

    </div>


@endsection