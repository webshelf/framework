@extends('dashboard::frame')

@section('title')
    Frontend Menus
@endsection

@section('information')
    Menus are the heart of any website, menu navigation allows users to find the content they want with ease <br>
    A drag and drop interface allows you to manage row reordering with ease, moving the position column.<br>
    You must be aware that to create a menu with a linked page, you must first create the page. <a href="{{ route('admin.pages.create') }}">Click here to create one now</a>
@endsection

@section('content')

    <?php /** @var \App\Model\Page $page */ ?>
    <?php /** @var \App\Model\Menu $menu */ ?>

    <style>

        #view .form-group input, #view .form-group select {
            width: 100%;
        }
    </style>


    <div style="flex-direction: column; flex: 1;">

        @section('javascript')

            <script>

                $(document).ready(function(){
                    var menuOrder = $('.menuOrder').DataTable( {
                        rowReorder: true,
                        "bFilter": false,
                        "bLengthChange": false,
                        "bInfo" : false,
                        "bPaginate": false,
                        fixedHeader: true,
                        columnDefs: [
                            { orderable: true,  className: 'reorder', targets: 0 },
                            { orderable: false, targets: '_all' }
                        ]
                    });

                    menuOrder.on( 'row-reorder', function ( e, diff, edit ) {

                        result = [];

                        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                            var rowData = menuOrder.row(diff[i].node).data();
                            var html     = jQuery.parseHTML('<html><body>' + rowData[1] + '</body></html>');
                            result[i] = {slug: $(html).attr('data-slug'), n: diff[i].newData};
                        }

                        $.ajax({
                            type: "POST",
                            url: "{{ route('UpdateOrder') }}",
                            data: JSON.stringify(result),
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                toastr.success(response.message);
                            },
                            error: function(response) {
                                toastr.error('Something bad happened, please try again later.' + ' ' + response.code);
                            }
                        });
                    } );
                });

            </script>
        @append

        <div class="table-panel border light">

            <div class="title"><span class="blue">Menu</span> - Top Level</div>

            <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column menuOrder" cellpadding="0" cellspacing="0" style="width: 100%">

                <thead>
                <tr class="" role="row">
                    <th style="width: 141px;">Position</th>
                    <th style="width: 192px;">Text</th>
                    <th style="width: 200px;">Page</th>
                    <th style="width: 470px;">Anchor</th>
                    <th style="width: 135px;">Target</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 191px;">Modified</th>
                    <th style="width: 92px;">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($menus as $menu)

                    @if($menu->page)
                        @if($menu->page->enabled == false)
                            <tr role="row" class="odd" style="background-color: #FFF2F2">
                        @endif
                    @else
                        <tr role="row" class="odd">
                            @endif


                            @if($menu->required)

                                <td>
                                    {{ $menu->order_id }}
                                </td>
                                <td>
                                    <a id="title-{{ $menu->id }}" data-slug="{{ $menu->slug }}" data-name="title" data-type="text" data-pk="{{ $menu->id }}" data-url="/admin/menus/update">{{ $menu->title }}</a>
                                </td>

                                <td>
                                    {{ $menu->page->seo_title }}
                                </td>

                                <td>
                                    <a href="{{ makeUrl($menu->page) }}" target="_blank" title="Click to view : {{ makeUrl($menu->page) }}"><span style="color: #00A000">{{ makeUrl($menu->page) }}</span></a>
                                </td>

                                <td>
                                    {{ $menu->target }}
                                </td>

                                <td>
                                    {!! bool2Status($menu->enabled,'Published', 'Private') !!}
                                </td>

                                <td>
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="Last Modified {{ $menu->updated_at->diffForHumans() }}">{{ $menu->updated_at->format('F dS Y') }}</a>
                                </td>

                                <td>
                                    None
                                </td>

                            @else {{-- IF MENU IS NOT APPLICATION REQUIRED, AND USER CREATED.--}}

                            <td>
                                {{ $menu->order_id }}
                            </td>
                            <td>
                                <a id="title-{{ $menu->id }}" data-slug="{{ $menu->slug }}" data-name="title" data-type="text" data-pk="{{ $menu->id }}" data-url="/admin/menus/update">{{ $menu->title }}</a>
                            </td>

                            <td>
                                @if(!$menu->link)
                                    @if($menu->page->enabled == false)
                                        <a style='color: red' id="page-{{ $menu->id }}" data-name="PageID" data-value="{{ $menu->page->id }}" data-type="select" data-pk="{{ $menu->id }}" data-url="/admin/menus/update">{{ $menu->page->seo_title }} - Unpublished</a>
                                    @else
                                        <a id="page-{{ $menu->id }}" data-name="PageID" data-value="{{ $menu->page->id }}" data-type="select" data-pk="{{ $menu->id }}" data-url="/admin/menus/update">{{ $menu->page->seo_title }}</a>
                                    @endif
                                @endif
                            </td>

                            <td>
                                @if($menu->link)
                                    <a id='link-{{ $menu->id }}' data-name="link" data-type="text" data-pk="{{ $menu->id }}" data-url="/admin/menus/update">{{ $menu->link() }}</a>
                                @else
                                    <a href="{{ makeUrl($menu->page) }}" target="_blank" title="Click to view : {{ makeUrl($menu->page) }}"><span style="color: #00A000">{{ makeUrl($menu->page) }}</span></a>
                                @endif
                            </td>

                            <td>
                                <a id="target-{{ $menu->id }}" data-name="target" data-value="{{ $menu->target }}" data-pk="{{ $menu->id }}" data-url="/admin/menus/update">{{ $menu->target }}</a>
                            </td>

                            <td>
                                <a id="status-{{ $menu->id }}" data-name="status" data-value="{{ $menu->enabled }}" data-type="select" data-pk="{{ $menu->id }}" data-url="/admin/menus/update">{!! bool2Status( $menu->enabled, 'Published', 'Private') !!}</a>
                            </td>

                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Last Modified {{ $menu->updated_at->diffForHumans() }}">{{ $menu->updated_at->format('F dS Y') }}</a>
                            </td>

                            <td>
                                <a class="row_delete" href="{{ url('/admin/menus/delete/'.$menu->id) }}" style="color:red" type="button">Delete</a>
                            </td>
                            @endif

                        </tr>

                        @endforeach

                </tbody>

            </table>

        </div>

        <script>

            $(document).ready(function() {

                $('[id^=order]').editable({

                    type: 'select',
                    source: [
                            @foreach($menus as $key => $menu)
                        {
                            value: '{{ $key+1 }}', text: '{{ $key+1 }}'
                        },
                        @endforeach
                    ]

                });

            });

        </script>

        @foreach($submenu_group as $key => $submenus)

                @section('javascript')

                    <script>

                        $(document).ready(function(){
                            var submenu = $('.submenu-{{$key}}').DataTable( {
                                rowReorder: true,
                                "bFilter": false,
                                "bLengthChange": false,
                                "bInfo" : false,
                                "bPaginate": false,
                                columnDefs: [
                                    { orderable: true, className: 'reorder', targets: 0 },
                                    { orderable: false, targets: '_all' }
                                ]
                            });

                            submenu.on( 'row-reorder', function ( e, diff, edit ) {

                                result = [];

                                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                                    var rowData = submenu.row(diff[i].node).data();
                                    var html     = jQuery.parseHTML('<html><body>' + rowData[1] + '</body></html>');
                                    result[i] = {slug: $(html).attr('data-slug'), n: diff[i].newData};
                                }

                            $.ajax({
                                type: "POST",
                                url: "{{ route('UpdateOrder') }}",
                                data: JSON.stringify(result),
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    toastr.success(response.message);
                                    submenu.fnDraw();
                                },
                                error: function(response) {
                                    toastr.error('Something bad happened, please try again later.' + ' ' + response.code);
                                    submenu.fnDraw();
                                }
                            });
                        } );
                    });

                    </script>
                @append


            <div class="table-panel border light">

                <div class="title"><span class="green">Submenu</span> - {{$submenus[0]->parent->title}}</div>

                <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column submenu-{{$key}}" cellpadding="0" cellspacing="0" style="width: 100%">

                <thead>
                    <tr class="" role="row">
                        <th style="width: 141px;">Position</th>
                        <th style="width: 192px;">Text</th>
                        <th style="width: 200px;">Page</th>
                        <th style="width: 470px;">Anchor</th>
                        <th style="width: 135px;">Target</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 191px;">Modified</th>
                        <th style="width: 92px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                        @foreach($submenus as $submenu)


                            @if($submenu->isExternal(false) && $submenu->page->enabled == false)
                                <tr role="row" class="odd" style="background-color: #FFF2F2">
                            @else
                                <tr role="row" class="odd">
                            @endif

                                    <td>
                                        {{ $submenu->orderID() }}
                                    </td>
                                    <td>
                                        <a id="title-{{ $submenu->id() }}" data-slug="{{ $submenu->slug() }}" data-name="title" data-type="text" data-pk="{{ $submenu->id() }}" data-url="/admin/menus/update">{{ $submenu->title() }}</a>
                                    </td>
                                    <td>

                                        @if($submenu->isExternal(false))
                                            @if($submenu->page->enabled == false)
                                                <a style='color:red' id="page-{{ $submenu->id() }}" data-name="PageID" data-value="{{ $submenu->page->id }}" data-type="select" data-pk="{{ $submenu->id() }}" data-url="/admin/menus/update">{{ $submenu->pageTitle() }} - Unpublished</a>
                                            @else
                                                <a id="page-{{ $submenu->id() }}" data-name="PageID" data-value="{{ $submenu->page->id }}" data-type="select" data-pk="{{ $submenu->id() }}" data-url="/admin/menus/update">{{ $submenu->pageTitle() }}</a>
                                            @endif
                                        @endif

                                    </td>
                                    <td>
                                        @if($submenu->belongsToPage())
                                            <a href="{{ makeUrl($submenu->page)}}" target="_blank" title="Click to view : {{ makeUrl($submenu->page) }}"><span style="color: #00A000">{{ makeUrl($submenu->page) }}</span></a>
                                        @else
                                            <a id='link-{{ $submenu->id() }}' data-name="link" data-type="text" data-pk="{{ $submenu->id() }}" data-url="/admin/menus/update">{{ $submenu->link() }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a id="target-{{ $submenu->id() }}" data-name="target" data-value="{{ $submenu->target() }}" data-pk="{{ $submenu->id() }}" data-url="/admin/menus/update">{{ $submenu->target() }}</a>
                                    </td>
                                    <td>
                                        <a id="status-{{ $submenu->id() }}" data-name="status" data-value="{{ $submenu->isEnabled() }}" data-type="select" data-pk="{{ $submenu->id() }}" data-url="/admin/menus/update">{!! bool2Status( $submenu->isEnabled()) !!}</a>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="Last Modified {{ $menu->updated_at->diffForHumans() }}">{{ $menu->updated_at->format('F dS Y') }}</a>
                                    </td>
                                    <td>
                                        @if($submenu->slug() != 'index')
                                            <a class="row_delete" href="{{ url('/admin/menus/delete/'.$menu->id) }}" style="color:red" type="button">Delete</a>
                                        @else
                                            Cannot Delete
                                        @endif
                                    </td>
                                </tr>

                                @endforeach
                        </tbody>

        </table>

            </div>

            <script>

                $(document).ready(function(){

                $('[id^=order]').editable({

                    type: 'select',
                    source: [
                            @foreach($submenus as $key => $menu)
                        {value:'{{ $key+1 }}', text: '{{ $key+1 }}'},
                        @endforeach
                    ]

                });

            });

            </script>

        @endforeach

    </div>


@endsection

@section('javascript')

    <script>
        $("a.row_delete").click(function(event) {
            event.preventDefault();
            var href = $(this).attr('href');
            alert('clicked');
            $.ajax({
                url: href,
                type: 'post',
                data: { _token: "{{ csrf_token() }}" },
                complete: function(){
                    location.reload();
                }
            });
        });
    </script>

    <script>

        $(document).ready(function(){

            //        $.fn.editable.defaults.mode = 'inline';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : "{{ csrf_token() }}",
                }
            });

            $(document).ready(function() {

                $('[id^=title]').editable({
                    type: 'text',
                    url: '/post',
                    placement: 'top',
                    title: 'Change the title name',

                    success: function(response) {
                        if (response.error)
                            return response.error.message;
                    }
                });

                $('[id^=link]').editable({
                    type: 'text',
                    url: '/post',
                    placement: 'top',
                    title: 'Change the external url',

                    success: function(response) {
                        if (response.error)
                            return response.error.message;
                    }
                });

                $('[id^=target]').editable({

                    type: 'select',
                    placement: 'top',
                    title: 'Change the browser target',
                    source: [
                        {value:"_self",  text:"_self"},
                        {value:"_blank", text:"_blank"}
                    ]

                });

                $('[id^=status]').editable({

                    type: 'select',
                    placement: 'top',
                    title: 'Change the menu status',
                    source: [
                        {value:0, text: 'Private'},
                        {value:1, text: 'Published'}
                    ],
                    success: function() {
                        $(location).attr('href', '{{ route('menus') }}')
                    }

                });


                $('[id^=page]').editable({
                    type: 'select',
                    placement: 'top',
                    title: 'Change the attached page data',
                    source: [
                            @foreach($pages as $page)
                            @if($page->enabled)
                        {value:"{{ $page->id }}", text: "{{ ucwords($page->seo_title) }}"},
                            @else
                        {value:"{{ $page->id }}", text: "{{ ucwords($page->seo_title) }} - Unpublished"},
                        @endif
                        @endforeach
                    ],
                    success: function() {
                        $(location).attr('href', '{{ route('menus') }}')
                    }
                });

                $('#enabled').editable({
                    url: '/post',
                    pk: 1,
                    value: 1,
                    source: [{ value:1, text: "Yes"}, { value:2, text: "No"}],
                    title: 'Select1',
                    success: function(response, newValue) {
                        $('#enabled').editable('option', 'source', sources[newValue]);
                        $('#enabled').editable('setValue', 'test');
                    }
                });
            });

        });

    </script>

@endsection