@extends('dashboard::frame')

@section('title')
    Plugin Overview
@endsection

@section('information')
    Products are interfaces which can be switched on and off, allowing complete control of your system.
@endsection

@section('content')

    <div class="table-panel border light">

        <table id="table-datatables" class="table table-striped table-bordered table-hover row-border order-column">

        <thead>
        <tr>
            <th>Product Name</th>
            <th>Product Version</th>
            <th>Product Status</th>
            @if(account()->hasRole(App\Model\Role::SUPERUSER))
                <th>Dev. Action</th>
            @endif
        </tr>
        </thead>

        <tbody>

        @foreach($products as $product)

            <tr>

            <tr>
                <td>{{ ucfirst($product->name()) }}</td>
                <td>{{ $product->version() }}</td>
                <td>{!! bool2Status($product->isEnabled(), 'Enabled', 'Disabled') !!}</td>
                @if(account()->hasRole(App\Model\Role::SUPERUSER))
                    @if($product->isEnabled())
                        <td><a href="{{ route('ProductStatus', $product->name()) }}">Disable</a></td>
                    @else
                        <td><a href="{{ route('ProductStatus', $product->name()) }}">Enable</a></td>
                    @endif
                @endif
            </tr>

        @endforeach

        </tbody>
    </table>

    </div>

@endsection

@section('javascript')

    <script>
        $(document).ready(function(){
            $('#table-datatables').DataTable({
                'iDisplayLength': 50
            });
        });
    </script>

@endsection